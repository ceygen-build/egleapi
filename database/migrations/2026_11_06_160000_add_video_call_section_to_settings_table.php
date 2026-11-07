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
            if (!Schema::hasColumn('settings', 'video_call_thumbnail')) {
                $table->string('video_call_thumbnail')->nullable();
            }
            if (!Schema::hasColumn('settings', 'video_call_video_type')) {
                $table->string('video_call_video_type')->nullable()->default('youtube');
            }
            if (!Schema::hasColumn('settings', 'video_call_youtube_url')) {
                $table->string('video_call_youtube_url')->nullable()->default('https://youtube.com/@EagleLogisticsCMB');
            }
            if (!Schema::hasColumn('settings', 'video_call_video_file')) {
                $table->string('video_call_video_file')->nullable();
            }
            if (!Schema::hasColumn('settings', 'video_call_title')) {
                $table->string('video_call_title')->nullable()->default('We know that every decision has an impact');
            }
            if (!Schema::hasColumn('settings', 'video_call_phone_label')) {
                $table->string('video_call_phone_label')->nullable()->default('Call for free');
            }
            if (!Schema::hasColumn('settings', 'video_call_phone_number')) {
                $table->string('video_call_phone_number')->nullable()->default('+94 11 2577892');
            }
            if (!Schema::hasColumn('settings', 'video_call_is_active')) {
                $table->boolean('video_call_is_active')->default(true);
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
                'video_call_thumbnail',
                'video_call_video_type',
                'video_call_youtube_url',
                'video_call_video_file',
                'video_call_title',
                'video_call_phone_label',
                'video_call_phone_number',
                'video_call_is_active',
            ]);
        });
    }
};

