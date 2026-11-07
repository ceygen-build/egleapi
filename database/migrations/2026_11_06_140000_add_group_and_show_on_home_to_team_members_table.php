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
        Schema::table('team_members', function (Blueprint $table) {
            if (!Schema::hasColumn('team_members', 'group')) {
                $table->string('group')->default('Board of Directors')->after('role');
            }
            if (!Schema::hasColumn('team_members', 'show_on_home')) {
                $table->boolean('show_on_home')->default(false)->after('order_index');
            }
            if (!Schema::hasColumn('team_members', 'bio')) {
                $table->text('bio')->nullable()->after('show_on_home');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_members', function (Blueprint $table) {
            if (Schema::hasColumn('team_members', 'bio')) {
                $table->dropColumn('bio');
            }
            if (Schema::hasColumn('team_members', 'show_on_home')) {
                $table->dropColumn('show_on_home');
            }
            if (Schema::hasColumn('team_members', 'group')) {
                $table->dropColumn('group');
            }
        });
    }
};

