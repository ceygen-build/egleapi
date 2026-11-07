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
        Schema::create('blogs', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('title');
            $table->text('excerpt');
            $table->string('category');
            $table->string('author');
            $table->string('author_role');
            $table->string('author_avatar')->default('/images/ceo.png');
            $table->string('date');
            $table->string('read_time');
            $table->string('image')->nullable();
            $table->boolean('featured')->default(false);
            $table->json('content')->nullable();
            $table->json('key_takeaways')->nullable();
            $table->json('tags')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
