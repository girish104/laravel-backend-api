<?php

namespace App\Models\Business;

use App\Models\Product;
use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Gift extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;


    public    $table    = "gift_types";
    protected $fillable = [
        'title',
        'description',
        'status',
        'slug',
    ];

    public function product()
    {
        return $this->hasMany(Product::class, 'gift_type_id');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (in_array('slug', $item->fillable)) {
                return;
            }
            
            $item->slug = Str::slug($item->title);
        });
        static::updating(function ($item) {
            if (in_array('slug', $item->fillable)) {
                return;
            }

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
