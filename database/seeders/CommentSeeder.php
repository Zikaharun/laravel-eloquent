<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $product = Product::find('1');
        $comment = new Comment();
        $comment->comments = 'comment product';
        $comment->commentable_id = $product->id;
        $comment->commentable_type = 'product';
        $comment->save();
    }
}
