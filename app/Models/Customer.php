<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Date;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers'; // Specify the table name if it's not the plural form of the model name
    protected $primaryKey = 'id'; // Specify the primary key if it's not 'id
    protected $keyType = 'string'; // Specify the key type as string since 'id' is a string
    public $incrementing = false; // Set to false if the primary key is not auto
    public $timestamps = true; // Enable timestamps if you want to use created_at and updated_at fields

    public function wallet()
    {
        return $this->hasOne(Wallet::class, 'customer_id', 'id'); // Define the relationship with the Wallet model
    }

    public function virtualAccount()
    {
        return $this->hasOneThrough(VirtualAccount::class, Wallet::class,
        'customer_id',
        'wallet_id',
        'id',
        'id'
        );
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, "customer_id", 'id');
    }

    public function likeProducts()
    {
        return $this->belongsToMany(Product::class, 'customers_likes_products', 'customer_id', 'product_id')->withPivot('created_at')->using(Like::class);

    }

    public function likeProductsLastWeek()
    {
        return $this->belongsToMany(Product::class, 'customers_likes_products', 'customer_id', 'product_id')
        ->withPivot('created_at')
        ->wherePivot('created_at', '>=', Date::now()->addDays(-7))
        ->using(Like::class);

    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }


}
