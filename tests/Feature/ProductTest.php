<?php

namespace Tests\Feature;

use App\Models\Product;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\TagSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $product = Product::find('1'); // Assuming '1' is a valid product ID
        $this->assertNotNull($product);

        $category = $product->category; // Get the category associated with the product
        $this->assertNotNull($category);

        $this->assertEquals('Sample Product', $product->name);
    }

    public function testOneToOnePolymorphic()
    {
        $this->seed([ CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $product = Product::find('2');
        $this->assertNotNull($product);

        $image = $product->image;
        $this->assertNotNull($image);

        $this->assertEquals('https://www.muhamadalzika.com/image/2.png', $image->url);
    }

    public function testOneToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, CommentSeeder::class]);

        $product = Product::find('1');
        $comments = $product->comments;

        $this->assertCount(1, $comments);
        foreach ($comments as $comment) {
            $this->assertEquals('product', $comment->commentable_type);
            $this->assertEquals($product->id, $comment->commentable_id);
        }
    }

    public function testOneOfManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, CommentSeeder::class]);
        $product = Product::find('1');
        $comments = $product->latestComment;

        $this->assertNotNull($comments);
        $oldestComment = $product->oldestComment;

        $this->assertNotNull($oldestComment);
    }

    public function testManyToManyPolymorphic()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, TagSeeder::class]);

        $product = Product::find('1');
        $tags = $product->tags;
        $this->assertNotNull($tags);
        $this->assertCount(1,$tags);

        foreach ($tags as $tag) {
            $this->assertNotNull($tag->id);
            $this->assertNotNull($tag->name);
        }
    }

    public function testSerialization()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $products = Product::get();
        $this->assertCount(2, $products);

        $json = $products->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }

     public function testSerializationRelation()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, ImageSeeder::class]);

        $products = Product::get();

        $products->load(['category', 'image']);
        $this->assertCount(2, $products);

        $json = $products->toJson(JSON_PRETTY_PRINT);
        Log::info($json);
    }
}
