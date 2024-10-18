<?php

namespace App\Models\Business;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryFestival extends Model
{
    use HasFactory, SoftDeletes;
    
    public    $table    = "business_category_festivals";
    protected $fillable = [
        'category_id',
        'sub_category_id',
        'festival_id',
    ];
}
