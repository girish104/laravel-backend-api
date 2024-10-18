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
        Schema::create('business_sub_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->string('slug')->nullable();

            $table->tinyInteger('business_type')->default(0);
            $table->tinyInteger('type')->default(0)->comment('category type (1 to 6)');
            $table->integer('category_id');
            $table->integer('sub_category_id');

            $table->integer('sub_sub_category_1_id')->nullable();
            $table->integer('sub_sub_category_2_id')->nullable();
            $table->integer('sub_sub_category_3_id')->nullable();
            $table->integer('sub_sub_category_4_id')->nullable();
            $table->integer('sub_sub_category_5_id')->nullable();
            $table->integer('sub_sub_category_6_id')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_sub_sub_categories');
    }
};
