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

class Celebrity extends Model
{    
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;

    // protected $guarded = ['id']; 
    public $table      = "celebrities";

    protected $fillable = [
        'name',
        'slug',
        'summary',
        'description',
        'tags',
        'celebrity_detail',
        'delivery_info',
        'cancellation_policy',
        
        'image',
        'price',
        'old_price',

        'business_type_id',
        'category_id',
        'sub_category_id',

        'status',
        'meta_title',
        'meta_keywords',
        'meta_descriptions',
        'price_onwards'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    
    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }

    // public function sub_sub_category_1()
    // {
    //     return $this->belongsTo(SubSubCategory::class, 'sub_sub_category_1_id', 'id');
    // }
}
