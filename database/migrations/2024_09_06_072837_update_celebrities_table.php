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
        Schema::table('celebrities', function (Blueprint $table) {
            $table->renameColumn('celebrities_detail', 'celebrity_detail');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('celebrities', function (Blueprint $table) {
            $table->renameColumn('celebrity_detail', 'celebrities_detail');
        });
    }
};
