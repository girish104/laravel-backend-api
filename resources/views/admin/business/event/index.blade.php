@extends('admin.master')
@section('child')
@push('style')
<link rel="stylesheet" href="{{ url('AdminAssets/plugins/datatables/dataTables.bootstrap4.css') }}">
@endpush

@php
$title = 'Pepup Celebrations';
$route = 'event';
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
                        <div class="create_col">
                            <a href="{{ route('admin.' . $route . '.create') }}" class="btn btn-primary" role="button"><i class="nav-icon fa fa-edit"></i> Create </a>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <!-- /.card-header -->
                        <div class="card-body table-responsive">
                            <table id="my_table" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Image</th>
                                        <th>Description</th>
                                        <th>Show On HomePage</th>
                                        <th>Featured</th>
                                        <th>Position</th>
                                        <th>Status</th>
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
                data: 'title',
                name: 'title',
                searchable: true
            },{
                data: 'image',
                name: 'image',
                searchable: false,
                orderable: false,
            },{
                data: 'description',
                name: 'description',
                searchable: true
            }, {
                data: 'show_on_home_page',
                name: 'show_on_home_page',
                searchable: true
            },{
                data: 'is_featured',
                name: 'is_featured',
                searchable: true
            },{
                data: 'position',
                name: 'position',
                searchable: true, orderable: true,
            }, {
                data: 'status',
                name: 'status',
                searchable: true
            }, {
                data: 'created_at',
                name: 'created_at',
                searchable: true
            }, {
                data: 'action',
                name: 'action',
                searchable: false,
                orderable: false,
            }],
        });
    });
</script>
@endpush
@endsection