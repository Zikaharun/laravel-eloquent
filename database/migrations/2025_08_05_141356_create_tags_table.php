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
        Schema::create('tags', function (Blueprint $table) {
            $table->string('id', 100)->primary();
            $table->string('name', 100);
            $table->timestamps();
        });

        Schema::create('taggables', function (Blueprint $table) {
            $table->string('tag_id', 100);
            $table->string('taggable_id', 100);
            $table->string('taggable_type', 200);
            $table->primary(['tag_id', 'taggable_id', 'taggable_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tags');
        Schema::dropIfExists('taggables');
    }
};
