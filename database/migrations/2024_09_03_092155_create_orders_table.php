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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('adminid');
            $table->integer('user_id');
            $table->integer('product_id');
            $table->string('name');
            $table->string('tracking_number');
            $table->string('tracking_address');
            $table->string('size');
            $table->integer('quantity');
            $table->string('total_price');
            $table->string('price');
            $table->integer('discount');
            $table->integer('discount_price');
            $table->string('payment_method');
            $table->string('status');
            $table->string('pincode');
            $table->string('shipping_fee');
            $table->string('order_date');
            $table->string('delivery_date');
            $table->string('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
