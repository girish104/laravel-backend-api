<?php

namespace App\Models\Order;

use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes, CommonMethods;

    // protected $guarded = ['id']; 
    public $table      = "orders";

    protected $fillable = [
        'order_id',
        'user_id',
        'status',
        'total_price',

        'first_name',
        'last_name',
        'phone',
        'email',

        'city',
        'state',
        'pincode',

        'address_1',
        'address_2',
    ];


    public static function generateId($id = 0){
        return 'ORD' . rand(11, 99) . $id . rand(11, 99);
    }

    public static function assignId($instance){
        $instance->order_id = static::generateId($instance->id);
        return $instance->save();
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class, 'order_id', 'id');
    }
}
