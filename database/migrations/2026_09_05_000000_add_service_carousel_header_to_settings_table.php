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
        Schema::table('settings', function (Blueprint $table) {
            $table->string('service_carousel_badge')->nullable()->default('OUR EXPERIENCE');
            $table->string('service_carousel_title')->nullable()->default("Essential Features\nof our Services.");
            $table->boolean('service_carousel_is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'service_carousel_badge',
                'service_carousel_title',
                'service_carousel_is_active',
            ]);
        });
    }
};

