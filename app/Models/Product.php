<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // Specify the table name if it's not the plural form of the model name
    protected $primaryKey = 'id'; // Specify the primary key if it's not 'id
    protected $keyType = 'string'; // Specify the key type as string since 'id
    public $incrementing = false; // Set to false if the primary key is not auto
    public $timestamps = true; // Enable timestamps if you want to use created_at and updated_at fields

    protected $hidden = [
        'category_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function reviews()
    {
        return $this->hasMany(Review::class, 'product_id', 'id');
    }

    public function likedByCustomers()
    {
         return $this->belongsToMany(Customer::class, 'customers_likes_products', 'product_id', 'customer_id')->withPivot('created_at')->using(Like::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function comments() 
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function latestComment()
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->latest('created_at');
    }

    public function oldestComment()
    {
        return $this->morphOne(Comment::class, 'commentable')
            ->oldest('created_at');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }

    
}

