<?php

namespace App\Models\Business;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Faq extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;
    
    public    $table    = "faqs";
    protected $fillable = [
        'question',
        'answer',
        
        'status',
        'position',

        'business_type_id',
        'category_id',
        'sub_category_id',
        'sub_sub_category_id',

        'product_id',
        'service_id',
        'package_id',
        'celebrity_id',
    ];
}
