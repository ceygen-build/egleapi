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
            if (!Schema::hasColumn('settings', 'industry_badge')) {
                $table->string('industry_badge')->nullable();
            }
            if (!Schema::hasColumn('settings', 'industry_title')) {
                $table->text('industry_title')->nullable();
            }
            if (!Schema::hasColumn('settings', 'industry_subtitle')) {
                $table->text('industry_subtitle')->nullable();
            }
            if (!Schema::hasColumn('settings', 'industry_is_active')) {
                $table->boolean('industry_is_active')->default(true);
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'industry_badge',
                'industry_title',
                'industry_subtitle',
                'industry_is_active',
            ]);
        });
    }
};

