<?php

namespace App\Models\Business;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Location extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;

    public    $table    = "business_locations";
    protected $fillable = [
        'name',
        'status',
        'is_default',
        'position',
        'slug',
    ];
}
