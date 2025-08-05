<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $product = new Product();
        $product->id = '1'; // UUID can be generated automatically if you set it in the model
        $product->name = 'Sample Product';
        $product->description = 'This is a sample product description.';
        $product->price = 100.00; // Set the price of the product
        $product->category_id = '1'; // Assuming category with ID '1' exists
        $product->save();

        $product2 = new Product();
        $product2->id = '2';
        $product2->name = 'product 2';
        $product2->description = 'description 2';
        $product2->price = 50.00;
        $product2->category_id = '1';
        $product2->save();

    }
}
