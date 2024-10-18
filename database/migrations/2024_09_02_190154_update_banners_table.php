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
        Schema::table('banners', function (Blueprint $table) {
            $table->integer('category')->nullable()->default(0);
            $table->integer('business_type_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('service_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('banners', function (Blueprint $table) {
            Schema::dropColumn('category');
            
            Schema::dropColumn('business_type_id');
            Schema::dropColumn('category_id');
            Schema::dropColumn('sub_category_id');

            Schema::dropColumn('product_id');
            Schema::dropColumn('service_id');
        });
    }
};
