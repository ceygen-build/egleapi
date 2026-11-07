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
        Schema::create('contact_page', function (Blueprint $table) {
            $table->id();

            // Hero section
            $table->string('hero_tag')->nullable();
            $table->text('hero_title')->nullable();
            $table->text('hero_subtitle')->nullable();
            $table->string('hero_image')->nullable();

            // Quick Stats Bar (JSON: 4 stats)
            $table->json('stats')->nullable();

            // Main Message Form Header & Quick Contact
            $table->string('form_label')->nullable();
            $table->string('form_title')->nullable();
            $table->text('form_desc')->nullable();
            $table->string('direct_phone')->nullable();
            $table->string('direct_email')->nullable();
            $table->string('business_hours')->nullable();

            // Department Direct Inquiries (JSON: array of { id, name, email, description, icon })
            $table->json('departments')->nullable();

            // Locations & Offices (JSON: array of { id, name, address, phone, email, mapUrl, embedUrl, primary })
            $table->json('offices')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_page');
    }
};

