<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $customer = new Customer();
        $customer->id = '1'; // UUID can be generated automatically if you set it
        $customer->name = 'John Doe';
        $customer->email = 'John_doe@localhost';
        $customer->save();
    }

    


}
