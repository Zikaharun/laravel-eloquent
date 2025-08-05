<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id', 100)->nullable(false); // Foreign key to customers table
            $table->bigInteger('amount')->nullable(false)->default(0); // Amount in the wallet
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade'); // Foreign key constraint
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallets');
    }
};
