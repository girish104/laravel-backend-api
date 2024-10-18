<?php

namespace App\Http\Controllers\Api\V1;

use App\Helpers\Helper;
use App\Models\Business\Category;
use App\Models\Celebrity;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\Package\Package;
use App\Models\Product;
use App\Models\Service\Service;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function create(Request $request)
    {
        // if (!$request->user()->tokenCan('order:create'))  return self::error('Unauthorised.', ['error'=>'Unauthorised']);

        $result = [];
        $status = Helper::safeTransaction(function() use ($request, &$result){
            $orders             = [];
            $currentOrder       = Order::create([...$request->detail, ...['user_id' => $request->user_id]]);

            Order::assignId($currentOrder);

            $result['orders']   = [];
            $result['order_id'] = $currentOrder->order_id;

            foreach ($request->items  as $key => $item) {
                $orderItemToBeSaved                  = [];
                $orderItemToBeSaved['qty']           = (int) $item['qty'];
                $orderItemToBeSaved['price']         = OrderItem::getItemPrice($item['item_id'], $item['type']);
                $orderItemToBeSaved['total_price']   = $orderItemToBeSaved['price'] * $orderItemToBeSaved['qty'];
                $orderItemToBeSaved['order_id']      = $currentOrder->id;
                $orderItemToBeSaved['item_order_id'] = $currentOrder->order_id . 'I' . ($key+1);
                $orderItemToBeSaved['type']          = OrderItem::getType($item['type']);
                $orderItemToBeSaved['item_id']       = $item['item_id'];
                $orderItemToBeSaved['created_at']    = now();
                $orderItemToBeSaved['updated_at']    = now();

                $orders[]                       = $orderItemToBeSaved;
                $result['orders'][]             = $orderItemToBeSaved['item_order_id'];
            }

            OrderItem::insert($orders);
        });

        if (!$status) 
            return self::error('Something went wrong', $result);
        
        return self::response($result);
    }


    public function list(Request $request)
    {
        // if (!$request->user()->tokenCan('order:read'))  return self::error('Unauthorised.', ['error'=>'Unauthorised']);

        $userOrders  = Order::where('user_id', $request->user_id)->pluck('order_id', 'id')->toArray();
        $orders      = OrderItem::select('item_order_id', 'order_id', 'type', 'item_id', 'status', 'qty', 'price', 'total_price' , 'created_at')
                        ->whereIn('order_id', array_keys($userOrders))->orderby('created_at', 'desc')->get();

        $all       = [];
        $completed = [];
        $canceled  = [];

        foreach ($orders ?? [] as $order) {
            $detail  = null;
            $item    = [];
            if ($order["type"] == OrderItem::TYPE_PRODUCT) {
                $detail         = Product::with('category')->where('id', $order['item_id'])->first();
                $item['detail'] = array(
                    'title'     => $detail->title,
                    'summary'   => $detail->description,
                    'price'     => $detail->price,
                    'image'     => $detail->image,
                    'category'  => @$detail->category->title ?? '',
                    'uri'       => '/product/' . @$detail->category->slug . '/' . @$detail->slug
                );
            } else if ($order["type"] == OrderItem::TYPE_SERVICE) {
                $detail         = Service::with('category')->where('id', $order['item_id'])->first();
                $item['detail'] = array(
                    'title'     => $detail->title,
                    'summary'   => $detail->description,
                    'price'     => $detail->price,
                    'image'     => $detail->image,
                    'category'  => @$detail->category->title ?? '',
                    'uri'       => '/service/' . @$detail->category->slug . '/' . @$detail->slug
                );
            } else if ($order["type"] == OrderItem::TYPE_PACKAGE) {
                $detail         = Package::with('category')->where('id', $order['item_id'])->first();
                $item['detail'] = array(
                    'title'     => $detail->title,
                    'summary'   => $detail->summary,
                    'price'     => $detail->price,
                    'image'     => $detail->image,
                    'category'  => 'Package',
                    'uri'       => '/package/' . @$detail->category->slug . '/' . @$detail->slug
                );
            } else if ($order["type"] == OrderItem::TYPE_CELEBRITY) {
                $detail         = Celebrity::with('category')->where('id', $order['item_id'])->first();
                $item['detail'] = array(
                    'title'     => $detail->name,
                    'summary'   => $detail->description,
                    'price'     => $detail->price,
                    'image'     => $detail->image,
                    'category'  => @$detail->category->title ?? '',
                    'uri'       => '/celebrity/' . @$detail->category->slug . '/' . @$detail->slug
                );
            }

            $item['total_price']   = $order['total_price'];
            $item['price']         = $order['price'];
            $item['status']        = $order['item_status_for_user'];
            $item['type']          = OrderItem::getTypeName($order['type']);
            $item['item_order_id'] = $order['item_order_id'];
            $item['order_id']      = $userOrders[$order['order_id']] ?? '-';
            $item['date']          = $order->created_at->format('Y-m-d');
            $item['qty']           = (int) $order['qty'];
            $all[]                 = $item;

            if ($order['status'] === OrderItem::STATUS_COMPLETED)
                $completed[]       = $item;
            
            if ($order['status'] === OrderItem::STATUS_CANCELED)
                $canceled[]        = $item;
        }
       
        $response = array(
            'all'       => array(
                'count' => count($all),
                'list'  => $all,
            ),
            'completed' => array(
                'count' => count($completed),
                'list'  => $completed,
            ),
            'canceled' => array(
                'count' => count($canceled),
                'list'  => $canceled,
            ),
        );

        return self::response($response);
    }
}
