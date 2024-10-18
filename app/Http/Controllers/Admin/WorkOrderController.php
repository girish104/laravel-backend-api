<?php

namespace App\Http\Controllers\Admin;

use App\Factory\WorkOrder\WorkOrderFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\WorkOrder\CreateRequest;
use App\Http\Requests\WorkOrder\UpdateRequest;
use App\Models\Order\Order;
use App\Models\Order\OrderItem;
use App\Models\WorkOrder;

use Illuminate\Http\Request;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return view('admin.work-order.index');
        return WorkOrderFactory::getDataTable();
    }

    public function orderList(Request $request)
    {
        if (!$request->ajax()) return view('admin.work-order.order-list');
        return WorkOrderFactory::getOrderDataTable();
    }


    public function orderDetail(Request $request, $order_id)
    {
        $order = Order::where('order_id', $order_id)->first();

        if (empty($order)) abort(404);
    
        $items = $order->items;

        $count_completed = 0;
        $count_cancelled  = 0;
        $count_all       = count($items ?? []);

        foreach ($items ?? [] as $item){
            if ($item->status == OrderItem::STATUS_COMPLETED)      $count_completed++;
            else if ($item->status == OrderItem::STATUS_CANCELED)  $count_cancelled++;
        }
    
        return view('admin.work-order.order-detail', compact('count_all', 'count_cancelled', 'count_completed', 'items', 'order'));
    }

    public function acceptOrder(Request $request, $order_id, $item_id)
    {
        if (WorkOrderFactory::acceptOrder($order_id, $item_id))
            return redirect()->back()->with('success', 'Order accepted successfully');

        return redirect()->back()->with('error', 'Failed to accept this order');
    }

    public function shipOrder(Request $request, $order_id, $item_id)
    {
        if (WorkOrderFactory::shipOrder($order_id, $item_id))
            return redirect()->back()->with('success', 'Order shipped successfully');

        return redirect()->back()->with('error', 'Failed to ship this order');
    }


    public function completeOrder(Request $request, $order_id, $item_id)
    {
        if (WorkOrderFactory::completeOrder($order_id, $item_id))
            return redirect()->back()->with('success', 'Order completed successfully');

        return redirect()->back()->with('error', 'Failed to complete this order');
    }

    public function rejectOrder(Request $request, $order_id, $item_id)
    {
        if (WorkOrderFactory::rejectOrder($order_id, $item_id))
            return redirect()->back()->with('success', 'Order canceled successfully');

        return redirect()->back()->with('error', 'Failed to cancel this order');
    }


    public function create()
    {
        return view('admin.work-order.create');
    }

    public function store(CreateRequest $request)
    {
        WorkOrderFactory::create(WorkOrder::class, $request->all());
        return redirect()->route('admin.work-order.index')->with('success', 'WorkOrder created successfully');
    }

    public function edit(WorkOrder $work_order)
    {
        return view('admin.work-order.edit', compact('work-order'));
    }

    public function update(UpdateRequest $request, WorkOrder $work_order)
    {
        WorkOrderFactory::update($work_order, $request->all());
        return redirect()->route('admin.work-order.index')->with('success', 'WorkOrder updated successfully');
    }

    public function destroy(WorkOrder $work_order)
    {
        $response     =  array(
            'status'  => true,
            'message' => 'WorkOrder deleted successfully'
        );

        if (!WorkOrderFactory::destroy($work_order)) {
            $response['status'] = false;
            $response['status'] = 'Something went wrong';
        }

        return response()->json($response);
    }

    public function toggleStatus($id)
    {
        $instance = WorkOrder::find($id);
        return response()->json(array(
            'status' => WorkOrderFactory::toggleStatus($instance),
        ));
    }
}
