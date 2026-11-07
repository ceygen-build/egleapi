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
            if (!Schema::hasColumn('about_data', 'hero_tag')) {
                $table->text('hero_tag')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'company_image')) {
                $table->text('company_image')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'company_founded_year')) {
                $table->text('company_founded_year')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'company_label')) {
                $table->text('company_label')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'vision_statement')) {
                $table->text('vision_statement')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'mission_statement')) {
                $table->text('mission_statement')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'quality_title')) {
                $table->text('quality_title')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'quality_statement')) {
                $table->text('quality_statement')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'quality_points')) {
                $table->text('quality_points')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'spirit_label')) {
                $table->text('spirit_label')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'spirit_title')) {
                $table->text('spirit_title')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'spirit_subtitle')) {
                $table->text('spirit_subtitle')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'spirit_description')) {
                $table->text('spirit_description')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'spirit_image')) {
                $table->text('spirit_image')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'spirit_quote')) {
                $table->text('spirit_quote')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'spirit_values')) {
                $table->text('spirit_values')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'timeline_label')) {
                $table->text('timeline_label')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'timeline_title')) {
                $table->text('timeline_title')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'timeline_subtitle')) {
                $table->text('timeline_subtitle')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'cta_title')) {
                $table->text('cta_title')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'cta_desc')) {
                $table->text('cta_desc')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'cta_primary_btn_text')) {
                $table->text('cta_primary_btn_text')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'cta_primary_btn_url')) {
                $table->text('cta_primary_btn_url')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'cta_secondary_btn_text')) {
                $table->text('cta_secondary_btn_text')->nullable();
            }
            if (!Schema::hasColumn('about_data', 'cta_secondary_btn_url')) {
                $table->text('cta_secondary_btn_url')->nullable();
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
                'hero_tag',
                'company_image',
                'company_founded_year',
                'company_label',
                'vision_statement',
                'mission_statement',
                'quality_title',
                'quality_statement',
                'quality_points',
                'spirit_label',
                'spirit_title',
                'spirit_subtitle',
                'spirit_description',
                'spirit_image',
                'spirit_quote',
                'spirit_values',
                'timeline_label',
                'timeline_title',
                'timeline_subtitle',
                'cta_title',
                'cta_desc',
                'cta_primary_btn_text',
                'cta_primary_btn_url',
                'cta_secondary_btn_text',
                'cta_secondary_btn_url',
            ];
            foreach ($columns as $column) {
                if (Schema::hasColumn('about_data', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};

