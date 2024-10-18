<?php

namespace App\Models\Package;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Business\Category;
use App\Models\Business\SubCategory;
use App\Models\Business\SubSubCategory;

class Package extends Model
{    
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;

    public $table      = "packages";

    protected $fillable = [
        'title',
        'description',
        'summary',
        'tags',
        'detail',
        'cancellation_policy',
        'price',
        'old_price',
        'image',

        'rating',
        'reviews',
        'status',
        'meta_title',
        'meta_keywords',
        'meta_descriptions',
        'slug',
        'is_popular',
        'price_onwards',


        'business_type_id',
        'category_id',
        'sub_category_id',
    ];





    public function business_type()
    {
        return $this->belongsTo(Type::class, 'business_type_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }

    public function images()
    {
        return $this->hasMany(PackageImage::class, 'package_id', 'id');
    }

    public function service()
    {
        return $this->hasMany(PackageService::class, 'package_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(PackageProduct::class, 'package_id', 'id');
    }
}
