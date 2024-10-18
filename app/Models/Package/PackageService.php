<?php

namespace App\Models\Package;


use App\Models\Service\Service;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackageService extends Model
{    
    use HasFactory, CommonMethods;
    
    public $table      = "package_services";

    protected $fillable = [
        'position',
        'service_id',
        'package_id',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
    }
}
