<?php

namespace App\Models\Service;

use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServiceImage extends Model
{    
    use HasFactory, SoftDeletes, CommonMethods;
    
    public $table      = "service_images";

    protected $fillable = [
        'position',
        'url',
        'service_id',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'services_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
    }
}
