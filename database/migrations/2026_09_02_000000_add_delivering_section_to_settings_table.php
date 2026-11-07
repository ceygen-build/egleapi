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
            $table->string('delivering_image')->nullable();
            $table->string('delivering_card_title')->nullable()->default('Delivering Monster for industry leaders');
            $table->string('delivering_card_num')->nullable()->default('245+');
            $table->string('delivering_card_label')->nullable()->default("Cargo Delivered Per\nMonth");
            $table->text('delivering_description')->nullable();
            $table->text('delivering_checklist')->nullable();
            $table->string('delivering_btn_text')->nullable()->default('Know About Us');
            $table->string('delivering_btn_link')->nullable()->default('/about');
            $table->text('delivering_tags')->nullable();
            $table->boolean('delivering_is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn([
                'delivering_image',
                'delivering_card_title',
                'delivering_card_num',
                'delivering_card_label',
                'delivering_description',
                'delivering_checklist',
                'delivering_btn_text',
                'delivering_btn_link',
                'delivering_tags',
                'delivering_is_active',
            ]);
        });
    }
};

