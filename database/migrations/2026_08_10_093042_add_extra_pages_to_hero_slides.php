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
        // No columns need adding because the existing dynamic target_page system covers this
    }

    public function down(): void
    {
        // No schema modifications needed
    }
};
