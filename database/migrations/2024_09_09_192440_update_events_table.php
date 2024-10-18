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
        Schema::table('events', function (Blueprint $table) {
            $table->text('summary')->nullable();
            $table->text('tags')->nullable();
            $table->text('detail')->nullable();
            $table->text('info')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->bigInteger('price');
            $table->bigInteger('old_price')->nullable();
            $table->integer('rating')->default(0);
            $table->integer('reviews')->default(0);
            $table->text('meta_title')->nullable(); 
            $table->text('meta_keywords')->nullable();
            $table->text('meta_descriptions')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('events', function (Blueprint $table) {
            //
        });
    }
};
