<?php
namespace App\Traits;

use App\Helpers\Helper;
use Illuminate\Support\Str;

trait CommonMethods
{
    // public const STATUS_ACTIVE   = 1;
    // public const STATUS_DEACTIVE = 0;

    public function scopeExclude($query, $value = [])
    {
        return $query->select(array_diff($this->fillable, (array) $value));
    }
    
    public static function getActiveRecords(...$with){
        $instance = self::orderBy('created_at');
        if (!empty($with)) {
            foreach ($with as $relation) $relations[$relation] = function ($q) { 
                $q->where('status', Helper::STATUS_ACTIVE); 
            };
            $instance->with($relations);
        }
        return $instance->where('status', Helper::STATUS_ACTIVE)->get();
    }

    public static function onlyActive(...$with){
        $instance = self::orderBy('created_at');
        if (!empty($with)) {
            foreach ($with as $relation) $relations[$relation] = function ($q) { 
                $q->where('status', Helper::STATUS_ACTIVE); 
            };
            $instance->with($relations);
        }
        return $instance->where('status', Helper::STATUS_ACTIVE);
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($item) {
            if (!in_array('slug', $item->fillable)) {
                return true;
            }
            
            if(empty($item->slug)) $item->slug = Str::slug($item->title);
            else $item->slug = Str::slug($item->slug);
            // $item->slug = Str::slug($item->title);
        });
        static::updating(function ($item) {
            if (!in_array('slug', $item->fillable)) {
                return true;
            }

            if (!empty(static::$overideSlugViaTitle)) {
                return $item->slug = Str::slug($item->title);
            }
            
            if(empty($item->slug) ) $item->slug = Str::slug($item->title);
            else $item->slug = Str::slug($item->slug);
        });

        static::created(function ($item) {
            if (!empty(static::$clearFrontendCache)) static::clearFrontendCache(true);
        });

        static::updated(function ($item) {
            if (!empty(static::$clearFrontendCache)) static::clearFrontendCache();
        });
    }


    public function getUrlAttribute()
    {
        if (empty($this->attributes['url'])) return '';
        return Helper::fileUrl($this->attributes['url']);
    }
    
    public function getImageAttribute()
    {
        // return $this->attributes['image'] ?? null;
        if (empty($this->attributes['image'])) return '';
        return Helper::fileUrl($this->attributes['image']);
    }

    public function getIconAttribute()
    {
        if (empty($this->attributes['icon'])) return '';
        return Helper::fileUrl($this->attributes['icon']);
    }

    public function getUrlOriginalAttribute()
    {
        if (!empty($this->attributes['url'])) return $this->attributes['url'];
        return '';
    }

    public function getImageOriginalAttribute()
    {
        if (!empty($this->attributes['image'])) return $this->attributes['image'];
        return '';
    }
    public function getIconOriginalAttribute()
    {
        if (!empty($this->attributes['icon'])) return $this->attributes['icon'];
        return '';
    }
}