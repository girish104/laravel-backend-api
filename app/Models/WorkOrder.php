<?php

namespace App\Models;

use App\Models\Business\Category;
use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WorkOrder extends Model
{
    use HasFactory, SoftDeletes, CommonMethods;
    
    public    $table    = "work_orders";
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'full_name',
        'email',
        'phone',

        'city',
        'state',
        'country',
        'pincode',
        'address_1',
        'address_2',

        'business_type_id',
        'category_id',
        'sub_category_id',
        'message',
        'date',

        'request_from'
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
