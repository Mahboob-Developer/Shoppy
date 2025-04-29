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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('adminid');
            $table->string('name');
            $table->string('category');
            $table->string('brand');
            $table->string('size');
            $table->string('quantity');
            $table->string('stock');
            $table->string('price');
            $table->string('description');
            $table->string('mainimage');
            $table->string('sideone');
            $table->string('sidetwo');
            $table->string('sidethree');
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
