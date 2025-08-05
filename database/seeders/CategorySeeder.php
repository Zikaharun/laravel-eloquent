<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $category = new Category();
        $category->id = '1'; // UUID can be generated automatically if you set it
        $category->name = 'Personal';
        $category->description = 'Personal journals and notes.';
        $category->save();
    }
}
