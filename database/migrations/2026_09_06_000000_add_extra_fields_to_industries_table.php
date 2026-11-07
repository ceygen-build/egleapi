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
        Schema::table('industries', function (Blueprint $table) {
            if (!Schema::hasColumn('industries', 'short')) {
                $table->string('short')->nullable()->after('name');
            }
            if (!Schema::hasColumn('industries', 'stats')) {
                $table->string('stats')->nullable()->after('description');
            }
            if (!Schema::hasColumn('industries', 'color')) {
                $table->string('color', 50)->default('#2563eb')->after('stats');
            }
            if (!Schema::hasColumn('industries', 'bg_color')) {
                $table->string('bg_color', 50)->default('#040e1f')->after('color');
            }
            if (!Schema::hasColumn('industries', 'services')) {
                $table->json('services')->nullable()->after('bg_color');
            }
            if (!Schema::hasColumn('industries', 'sort_order')) {
                $table->integer('sort_order')->default(1)->after('services');
            }
            if (!Schema::hasColumn('industries', 'is_active')) {
                $table->boolean('is_active')->default(true)->after('sort_order');
            }
            if (!Schema::hasColumn('industries', 'link')) {
                $table->string('link')->default('/contact')->after('is_active');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('industries', function (Blueprint $table) {
            $table->dropColumn([
                'short',
                'stats',
                'color',
                'bg_color',
                'services',
                'sort_order',
                'is_active',
                'link',
            ]);
        });
    }
};

