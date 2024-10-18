<?php

namespace App\Models\Business;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WhyChooseUs extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;
    
    public const STATUS_ACTIVE = 1;
    public const STATUS_DEACTIVE = 0;
    
    public    $table    = "why_choose_us";
    protected $fillable = [
        'title',
        'description',
        'status',
        'position',
        'image',
        'slug',
    ];
}
