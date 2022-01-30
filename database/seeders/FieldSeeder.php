<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fields')->insert(
            [
                [
                    'name' => 'Name',
                    'type'  => 'text'
                ],
                [
                    'name' => 'DOB',
                    'type'  => 'date'
                ],
                [
                    'name' => 'Phone Number',
                    'type'  => 'phone'
                ],
                [
                    'name' => 'Gender',
                    'type'  => 'radio'
                ],
                [
                    'name' => 'Address',
                    'type'  => 'multiline'
                ],
                [
                    'name' => 'Email',
                    'type'  => 'text'
                ],
            ]
        );
    }
}
