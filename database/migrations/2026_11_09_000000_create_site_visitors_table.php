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
        Schema::create('site_visitors', function (Blueprint $table) {
            $table->id();
            $table->string('session_id', 64)->index();
            $table->string('ip_address', 45)->nullable()->index();
            $table->string('country', 100)->default('Unknown')->index();
            $table->string('country_code', 10)->default('XX')->index();
            $table->string('city', 100)->default('Unknown')->index();
            $table->string('region', 100)->nullable();
            $table->string('page_url', 500)->index();
            $table->string('page_title', 255)->nullable();
            $table->string('referrer', 500)->nullable();
            $table->string('device_type', 30)->default('desktop')->index();
            $table->string('browser', 50)->default('Unknown')->index();
            $table->string('os', 50)->default('Unknown')->index();
            $table->string('screen_resolution', 30)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamps();

            $table->index(['created_at', 'country_code']);
            $table->index(['created_at', 'session_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_visitors');
    }
};

