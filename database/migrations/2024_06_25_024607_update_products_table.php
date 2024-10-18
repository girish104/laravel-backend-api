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
        Schema::table('products', function (Blueprint $table) {
            $table->renameColumn('overview', 'summary');
            $table->text('title')->change();

            $table->text('description')->nullable();;
            $table->text('tags')->nullable();
            $table->text('product_detail')->nullable();;
            $table->text('delivery_info')->nullable();;
            $table->text('cancellation_policy')->nullable();;

            $table->string('sku')->nullable();;
            $table->bigInteger('price');
            $table->bigInteger('old_price')->nullable();;
            $table->integer('stock')->nullable();;
            $table->string('weight')->nullable();;
            $table->string('dimensions')->nullable();;

            $table->integer('business_type_id')->nullable();
            $table->integer('category_id')->nullable();
            $table->integer('sub_category_id')->nullable();
            $table->integer('sub_sub_category_1_id')->nullable();
            $table->integer('sub_sub_category_2_id')->nullable();
            $table->integer('sub_sub_category_3_id')->nullable();
            $table->integer('sub_sub_category_4_id')->nullable();
            $table->integer('sub_sub_category_5_id')->nullable();
            $table->integer('sub_sub_category_6_id')->nullable();

            $table->text('slug')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
