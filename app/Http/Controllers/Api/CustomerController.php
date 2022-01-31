<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CustomerResource;
use App\Models\Customer;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new CustomerResource(Customer::with('Fields')->findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validateWith([
            'phone' => 'numeric',
            'dob'   => 'date',
            'email' => 'email',
        ]);

        try {
            DB::beginTransaction();
            $customer = Customer::find($id);
            $customer->name = $request->name;
            $customer->address = $request->address;
            $customer->phone = $request->phone;
            $customer->dob = $request->date;
            $customer->email = $request->email;
            $customer->gender = $request->gender;
            $customer->save();

            $customer_field_array = [];
            foreach ($request->fields as $field) {

                array_push($customer_field_array, [
                    'field_id' => $field['pivot']['field_id'],
                    'view' => $field['pivot']['view']
                ]);
            }

            $cases = [];
            $field_ids = [];

            DB::table('customer_field')->where('customer_id', $id)->get();
            foreach ($customer_field_array as $customer_field) {
                $field_ids[] = $customer_field['field_id'];
                $field_id = $customer_field['field_id'];
                $view = $customer_field['view'];

                $cases[] = "WHEN field_id = {$field_id} AND customer_id={$id} then '{$view}'";
            }
            $field_ids = implode(',', $field_ids);
            $cases = implode(' ', $cases);
            $dml = "UPDATE customer_field SET `view` = CASE  {$cases} ELSE `view` END WHERE  `field_id` in ({$field_ids})";
            DB::update($dml);
            DB::commit();
            return new CustomerResource($customer);
        } catch (Exception $exception) {
            DB::rollBack();
            var_dump($dml);
            return response($exception, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
