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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            $table->text('home_page_header_title')->nullable();
            // $table->text('home_page_meta');
            $table->text('home_page_meta_keyword')->nullable();
            $table->text('home_page_meta_title')->nullable();
            $table->text('home_page_meta_description')->nullable();

            $table->text('home_page_banner_title')->nullable();
            $table->text('home_page_banner_description')->nullable();
            $table->text('home_page_event_group_title')->nullable();
            $table->text('home_page_event_group_description')->nullable();


            $table->text('why_choose_us_title')->nullable();
            $table->text('why_choose_us_description')->nullable();

            $table->text('popular_gift_collection_title')->nullable();
            $table->text('popular_gift_collection_description')->nullable();

            $table->text('popular_celebrities_title')->nullable();
            $table->text('popular_celebrities_description')->nullable();

            $table->text('popular_packages_title')->nullable();
            $table->text('popular_packages_description')->nullable();

            $table->text('testimonial_title')->nullable();
            $table->text('testimonial_description')->nullable();
            $table->text('contact_celebration_form_title')->nullable();
            

            $table->text('footer_title')->nullable();
            $table->text('footer_description')->nullable();
            $table->text('footer_contact_title')->nullable();
            $table->text('footer_contact_description')->nullable();
            $table->text('footer_copyright_title')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
