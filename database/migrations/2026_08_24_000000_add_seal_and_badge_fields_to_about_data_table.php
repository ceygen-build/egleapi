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
        Schema::table('about_data', function (Blueprint $table) {
            $table->string('seal_text')->nullable()->default('LOGISTICS EXCELLENCE • SINCE 2008 •');
            $table->string('rating_badge_title')->nullable()->default('Clients 4.8 / 5.0');
            $table->string('rating_badge_subtitle')->nullable()->default('(3,567 VERIFIED REVIEWS)');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_data', function (Blueprint $table) {
            $table->dropColumn(['seal_text', 'rating_badge_title', 'rating_badge_subtitle']);
        });
    }
};
