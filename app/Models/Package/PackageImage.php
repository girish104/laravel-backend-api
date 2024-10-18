<?php

namespace App\Models\Package;

use App\Traits\ClearFrontendCache;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageImage extends Model
{    
    use HasFactory, SoftDeletes, CommonMethods;
    
    public $table      = "package_images";

    protected $fillable = [
        'position',
        'url',
        'package_id',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
    }
}
