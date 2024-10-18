<?php

namespace App\Factory\WorkOrder;

use App\Factory\Factory;
use App\Helpers\Helper;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\WorkOrder;
use Illuminate\Support\Str;

class WorkOrderFactory extends Factory
{
    public static function getDataTable()
    {
        return datatables()::of(WorkOrder::orderBy('created_at', 'desc')->get())->addIndexColumn()
            // ->editColumn('status', function ($type) {
            //     $checked = empty($type->status) ? '' : 'checked';
            //     $html  =  '<label class="switch">';
            //     $html .=  '<input type="checkbox" class="toggleShowStatus" data-target=' . route('admin.WorkOrder.toggle-status', $type->id) . ' data-id="' . $type->id . '" ' . $checked . ' >';
            //     $html .=  '<span class="slider round"></span>';
            //     $html .=  '</label>';
            //     return $html;
            // })
            ->editColumn('address', function ($row) {
                return $row->address_1 . ' ' . $row->address_2;
            })
            ->editColumn('category', function ($row) {
                return empty($row->category->title) ? $row->category_id : $row->category->title;
            })
            ->editColumn('sub_category', function ($row) {
                return empty($row->sub_category->title) ? '' : $row->sub_category->title;
            })
            // ->editColumn('message', function ($row) {
            //     return Str::limit($row->summary, 100);
            // })
            ->editColumn('url', function ($row) {
                if (empty($row->request_from )) {
                   return '-';
                }

                return '<a href="' .  $row->request_from . '" target="_blank" class="btn  btn-sm" role="button"><i class="fa fa-share" aria-hidden="true"></i></a>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            // ->editColumn('type', function ($row) {
            //     return empty($row->type->title) ? '' : $row->type->title;
            // })
            ->editColumn('action', function ($row) {
                $html = '';
                // $html  = '<a href="' . route('admin.work-order.edit', $row->id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.work-order.destroy', $row->id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'url'])
            ->make(true);
    }


    public static function getOrderDataTable()
    {
        return datatables()::of(Order::with('items')->orderBy('created_at', 'desc')->get())->addIndexColumn()
            ->editColumn('full_name', function ($row) {
                return $row->first_name . ' ' . $row->last_name;
            })
            ->editColumn('email', function ($row) {
                return $row->email ?? '-';
            })
            ->editColumn('address', function ($row) {
                return $row->address_1 . ' ' . $row->address_2;
            })
            ->editColumn('category', function ($row) {
                return empty($row->category->title) ? $row->category_id : $row->category->title;
            })
            ->editColumn('sub_category', function ($row) {
                return empty($row->sub_category->title) ? '' : $row->sub_category->title;
            })
            ->editColumn('status', function ($row) {
                $completed = 0;
                $all       = count($row->items ?? []);

                foreach ($row->items ?? [] as $item)
                    if ($item->status == OrderItem::STATUS_COMPLETED)
                        $completed++;

                return "$all / $completed";
            })
            ->editColumn('url', function ($row) {
                if (empty($row->request_from )) {
                   return '-';
                }

                return '<a href="' .  $row->request_from . '" target="_blank" class="btn  btn-sm" role="button"><i class="fa fa-share" aria-hidden="true"></i></a>';
            })
            ->editColumn('created_at', function ($row) {
                return $row->created_at->format('Y-m-d');
            })
            ->editColumn('action', function ($row) {
                $html = '';
                $html  = '<a href="' . route('admin.work-order.order-detail', $row->order_id) . '" class="btn btn-primary  btn-sm" role="button"><i class="fa fa-edit" aria-hidden="true"></i></a>';
                // $html .= '<button  class="btn btn-danger  btn-sm deleteItemRow" data-target="' . route('admin.work-order.destroy', $row->order_id) . '" ><i class="nav-icon fa fa-trash"></i></button>';
                return $html;
            })
            ->rawColumns(['action', 'url'])
            ->make(true);
    }


    public static function rejectOrder($orderId, $itemId){
        $status = Helper::safeTransaction(function() use ($itemId){
            $item         = OrderItem::where('item_order_id', $itemId)->first();
            if (!$item->is_cancelable) return false;
            $item->status = OrderItem::STATUS_CANCELED;
            $item->save();
            return true;
        });

        return $status ? Helper::getTransactionResult() : $status;
    }

    public static function acceptOrder($orderId, $itemId){
        $status = Helper::safeTransaction(function() use ($itemId){
            $item         = OrderItem::where('item_order_id', $itemId)->first();
            if (!$item->is_acceptable) return false;
            $item->status = OrderItem::STATUS_ACTIVE;
            $item->save();
            return true;
        });

        return $status ? Helper::getTransactionResult() : $status;
    }

    public static function shipOrder($orderId, $itemId){
        $status = Helper::safeTransaction(function() use ($itemId){
            $item         = OrderItem::where('item_order_id', $itemId)->first();
            if (!$item->is_shippable) return false;
            $item->status = OrderItem::STATUS_SHIPPED;
            $item->save();
            return true;
        });
        return $status ? Helper::getTransactionResult() : $status;
    }

    public static function completeOrder($orderId, $itemId){
        $status = Helper::safeTransaction(function() use ($itemId){
            $item         = OrderItem::where('item_order_id', $itemId)->first();
            if (!$item->is_completeable) return false;
            $item->status = OrderItem::STATUS_COMPLETED;
            $item->save();
            return true;
        });
        return $status ? Helper::getTransactionResult() : $status;
    }
}
