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
        Schema::table('settings', function (Blueprint $table) {
            $table->text('contact_page_email')->nullable();
            $table->text('contact_page_address')->nullable();
            $table->text('contact_page_contact_number')->nullable();

            $table->text('contact_page_greeting_title')->nullable();
            $table->text('contact_page_greeting_content')->nullable();

            $table->text('contact_page_whatsapp_contact_title')->nullable();
            $table->text('contact_page_whatsapp_contact_content')->nullable();

            $table->text('contact_page_whatsapp_contact_number')->nullable();
            $table->text('contact_page_whatsapp_contact_text')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings', function (Blueprint $table) {
            Schema::dropColumn('contact_page_email');
            Schema::dropColumn('contact_page_address');
            Schema::dropColumn('contact_page_contact_number');

            Schema::dropColumn('contact_page_greeting_title');
            Schema::dropColumn('contact_page_greeting_content');

            Schema::dropColumn('contact_page_whatsapp_contact_title');
            Schema::dropColumn('contact_page_whatsapp_contact_content');

            Schema::dropColumn('contact_page_whatsapp_contact_number');
            Schema::dropColumn('contact_page_whatsapp_contact_text');
        });
    }
};
