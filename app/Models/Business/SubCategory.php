<?php

namespace App\Models\Business;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;
    
    public    $table    = "business_sub_categories";

    public static $overideSlugViaTitle = true;

    protected $fillable = [
        'category_id',
        'title',
        'description',
        'status',
        'business_type',
        'slug',
    ];

    public function type()
    {
        return $this->belongsTo(Type::class, 'business_type', 'id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
