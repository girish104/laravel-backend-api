<?php

namespace App\Models\Business;

use App\Models\Product;
use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Event extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;


    public    $table    = "events";
    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'col_width',
        'show_on_home_page',
        'slug',
        'position',

        'summary',
        'tags',
        'detail',
        'info',
        'cancellation_policy',
        'price',
        'old_price',
        'rating',
        'reviews',
        'meta_title', 
        'meta_keywords',
        'meta_descriptions',
    ];

    // public function product()
    // {
    //     return $this->hasMany(Product::class, 'gift_type_id');
    // }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            $item->slug = Str::slug($item->title);
        });
        static::updating(function ($item) {
            $item->slug = Str::slug($item->title);
        });

        static::created(function ($item) {
            if (!empty(static::$clearFrontendCache)) static::clearFrontendCache(true);
        });

        static::updated(function ($item) {
            if (!empty(static::$clearFrontendCache)) static::clearFrontendCache();
        });
    }
}
