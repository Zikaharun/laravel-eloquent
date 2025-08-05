<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Image;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        {

        
        $image = new Image();
        $image->url = 'https://www.muhamadalzika.com/image/1.png';
        $image->imageable_id = '1';
        $image->imageable_type = 'customer';
        $image->save();
        }
        {
        $image = new Image();
        $image->url = 'https://www.muhamadalzika.com/image/2.png';
        $image->imageable_id = '2';
        $image->imageable_type = 'product';
        $image->save();
        }
    }
}
