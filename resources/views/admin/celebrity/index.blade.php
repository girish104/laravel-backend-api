@extends('admin.master')
@section('child')
@push('style')
<link rel="stylesheet" href="{{ url('AdminAssets/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@php 
$title = 'Celebrity';
$route = 'celebrity';
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.celebrity.index') }}">Celebrities</a></li>
                        <li class="breadcrumb-item active">List</li>
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
                        <div class="create_col">
                            <a href="{{ route('admin.' . $route . '.create') }}" class="btn btn-primary" role="button"><i class="nav-icon fa fa-edit"></i> Create </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="product_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Image</th>
                                        <th>Name</th>
                                        <th>Category</th>
                                        <th>Sub Category</th>
                                        <th>Overviews</th>
                                        <th>Popular</th>
                                        <th>Status</th>
                                        <th>Date Time</th>
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
        $("#product_table").DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ url()->full() }}",
            columns: [{
                "data": 'DT_RowIndex',
                orderable: false,
                searchable: false
            },{
                data: 'image',
                name: 'image',
                searchable: true
            }, {
                data: 'name',
                name: 'name',
                searchable: true
            }, {
                data: 'category',
                name: 'category',
                searchable: true
            },{
                data: 'sub_category',
                name: 'sub_category',
                searchable: true
            },
            {
                data: 'summary',
                name: 'summary',
                searchable: true
            },{
                data: 'is_popular',
                name: 'is_popular',
                searchable: false,
            }, {
                data: 'status',
                name: 'status',
                searchable: true
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: true
            },{
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }],
        });
    });
</script>
@endpush
@endsection