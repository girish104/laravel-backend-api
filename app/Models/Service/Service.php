<?php

namespace App\Models\Service;

use App\Models\Business\Category;
use App\Models\Business\SubCategory;
use App\Models\Business\SubSubCategory;
use App\Models\Business\Type;
use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{    
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;

    // protected $guarded = ['id']; 
    public $table      = "services";

    protected $fillable = [
        'title',
        'description',
        'summary',
        'tags',
        'service_detail',
        'delivery_info',
        'cancellation_policy',
        'price',
        'old_price',
        'image',
        'icon',

        'rating',
        'reviews',

        'business_type_id',
        'category_id',
        'sub_category_id',
        'sub_sub_category_id',
        // 'sub_sub_category_1_id',
        // 'sub_sub_category_2_id',
        // 'sub_sub_category_3_id',
        // 'sub_sub_category_4_id',
        // 'sub_sub_category_5_id',
        // 'sub_sub_category_6_id',

        'status',

        'meta_title',
        'meta_keywords',
        'meta_descriptions',
        'slug',
        'price_onwards',
        'col_width',
        'show_on_home_page',
        'position'
    ];


    


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function business_type()
    {
        return $this->belongsTo(Type::class, 'business_type_id', 'id');
    }
    
    public function images()
    {
        return $this->hasMany(ServiceImage::class, 'service_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }

    public function sub_sub_category()
    {
        return $this->belongsTo(SubSubCategory::class, 'sub_sub_category_id', 'id');
    }

    public function sub_sub_category_1()
    {
        return $this->belongsTo(SubSubCategory::class, 'sub_sub_category_1_id', 'id');
    }
}
