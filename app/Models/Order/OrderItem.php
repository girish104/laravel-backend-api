<?php

namespace App\Models\Order;


use App\Traits\CommonMethods;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Celebrity;
use App\Models\Order\Order;
use App\Models\Package\Package;
use App\Models\Product;
use App\Models\Service\Service;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes, CommonMethods;

    public $table        = "order_items";
    const TYPE_PRODUCT   = 1;
    const TYPE_SERVICE   = 2;
    const TYPE_CELEBRITY = 3;
    const TYPE_PACKAGE   = 4;

    const STATUS_NEW       = 0;
    const STATUS_ACTIVE    = 1;
    const STATUS_SHIPPED   = 2;
    const STATUS_COMPLETED = 3;
    const STATUS_CANCELED  = 4;

    protected $fillable = [
        'item_order_id',
        'order_id',
        'type',
        'status',

        'item_id',
        'qty',
        'price',
        'total_price'
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    public function getItemTypeAttribute()
    {
        return strtoupper(self::getTypeName($this->attributes['type']));
    }
    

    public function getItemStatusAttribute()
    {
        $status = $this->attributes['status'];

        if ($status == self::STATUS_COMPLETED) {
            $status = 'completed';
        } else if ($status == self::STATUS_NEW) {
            $status = 'new';
        } else if ($status == self::STATUS_ACTIVE) {
            $status = 'processing';
        } else if ($status == self::STATUS_CANCELED) {
            $status = 'canceled';
        } else if ($status == self::STATUS_SHIPPED) {
            $status = 'shipping';
        } 

        return strtoupper( $status);
    }

    public function getItemStatusForUserAttribute()
    {
        $status = $this->attributes['status'];

        if ($status == self::STATUS_COMPLETED) {
            $status = 'completed';
        } else if ($status == self::STATUS_NEW) {
            $status = 'order placed';
        } else if ($status == self::STATUS_ACTIVE) {
            $status = 'processing';
        } else if ($status == self::STATUS_CANCELED) {
            $status = 'canceled';
        } else if ($status == self::STATUS_SHIPPED) {
            $status = 'shipping';
        }

        return strtoupper( $status);
    }


    public static function getItem($itemId = null, $type = null){
        return OrderItem::getModel($type)::where('id', $itemId);
    }

    public static function getItemPrice($itemId = null, $type = null){
        return self::getItem($itemId, $type)->value('price');
    }

    public static function assignOrderId($order, $instance, $number = 1){
        $instance->item_order_id = $order->order_id . 'I' . $number;
        $instance->order_id      = $order->id;
        return $instance->save();
    }

    public static function getType($type = null){
        if ($type == 'product')   return self::TYPE_PRODUCT;
        if ($type == 'service')   return self::TYPE_SERVICE;
        if ($type == 'celebrity') return self::TYPE_CELEBRITY;
        if ($type == 'package')   return self::TYPE_PACKAGE;
        return 0;
    }

    public static function getTypeName($type = null){
        if ($type == self::TYPE_PRODUCT)   return 'product';
        if ($type == self::TYPE_SERVICE)   return 'service';
        if ($type == self::TYPE_CELEBRITY) return 'celebrity';
        if ($type == self::TYPE_PACKAGE)   return 'package';
        return '';
    }

    public static function getModel($type = null){
        $itemType     = self::getType($type);
        $model        = Product::class;
        if ($itemType == OrderItem::TYPE_PRODUCT)        $model = Product::class;
        else if ($itemType == OrderItem::TYPE_CELEBRITY) $model = Celebrity::class;
        else if ($itemType == OrderItem::TYPE_PACKAGE)   $model = Package::class;
        else if ($itemType == OrderItem::TYPE_SERVICE)   $model = Service::class;
        return $model;
    }


    public function getIsCancelableAttribute()
    {
        return in_array($this->attributes['status'], [self::STATUS_ACTIVE, self::STATUS_NEW, self::STATUS_SHIPPED]);
    }

    public function getIsAcceptableAttribute()
    {
        return in_array($this->attributes['status'], [self::STATUS_NEW, self::STATUS_CANCELED]);
    }

    public function getIsProcessableAttribute()
    {
        return in_array($this->attributes['status'], [self::STATUS_ACTIVE, self::STATUS_CANCELED]);
    }

    public function getIsShippableAttribute()
    {
        if (!in_array($this->attributes['status'], [self::STATUS_ACTIVE])) {
            return false;
        }

        if (!in_array($this->attributes['type'], [self::TYPE_PRODUCT])) {
            return false;
        }

        return true;
    }

    public function getIsCompleteableAttribute()
    {
        if (!in_array($this->attributes['status'], [self::STATUS_ACTIVE, self::STATUS_SHIPPED])) {
            return false;
        }

        if ($this->attributes['type'] == [self::TYPE_PRODUCT] && $this->attributes['status'] !=  self::STATUS_SHIPPED) {
            return false;
        }

        return true;
    }

    public function getItemAttribute()
    {
        $item  = [];
        $order = $this->attributes;
        if ($order["type"] == OrderItem::TYPE_PRODUCT) {
            $detail         =  Product::with('category')->where('id', $order['item_id'])->first();
            $item           =  array(
                'title'     => $detail->title,
                'summary'   => $detail->description,
                'price'     => $detail->price,
                'image'     => $detail->image,
                'category'  => @$detail->category->title ?? '',
                'uri'       => route('admin.product.edit', $detail->id),
            );
        } else if ($order["type"] == OrderItem::TYPE_SERVICE) {
            $detail         =  Service::with('category')->where('id', $order['item_id'])->first();
            $item           =  array(
                'title'     => $detail->title,
                'summary'   => $detail->description,
                'price'     => $detail->price,
                'image'     => $detail->image,
                'category'  => @$detail->category->title ?? '',
                'uri'       => route('admin.service.edit', $detail->id),
            );
        } else if ($order["type"] == OrderItem::TYPE_PACKAGE) {
            $detail         =  Package::where('id', $order['item_id'])->first();
            $item           =  array(
                'title'     => $detail->title,
                'summary'   => $detail->summary,
                'price'     => $detail->price,
                'image'     => $detail->image,
                'category'  => 'Package',
                'uri'       => route('admin.package.edit', $detail->id),
            );
        } else if ($order["type"] == OrderItem::TYPE_CELEBRITY) {
            $detail         =  Celebrity::with('category')->where('id', $order['item_id'])->first();
            $item           =  array(
                'title'     => $detail->name,
                'summary'   => $detail->description,
                'price'     => $detail->price,
                'image'     => $detail->image,
                'category'  => @$detail->category->title ?? '',
                'uri'       => route('admin.celebrity.edit', $detail->id),
            );
        }

        return $item;
    }
}
