<?php

namespace App\Models;

use App\Models\Business\Type;
use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Banner extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;
    
    public const TYPE_HOME = 0;

    public const SHOW_ON_CATEGORY_TYPE = 0;
    public const SHOW_ON_CATEGORY     = 1;
    public const SHOW_ON_BOTH         = 2;

    public    $table    = "banners";
    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
        
        'category',
            
        'business_type_id',
        'category_id',
        'sub_category_id',

        'product_id',
        'service_id',
        'video_id',
        'show_on'
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'business_type_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function ($item) {
            if (!empty(static::$clearFrontendCache)) static::clearFrontendCache(true);
        });

        static::updated(function ($item) {
            if (!empty(static::$clearFrontendCache)) static::clearFrontendCache();
        });
    }
}
