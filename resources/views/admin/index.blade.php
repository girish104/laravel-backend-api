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
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">

                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">
                    <div class="card-header d-flex p-0">
                        <h3 class="card-title p-3 titleClass">
                            <i class="fa fa-home" aria-hidden="true"></i>

                            Dashboard
                        </h3>

                    </div><!-- /.card-header -->


                    <div class="card-body">

                        <div class="container-fluid h-100">
                            
                            <!-- <div class="card card-row card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        To Do
                                    </h3>
                                </div>
                                <div class="card-body">
                                    <div class="card card-primary card-outline">
                                        <div class="card-header">
                                            <h5 class="card-title">Create first milestone</h5>
                                            <div class="card-tools">
                                                <a href="#" class="btn btn-tool btn-link">#5</a>
                                                <a href="#" class="btn btn-tool">
                                                    <i class="fas fa-pen"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                             -->
                        </div>
                    </div>
                    <!-- /.card -->

                    <!-- /.row (main row) -->
                </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
