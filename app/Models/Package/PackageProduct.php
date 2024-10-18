<?php

namespace App\Models\Package;

use App\Models\Product;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageProduct extends Model
{    
    use HasFactory, CommonMethods;
    
    public $table      = "package_products";

    protected $fillable = [
        'position',
        'product_id',
        'package_id',
    ];

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    protected static function boot()
    {
        parent::boot();
    }
}
