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
            if (!Schema::hasColumn('settings', 'how_it_works_badge')) {
                $table->string('how_it_works_badge')->nullable();
            }
            if (!Schema::hasColumn('settings', 'how_it_works_title')) {
                $table->text('how_it_works_title')->nullable();
            }
            if (!Schema::hasColumn('settings', 'how_it_works_is_active')) {
                $table->boolean('how_it_works_is_active')->default(true);
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
                'how_it_works_badge',
                'how_it_works_title',
                'how_it_works_is_active',
            ]);
        });
    }
};

