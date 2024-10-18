<?php

namespace App\Models\Service;

use App\Models\Business\Festival;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceFestival extends Model
{    
    use HasFactory, CommonMethods;
    
    public $table      = "service_festivals";

    protected $fillable = [
       'service_id',
       'festival_id',
       'position',
    ];

    public function festival()
    {
        return $this->belongsTo(Festival::class, 'festival_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id', 'id');
    }
}
