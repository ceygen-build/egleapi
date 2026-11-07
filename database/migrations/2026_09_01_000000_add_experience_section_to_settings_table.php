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
            $table->string('experience_badge')->nullable()->default('OUR EXPERIENCE');
            $table->text('experience_title')->nullable();
            $table->string('experience_highlight')->nullable()->default('Delay and Damages.');
            $table->boolean('experience_is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'experience_badge',
                'experience_title',
                'experience_highlight',
                'experience_is_active',
            ]);
        });
    }
};

