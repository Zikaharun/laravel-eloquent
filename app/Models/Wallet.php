<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $table = 'wallets'; // Specify the table name if it's not the plural form of the model name
    protected $primaryKey = 'id'; // Specify the primary key if it's not 'id
    protected $keyType = 'int'; // Specify the key type as int since 'id
    public $incrementing = true; // Set to true if the primary key is auto-incrementing
    public $timestamps = true; // Enable timestamps if you want to use created_at and updated

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id'); // Define the relationship with the Customer model
    }

    public function virtualAccount()
    {
        return $this->hasOne(VirtualAccount::class, 'wallet_id', 'id');
    }
}
