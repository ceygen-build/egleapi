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
        Schema::create('about_data', function (Blueprint $table) {
            $table->id();
            $table->string('hero_title')->nullable();
            $table->string('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            $table->string('company_title')->nullable();
            $table->string('company_subtitle')->nullable();
            $table->text('company_desc1')->nullable();
            $table->text('company_desc2')->nullable();
            $table->string('ceo_message_title')->nullable();
            $table->string('ceo_message_subtitle')->nullable();
            $table->text('ceo_message_quote')->nullable();
            $table->text('ceo_message_body')->nullable();
            $table->string('ceo_name')->nullable();
            $table->string('ceo_title')->nullable();
            $table->string('ceo_image')->nullable();
            $table->string('vision_title')->nullable();
            $table->text('vision_desc')->nullable();
            $table->string('mission_title')->nullable();
            $table->text('mission_desc')->nullable();
            $table->string('values_title')->nullable();
            $table->text('values_desc')->nullable();
            $table->string('motivation_title')->nullable();
            $table->text('motivation_desc')->nullable();
            $table->string('youtube_url')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_data');
    }
};
