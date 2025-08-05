<?php

namespace Database\Seeders;

use App\Models\Wallet;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WalletSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $wallet = new Wallet();
        $wallet->amount = 1000000000; // Set initial amount
        $wallet->customer_id = '1'; // Assuming customer with ID '1' exists
        $wallet->save();
    }
}
