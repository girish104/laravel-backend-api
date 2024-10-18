<?php

namespace App\Models\Business;

use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubSubCategory extends Model
{
    use HasFactory, SoftDeletes, CommonMethods;

    public    $table    = "business_sub_sub_categories";

    public  static  $overideSlugViaTitle = true;

    protected $fillable = [
        'category_id',
        'sub_category_id',
        'business_type',
        'type',
        'title',
        'description',
        'status',
        'slug',

        'sub_sub_category_1_id',
        'sub_sub_category_2_id',
        'sub_sub_category_3_id',
        'sub_sub_category_4_id',
        'sub_sub_category_5_id',
        'sub_sub_category_6_id',
    ];

    public function businesstype()
    {
        return $this->belongsTo(Type::class, 'business_type', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class, 'sub_category_id', 'id');
    }
}
