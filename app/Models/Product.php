<?php

namespace App\Models;

use App\Models\Business\Category;
use App\Models\Business\SubCategory;
use App\Models\Business\SubSubCategory;
use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{    
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;

    // protected $guarded = ['id']; 
    public $table      = "products";

    protected $fillable = [
        'sku',
        'title',
        'slug',
        'summary',
        'description',
        'tags',
        'product_detail',
        'delivery_info',
        'cancellation_policy',
        
        'image',
        'price',
        'old_price',
        'stock',
        'weight',
        'dimensions',

        'business_type_id',
        'category_id',
        'sub_category_id',
        'sub_sub_category_1_id',
        'sub_sub_category_2_id',
        'sub_sub_category_3_id',
        'sub_sub_category_4_id',
        'sub_sub_category_5_id',
        'sub_sub_category_6_id',

        'status',
        'meta_title',
        'meta_keywords',
        'meta_descriptions',

        'gift_type_id',
        'price_onwards',
        'terms_and_conditions',
        'min_order_qty',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }

    public function sub_sub_category_1()
    {
        return $this->belongsTo(SubSubCategory::class, 'sub_sub_category_1_id', 'id');
    }
}
