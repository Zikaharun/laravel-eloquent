<?php

namespace Tests\Feature;

use App\Models\Product;
          use App\Models\Category;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\ReviewSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

    public function testOneToMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]); // Seed the database with initial data if needed
        $category = Category::find('1'); // Assuming '1' is a valid category ID

        $this->assertNotNull($category);


        $products = $category->products; // Get the products associated with the category
        $this->assertNotNull($products);
        $this->assertCount(2, $products); 
    }

    public function testOneToManyQueryBuilderRelationship()
    {
        $category = new Category();
        $category->id = '1';
        $category->name = 'Sample Category';
        $category->description = 'Category';
        $category->save();

        $product = new Product();
        $product->id = '1';
        $product->name = 'Sample Product';
        $product->description = 'This is a sample product description.';
        $product->price = 100.00; // Set the price of the product
        $product->category_id = '1'; // Assuming category with ID '1' exists
        $category->products()->save($product); // Save the product associated with the category

        $this->assertNotNull($product->category_id);

    }


    public function testRelationshipQuery()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);
        $category = Category::find('1'); // Assuming '1' is a valid category ID
        $products = $category->products; // Get the products associated with the category
        $this->assertNotNull($products);

        $outOfStockProducts = $category->products()->where('stock', '<=', 0)->get(); // Get products with stock less than or equal to 0
        $this->assertCount(2, $outOfStockProducts); // Assuming there are

    }

    public function testHasOneOfMany()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('1');
        $cheapestProduct = $category->cheapestProduct;
        $this->assertNotNull($cheapestProduct);
        $this->assertEquals('2', $cheapestProduct->id);

        $mostExpensiveProduct = $category->mostExpensiveProduct;
        $this->assertNotNull($mostExpensiveProduct);
        $this->assertEquals('1', $mostExpensiveProduct->id);
    }

    public function testHasManyThrough()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class, CustomerSeeder::class, ReviewSeeder::class]);

        $category = Category::find('1');
        $this->assertNotNull($category);

        $reviews = $category->reviews;
        $this->assertNotNull($reviews);
        $this->assertCount(2, $reviews);
    }

    public function testQueryingRelations()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('1');
        $products = $category->products()->where('price', '=', 100.00)->get();

        $this->assertCount(1, $products);
    }

    public function testQueryingRelationsAggregate()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $category = Category::find('1');
        $totalProduct = $category->products()->count();

        $this->assertEquals(2, $totalProduct);
    }

    public function testEloquentCollection()
    {
        $this->seed([CategorySeeder::class, ProductSeeder::class]);

        $products = Product::get();
        $this->assertCount(2, $products);

        $products = $products->toQuery()->where('price', '=', 100.00)->get();
        $this->assertCount(1, $products);
    }
}

