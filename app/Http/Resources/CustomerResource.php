<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'address' => $this->address,
            'dob' => $this->dob,
            'email'=> $this->email,
            'gender' => $this->gender,
            'id'=> $this->id,
            'name' => $this->name,
            'phone' => $this->phone,
            'fields' => $this->Fields
        ];
    }
}
