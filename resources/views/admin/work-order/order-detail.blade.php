@extends('admin.master')


@section('child')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dash') }}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.work-order.order-list') }}">Orders</a></li>
                        <li class="breadcrumb-item active">Detail</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3 ">
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> Order Detail
                            </h3>
                        </div>
                        <form>
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Order ID</label>
                                            <h6>
                                                {{ $order->order_id }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Full Name</label>
                                            <h6>
                                                {{ $order->first_name . ' ' . $order->last_name }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Phone</label>
                                            <h6>
                                                {{ $order->phone }}
                                            </h6>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Email</label>
                                            <h6>
                                                {{ $order->email }}
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Address 1</label>
                                            <h6>
                                                {{ $order->address_1 }}
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Address 2</label>
                                            <h6>
                                                {{ $order->address_2 }}
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Pincode</label>
                                            <h6>
                                                {{ $order->pincode }}
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">City</label>
                                            <h6>
                                                {{ $order->city }}
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">State</label>
                                            <h6>
                                                {{ $order->state }}
                                            </h6>
                                        </div>
                                    </div>

                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status (All/Completed/cancelled)</label>
                                            <h6> {{ $count_all }}/{{ $count_completed }}/{{ $count_cancelled }} </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-header d-flex  p-0 ">
                        <h3 class="card-title p-3 ">
                            <i class="fa fa-list" aria-hidden="true"></i> Order Items
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="my_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Item Order ID</th>
                                        <th>Item</th>
                                        <th>Type</th>
                                        <th>Quantity</th>
                                        <th>Price/Total</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="document_table">
                                    @foreach($items as $key => $item)
                                    <tr>
                                        <th>{{ $key+1 }}</th>
                                        <td>{{ $item->item_order_id }}</td>
                                        <td> <a href="{{ $item->item['uri'] ?? '#' }}" target="_blank" rel="noopener noreferrer">{{ $item->item['title'] ?? '' }}</a> </td>
                                        <td>{{ $item->item_type }}</td>
                                        <td>{{ $item->qty }}</td>
                                        <td>₹{{ $item->price }}/₹{{ $item->total_price }}</td>
                                        <td>{{ $item->item_status }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default">Action</button>
                                                <button type="button" class="btn btn-default dropdown-toggle dropdown-icon" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <div class="dropdown-menu" role="menu" >
                                                    <a class="dropdown-item" href="{{ $item->item['uri'] ?? '#' }}" target="_blank">View Item</a>
                                                    <!-- <a class="dropdown-item" href="#">Another action</a>
                                                    <a class="dropdown-item" href="#">Something else here</a> -->
                                                    <div class="dropdown-divider"></div>
                                                    @if($item->is_acceptable)
                                                    <a class="dropdown-item" href="{{ route('admin.work-order.accept-order', [$order->order_id, $item->item_order_id]) }}">Accept</a>
                                                    @endif
                                                    @if($item->is_shippable)
                                                    <a class="dropdown-item" href="{{ route('admin.work-order.ship-order', [$order->order_id, $item->item_order_id]) }}">Start Shipping</a>
                                                    @endif
                                                    @if($item->is_completeable)
                                                    <a class="dropdown-item" href="{{ route('admin.work-order.complete-order', [$order->order_id, $item->item_order_id]) }}">Complete</a>
                                                    @endif
                                                    @if($item->is_cancelable)
                                                    <a class="dropdown-item" href="{{ route('admin.work-order.reject-order', [$order->order_id, $item->item_order_id]) }}">Reject/Cancel</a>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
    </section>
    <!-- /.content -->
</div>
@push('script')

@endpush
@endsection