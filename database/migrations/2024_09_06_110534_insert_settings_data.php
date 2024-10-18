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
        if (file_exists("database/backup/settings.sql"))
            \DB::unprepared(file_get_contents("database/backup/settings.sql"));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       
    }
};
