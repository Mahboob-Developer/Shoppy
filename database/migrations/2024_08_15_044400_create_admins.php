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
        Schema::create('admins', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('active');
            $table->string('fullname');
            $table->string('mobile', 10);
            $table->string('email')->unique();
            $table->enum('gender', ['male', 'female']);
            $table->string('brand', 15);
            $table->string('pincode', 6);
            $table->text('address');
            $table->string('password');
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
