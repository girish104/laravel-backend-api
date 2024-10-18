<?php

namespace App\Models;

use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    use HasFactory, SoftDeletes, CommonMethods;
    // protected $guarded = ['id']; 
    public $table      = "settings";

    protected $fillable = [
        'home_page_header_title',
        // 'home_page_meta',
        'home_page_meta_title',
        'home_page_meta_keyword',
        'home_page_meta_description',

        'home_page_banner_title',
        'home_page_banner_description',

        'home_page_event_group_title',
        'home_page_event_group_description',

        'why_choose_us_title',
        'why_choose_us_description',

        'popular_gift_collection_title',
        'popular_gift_collection_description',

        'popular_celebrities_title',
        'popular_celebrities_description',

        'popular_packages_title',
        'popular_packages_description',

        'testimonial_title',
        'testimonial_description',


        'contact_celebration_form_title',


        'footer_title',
        'footer_description',
        'footer_contact_title',
        'footer_contact_description',
        'footer_copyright_title',

        'contact_page_email',
        'contact_page_address',
        'contact_page_contact_number',

        'contact_page_greeting_title',
        'contact_page_greeting_content',

        'contact_page_whatsapp_contact_title',
        'contact_page_whatsapp_contact_content',

        'contact_page_whatsapp_contact_number',
        'contact_page_whatsapp_contact_text',
    ];

    
    protected static function boot()
    {
        parent::boot();
        // static::creating(function ($item) {
        //    dump('creating, clear cache of frontend');
        // });
        // static::updating(function ($item) {
        //     dump('updating, clear cache of frontend');
        // });
    }
}
