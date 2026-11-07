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
            if (!Schema::hasColumn('settings', 'instagram_url')) {
                $table->text('instagram_url')->nullable();
            }
            if (!Schema::hasColumn('settings', 'youtube_url')) {
                $table->text('youtube_url')->nullable();
            }
            if (!Schema::hasColumn('settings', 'tiktok_url')) {
                $table->text('tiktok_url')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_brand_name')) {
                $table->text('footer_brand_name')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_contact_title')) {
                $table->text('footer_contact_title')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_phone')) {
                $table->text('footer_phone')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_email')) {
                $table->text('footer_email')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_address')) {
                $table->text('footer_address')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_useful_title')) {
                $table->text('footer_useful_title')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_useful_links')) {
                $table->text('footer_useful_links')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_services_title')) {
                $table->text('footer_services_title')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_services_links')) {
                $table->text('footer_services_links')->nullable();
            }
            if (!Schema::hasColumn('settings', 'footer_copyright')) {
                $table->text('footer_copyright')->nullable();
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
                'instagram_url',
                'youtube_url',
                'tiktok_url',
                'footer_brand_name',
                'footer_contact_title',
                'footer_phone',
                'footer_email',
                'footer_address',
                'footer_useful_title',
                'footer_useful_links',
                'footer_services_title',
                'footer_services_links',
                'footer_copyright',
            ]);
        });
    }
};
