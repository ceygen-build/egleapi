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
        if (!Schema::hasTable('service_pages')) {
            Schema::create('service_pages', function (Blueprint $table) {
                $table->id();
                $table->string('slug', 100)->unique();
                $table->string('page_name', 255);
                $table->text('hero_tag')->nullable();
                $table->text('hero_title')->nullable();
                $table->text('hero_subtitle')->nullable();
                $table->text('hero_image')->nullable();
                $table->text('intro_label')->nullable();
                $table->text('intro_title')->nullable();
                $table->text('intro_description')->nullable();
                $table->text('intro_image')->nullable();
                $table->text('stats')->nullable(); // JSON array
                $table->text('sections_data')->nullable(); // JSON object
                $table->text('cta_title')->nullable();
                $table->text('cta_desc')->nullable();
                $table->text('cta_btn_text')->nullable();
                $table->text('cta_btn_url')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('service_pages');
    }
};

