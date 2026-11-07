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
        Schema::create('facebook_feed_items', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->text('caption')->nullable();
            $table->text('fb_image_url');
            $table->string('status')->default('pending');
            $table->string('posted_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facebook_feed_items');
    }
};
