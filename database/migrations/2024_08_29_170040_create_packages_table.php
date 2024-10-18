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
        Schema::create('packages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->text('description')->nullable();
            $table->text('summary')->nullable();
            $table->text('tags')->nullable();
            $table->text('detail')->nullable();
            $table->text('cancellation_policy')->nullable();
            $table->text('image')->nullable();

            $table->bigInteger('price');
            $table->bigInteger('old_price')->nullable();

            $table->integer('rating')->default(0);
            $table->integer('reviews')->default(0);

            $table->text('meta_title')->nullable(); 
            $table->text('meta_keywords')->nullable();
            $table->text('meta_descriptions')->nullable();
            $table->integer('status');
            
            $table->text('slug')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
       
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
