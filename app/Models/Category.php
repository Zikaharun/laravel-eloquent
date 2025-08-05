<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categories'; // Specify the table name if it's not the plural form of the model name
    protected $primaryKey = 'id'; // Specify the primary key if it's not 'id
    protected $keyType = 'string'; // Specify the key type as string since 'id
    public $incrementing = false; // Set to false if the primary key is not auto
    public $timestamps = true; // Enable timestamps if you want to use created_at and updated_at fields

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id'); // Define the relationship with the Product model
    }

    public function cheapestProduct()
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->oldest('price');

    }

    public function mostExpensiveProduct()
    {
        return $this->hasOne(Product::class, 'category_id', 'id')->latest('price');
    }

    public function reviews()
    {
        return $this->hasManyThrough(Review::class, Product::class,
        'category_id',
        'product_id',
        'id',
        'id'
    );
    }
}
