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
        Schema::rename('balance_history', 'balance_histories');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('balance_histories', 'balance_history');

    }
};
