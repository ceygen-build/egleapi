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
        Schema::create('career_page', function (Blueprint $table) {
            $table->id();

            // Hero Banner
            $table->string('hero_tag', 150)->nullable();
            $table->text('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();

            // Why Eagle Logistic (Perks & Culture)
            $table->string('why_join_label', 150)->nullable();
            $table->string('why_join_title', 255)->nullable();
            $table->text('why_join_subtitle')->nullable();
            $table->json('perks')->nullable();

            // Student Internship Program
            $table->json('internship')->nullable();

            // Application Form Header
            $table->string('application_heading', 255)->nullable();
            $table->text('application_subheading')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('career_page');
    }
};

