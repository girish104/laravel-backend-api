<?php

namespace App\Models\Business;

use App\Models\Package\PackageFestival;
use App\Models\Product\ProductFestival;
use App\Models\Service\ServiceFestival;
use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Festival extends Model
{
    use HasFactory, SoftDeletes, CommonMethods, ClearFrontendCache;

    public static $overideSlugViaTitle = true;

    public    $table    = "business_festivals";
    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'slug',
        'position',
    ];


    public function package()
    {
        return $this->hasMany(PackageFestival::class, 'festival_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(ProductFestival::class, 'festival_id', 'id');
    }

    public function service()
    {
        return $this->hasMany(ServiceFestival::class, 'festival_id', 'id');
    }
}
