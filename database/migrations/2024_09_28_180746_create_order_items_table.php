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
        Schema::create('order_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_order_id')->nullable();
            $table->string('order_id')->nullable();
            $table->integer('type')->nullable();
            $table->integer('status')->default(0)->comment('0 -> new, 1 -> pending, 2 -> completed');
            
            $table->integer('item_id')->nullable();
            $table->integer('qty')->nullable()->unsigned();
            $table->integer('price')->nullable()->unsigned();
            $table->bigInteger('total_price')->default(0)->unsigned();
            
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
