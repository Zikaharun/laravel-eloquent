<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $tag = new Tag();
        $tag->id = '1';
        $tag->name = 'Muhamad Alzika';
        $tag->save();

        $product = Product::find('1');
        $product->tags()->attach($tag);
    }
}
