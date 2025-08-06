<?php

namespace App\Models;

use App\Casts\AsAddress;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    use HasFactory;

    protected $table = 'people';
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = ['first_name', 'last_name'];

    protected $casts = [
        'address' => AsAddress::class,
    ];


    protected function fullName(): Attribute
    {
        return Attribute::make(
            function () {
                return $this->first_name . ' ' . $this->last_name;
            },

            function (string $value) {
                $names = explode(' ', $value, 2);
                return [
                    'first_name' => $names[0],
                    'last_name' => $names[1] ?? ''
                ];
            }
        );
    }

    protected function firstName(): Attribute
    {
        return Attribute::make(
            function ($value, $attributes) {
                return strtoupper($value);
            },
            function ($value) {
                return [
                    'first_name' => strtoupper($value)
                ];
            }
        );
    }
}
