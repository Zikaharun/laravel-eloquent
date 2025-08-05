<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Wallet;
use Database\Seeders\CategorySeeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\ImageSeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\VirtualAccountSeeder;
use Database\Seeders\WalletSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class CustomerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    use RefreshDatabase;

public function testOneToOne()
{
    $this->seed([CustomerSeeder::class, WalletSeeder::class]);

    $customer = Customer::find('1');
    $this->assertNotNull($customer);

    $wallet = $customer->wallet;
    $this->assertNotNull($wallet);

    $this->assertEquals(1000000000, $wallet->amount);

}

public function testOneToOneQueryBuilderRelationship()
{
    $customer = new Customer();
    $customer->id = '1';
    $customer->name = 'John Doe';
    $customer->email = 'John_doe@localhost';
    $customer->save();

    $wallet = new Wallet();
    $wallet->amount = 1000000000;
    $customer->wallet()->save($wallet);

    $this->assertNotNull($wallet->customer_id);
}

public function testHasOneThrough()
{
    $this->seed([CustomerSeeder::class, WalletSeeder::class, VirtualAccountSeeder::class]);

    $customer = Customer::find('1');
    $this->assertNotNull($customer);

    $virtualAccount = $customer->virtualAccount;

    $this->assertNotNull($virtualAccount);
    $this->assertEquals('BCA', $virtualAccount->bank);
}

    public function testManyToMany()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::find('1');
        $this->assertNotNull($customer);

        $customer->likeProducts()->attach('1');

        $products = $customer->likeProducts;
        $this->assertCount(1, $products);

        $this->assertEquals('1', $products[0]->id);
    }

    public function testManyToManyDetach()
    {
        $this->seed([CustomerSeeder::class, CategorySeeder::class, ProductSeeder::class]);

        $customer = Customer::find('1');
        $this->assertNotNull($customer);

        $customer->likeProducts()->detach('1');

        $products = $customer->likeProducts;
        $this->assertCount(0, $products);

        
    }

    public function testPivotAttribute()
    {
        $this->testManyToMany();

        $customer = Customer::find('1');
        $products = $customer->likeProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            $this->assertNotNull($pivot);
            $this->assertNotNull($pivot->customer_id);
            $this->assertNotNull($pivot->product_id);
            $this->assertNotNull($pivot->created_at);
        }
    }

    public function testPivotAttributeCondition()
    {
        $this->testManyToMany();

        $customer = Customer::find('1');
        $products = $customer->likeProductsLastWeek;

        foreach ($products as $product) {
            $pivot = $product->pivot;
            $this->assertNotNull($pivot);
            $this->assertNotNull($pivot->customer_id);
            $this->assertNotNull($pivot->product_id);
            $this->assertNotNull($pivot->created_at);
        }
    }

        public function testPivotModel()
    {
        $this->testManyToMany();

        $customer = Customer::find('1');
        $products = $customer->likeProducts;

        foreach ($products as $product) {
            $pivot = $product->pivot; // objek model like
            $this->assertNotNull($pivot);

            $customer =$pivot->customer;
            $this->assertNotNull($pivot->customer_id);

            $products = $pivot->product;
            $this->assertNotNull($pivot->product_id);
            $this->assertNotNull($pivot->created_at);
        }
    }

    public function testOneToOnePolymorphic()
    {
        $this->seed([CustomerSeeder::class, ImageSeeder::class]);

        $customer = Customer::find('1');
        $this->assertNotNull($customer);

        $image = $customer->image;
        $this->assertNotNull($image);
        $this->assertEquals('https://www.muhamadalzika.com/image/1.png', $image->url);
        
    }

    public function testEager()
    {
        $this->seed([CustomerSeeder::class, WalletSeeder::class, ImageSeeder::class]);

        $customer = Customer::with(['wallet', 'image'])->find('1');
        $this->assertNotNull($customer);
    }

    
}
