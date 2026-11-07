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
            $table->string('stat1_value')->default('15+');
            $table->string('stat1_label')->default("Years of\nExcellence");
            $table->string('stat2_value')->default('120+');
            $table->string('stat2_label')->default("Countries\nServed");
            $table->string('stat3_value')->default('25K+');
            $table->string('stat3_label')->default("Shipments\nDelivered");
            $table->string('stat4_value')->default('24/7');
            $table->string('stat4_label')->default("Client\nSupport");

            $table->integer('about_stat1_value')->default(150);
            $table->string('about_stat1_suffix')->default('+');
            $table->string('about_stat1_label')->default('Countries Served');

            $table->integer('about_stat2_value')->default(2500);
            $table->string('about_stat2_suffix')->default('+');
            $table->string('about_stat2_label')->default('Satisfied Enterprise Clients');

            $table->integer('about_stat3_value')->default(48000);
            $table->string('about_stat3_suffix')->default('+');
            $table->string('about_stat3_label')->default('Shipments Handled Annually');

            $table->integer('about_stat4_value')->default(15);
            $table->string('about_stat4_suffix')->default('+');
            $table->string('about_stat4_label')->default('Years Cargo Experience');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'stat1_value', 'stat1_label',
                'stat2_value', 'stat2_label',
                'stat3_value', 'stat3_label',
                'stat4_value', 'stat4_label',
                'about_stat1_value', 'about_stat1_suffix', 'about_stat1_label',
                'about_stat2_value', 'about_stat2_suffix', 'about_stat2_label',
                'about_stat3_value', 'about_stat3_suffix', 'about_stat3_label',
                'about_stat4_value', 'about_stat4_suffix', 'about_stat4_label'
            ]);
        });
    }
};
