@extends('admin.master')
@section('child')
@push('style')
<link rel="stylesheet" href="{{ url('AdminAssets/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@php
$title = 'Work Order';
$route = 'work-order';
@endphp

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dash') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <!-- general form elements -->
                <div class="card">
                    <div class="card-header d-flex  p-0 tableHeadingContainer">
                        <h3 class="card-title p-3 titleClass">
                            <i class="fa fa-newspaper-o" aria-hidden="true"></i> {{ $title }}
                        </h3>
                    </div>
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="my_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Request Page</th>
                                        <th>Category</th>
                                        <th>Address</th>
                                        <!-- <th>Status</th> -->
                                        <th>Date</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody class="document_table">
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
    <!-- right col -->
</div>



@push('script')
<!-- DataTables -->
<script src="{{ url('AdminAssets/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ url('AdminAssets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>
<script>
    $(document).ready(function() {
        $("#my_table").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url()->full() }}",
            columns: [{
                    "data": 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                }, {
                    data: 'full_name',
                    name: 'full_name',
                    searchable: true
                }, {
                    data: 'phone',
                    name: 'phone',
                    searchable: true
                }, {
                    data: 'email',
                    name: 'email',
                    searchable: true
                }, {
                    data: 'url',
                    name: 'url',
                    searchable: true
                },
                {
                    data: 'category',
                    name: 'category',
                    searchable: false,
                    orderable: false,
                },
                {
                    data: 'address',
                    name: 'address',
                    searchable: false,
                    orderable: false,
                },
                // {
                //     data: 'status',
                //     name: 'status',
                //     searchable: true
                // }, 
                {
                    data: 'date',
                    name: 'date',
                    searchable: true
                },
                {
                    data: 'created_at',
                    name: 'created_at',
                    searchable: true
                },
                {
                    data: 'action',
                    name: 'action',
                    searchable: false,
                    orderable: false,
                }
            ],
        });
    });
</script>
@endpush
@endsection