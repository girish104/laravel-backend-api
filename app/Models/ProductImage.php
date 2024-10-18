<?php

namespace App\Models;

use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductImage extends Model
{    
    use HasFactory, SoftDeletes, CommonMethods;
    
    public $table      = "product_images";

    protected $fillable = [
        'position',
        'url',
        'product_id',

    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
