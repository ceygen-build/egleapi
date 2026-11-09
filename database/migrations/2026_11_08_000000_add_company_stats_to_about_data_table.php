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
            if (!Schema::hasColumn('about_data', 'company_stat1_value')) {
                $table->string('company_stat1_value')->nullable()->default('20+');
            }
            if (!Schema::hasColumn('about_data', 'company_stat1_label')) {
                $table->string('company_stat1_label')->nullable()->default('Years of Experience');
            }
            if (!Schema::hasColumn('about_data', 'company_stat2_value')) {
                $table->string('company_stat2_value')->nullable()->default('240+');
            }
            if (!Schema::hasColumn('about_data', 'company_stat2_label')) {
                $table->string('company_stat2_label')->nullable()->default('Cities Worldwide');
            }
            if (!Schema::hasColumn('about_data', 'company_stat3_value')) {
                $table->string('company_stat3_value')->nullable()->default('500+');
            }
            if (!Schema::hasColumn('about_data', 'company_stat3_label')) {
                $table->string('company_stat3_label')->nullable()->default('Supply Chain Professionals');
            }
            if (!Schema::hasColumn('about_data', 'company_stat4_value')) {
                $table->string('company_stat4_value')->nullable()->default('100%');
            }
            if (!Schema::hasColumn('about_data', 'company_stat4_label')) {
                $table->string('company_stat4_label')->nullable()->default('Customs Compliance');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('about_data', function (Blueprint $table) {
            $columns = [
                'company_stat1_value',
                'company_stat1_label',
                'company_stat2_value',
                'company_stat2_label',
                'company_stat3_value',
                'company_stat3_label',
                'company_stat4_value',
                'company_stat4_label',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('about_data', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

