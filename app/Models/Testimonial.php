<?php

namespace App\Models;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;
    
    public    $table    = "testimonials";
    protected $fillable = [
        'name',
        'designation',
        'title',
        'description',
        'rating',
        'image',
        'status',
        'position',
    ];
}
