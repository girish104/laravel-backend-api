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
                        <li class="breadcrumb-item"><a href="{{ route('admin.location.index') }}">Location</a></li>
                        <li class="breadcrumb-item active">Update</li>
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
                    <!-- general form elements -->
                    <div class="card">
                        <div class="card-header d-flex p-0">
                            <h3 class="card-title p-3 titleClass">
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> Location Update
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.location.update', $location->id) }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Name <span class="redstart">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" data-parsley-trigger="keyup" data-parsley-required-message="Please enter name" value="{{ $location->name }}">
                                            <span class="redstart">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" @if ($location->status == 1) selected @endif>Active</option>
                                                <option value="0" @if ($location->status == 0) selected @endif>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Is Default</label>
                                            <select class="select" id="is_default" name="is_default">
                                                <option value="1" @if ($location->is_default == 1) selected @endif>Yes</option>
                                                <option value="0" @if ($location->is_default == 0) selected @endif>No</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('is_default') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-pencil"></i> Update</button>
                                    </div>
                                </div>
                        </form>
                    </div>
                    <!-- /.card -->
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


@push('script')

@endpush
@endsection