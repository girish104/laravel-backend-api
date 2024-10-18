<?php

namespace App\Models\Business;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Type extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;


    public    $table    = "business_types";
    protected $fillable = [
        'title',
        'description',
        'status',
        'slug',
        'position',
    ];

    public function category()
    {
        return $this->hasMany(Category::class, 'business_type');
    }

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
