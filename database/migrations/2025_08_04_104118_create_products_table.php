<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Ramsey\Uuid\Type\Integer;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->string('id', 100)->nullable(false)->primary(); // Use a string for the primary key
            $table->string('name')->nullable(false); // Name of the product
            $table->text('description')->nullable(); // Description of the product
            $table->integer('price')->nullable(false)->default(0); // Price of the product
            $table->integer('stock')->nullable(false)->default(0); // Stock quantity of the product
            $table->string('category_id', 100)->nullable(false); // Foreign key to

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
