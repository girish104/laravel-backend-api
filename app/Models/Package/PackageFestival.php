<?php

namespace App\Models\Package;

use App\Models\Business\Festival;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageFestival extends Model
{    
    use HasFactory, CommonMethods;
    
    public $table      = "package_festivals";

    protected $fillable = [
       'festival_id',
       'package_id',
       'position',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function festival()
    {
        return $this->belongsTo(Festival::class, 'festival_id', 'id');
    }
}
