<?php

namespace App\Models\Business;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;

    public    $table    = "business_categories";

    public static $overideSlugViaTitle = true;

    protected $fillable = [
        'title',
        'description',
        'status',
        'business_type',
        'slug',
        'image',
        'show_on_home_page',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'business_type', 'id');
    }

    public function sub_category()
    {
        return $this->hasMany(SubCategory::class, 'category_id', 'id');
    }
}
