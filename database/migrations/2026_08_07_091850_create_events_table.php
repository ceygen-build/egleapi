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
        Schema::create('events', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->string('category');
            $table->string('date');
            $table->string('time');
            $table->string('location');
            $table->string('city');
            $table->string('image')->nullable();
            $table->text('description');
            $table->json('speakers')->nullable();
            $table->string('status')->default('Registration Open');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
