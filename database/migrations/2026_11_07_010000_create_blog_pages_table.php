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
        Schema::create('blog_pages', function (Blueprint $table) {
            $table->id();
            $table->string('slug', 100)->unique();
            $table->string('page_name', 150);
            
            // Hero Banner
            $table->string('hero_tag', 150)->nullable();
            $table->text('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();
            
            // Narrative / Intro Block
            $table->string('intro_label', 150)->nullable();
            $table->string('intro_title')->nullable();
            $table->text('intro_description')->nullable();
            $table->string('intro_image')->nullable();
            
            // Metrics & Custom Section Data (JSON)
            $table->json('stats')->nullable();
            $table->json('sections_data')->nullable();
            
            // Call To Action (Bottom CTA)
            $table->string('cta_title')->nullable();
            $table->text('cta_desc')->nullable();
            $table->string('cta_btn_text', 100)->nullable();
            $table->string('cta_btn_url')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blog_pages');
    }
};

