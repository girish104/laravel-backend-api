<?php

namespace App\Models\Product;

use App\Models\Business\Festival;
use App\Models\Product;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFestival extends Model
{    
    use HasFactory, CommonMethods;
    
    public $table      = "product_festivals";

    protected $fillable = [
       'festival_id',
       'product_id',
       'position',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function festival()
    {
        return $this->belongsTo(Festival::class, 'festival_id', 'id');
    }
}
