<?php

namespace App\Models;

use App\Models\Scopes\IsActiveScope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Journal extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'journals'; // Specify the table name if it's not the plural form of the model name
    protected $primaryKey = 'id'; // Specify the primary key if it's not 'id'
    protected $keyType = 'string';
    public $incrementing = false; // Set to false if the primary key is not auto-incrementing
    public $timestamps = false; // Enable timestamps if you want to use created_at and updated_at fields

    protected $attributes = [
        'title' => 'Sample Title',
    ];

    protected $fillable = [
        'id',
        'title',
        'content',
        'local_is_active', // Use local_is_active to avoid conflict with global scope
    ];

    protected static function booted()
    {
        static::addGlobalScope(new IsActiveScope());
    }

    public function scopeActive(Builder $builder)
    {
        return $builder->where('local_is_active', true); // Filter to only include active journals
    }

    public function scopeNonActive(Builder $builder)
    {
        return $builder->where('local_is_active', false); // Filter to only include non-active journals
    }
    
}
