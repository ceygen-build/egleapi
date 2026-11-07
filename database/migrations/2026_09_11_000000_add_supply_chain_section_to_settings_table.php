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
            if (!Schema::hasColumn('settings', 'supply_chain_badge')) {
                $table->string('supply_chain_badge')->nullable()->default('OUR EXPERIENCE');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_title')) {
                $table->string('supply_chain_title')->nullable()->default('Leader In Supply Chain Storage & Distribution');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_image')) {
                $table->string('supply_chain_image')->nullable()->default('https://images.unsplash.com/photo-1494412574643-ff11b0a5c1c3?w=900&q=80');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_checklist')) {
                $table->text('supply_chain_checklist')->nullable();
            }
            if (!Schema::hasColumn('settings', 'supply_chain_btn_text')) {
                $table->string('supply_chain_btn_text')->nullable()->default('More Details');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_btn_link')) {
                $table->string('supply_chain_btn_link')->nullable()->default('/services');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_stat1_value')) {
                $table->string('supply_chain_stat1_value')->nullable()->default('150k');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_stat1_desc')) {
                $table->text('supply_chain_stat1_desc')->nullable()->default('Join the companies that trust create to lead their AI transformation.');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_stat2_value')) {
                $table->string('supply_chain_stat2_value')->nullable()->default('245k');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_stat2_desc')) {
                $table->text('supply_chain_stat2_desc')->nullable()->default('Successful Project Completion for all transport authorize');
            }
            if (!Schema::hasColumn('settings', 'supply_chain_is_active')) {
                $table->boolean('supply_chain_is_active')->default(true);
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
                'supply_chain_badge',
                'supply_chain_title',
                'supply_chain_image',
                'supply_chain_checklist',
                'supply_chain_btn_text',
                'supply_chain_btn_link',
                'supply_chain_stat1_value',
                'supply_chain_stat1_desc',
                'supply_chain_stat2_value',
                'supply_chain_stat2_desc',
                'supply_chain_is_active',
            ]);
        });
    }
};

