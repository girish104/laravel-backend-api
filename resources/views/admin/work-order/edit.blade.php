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
                        <li class="breadcrumb-item"><a href="{{ route('admin.gift.index') }}">Gift</a></li>
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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> Gift Update
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.gift.update', $gift->id) }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" data-parsley-trigger="keyup" data-parsley-required-message="Please enter title" value="{{ $gift->title }}">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" @if ($gift->status == 1) selected @endif>Active</option>
                                                <option value="0" @if ($gift->status == 0) selected @endif>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea height="200px" id="description" name="description" data-parsley-trigger="keyup" data-parsley-required-message="Please enter description" class="form-control">{{ $gift->description }}</textarea>
                                            <span class="redstart">{{ $errors->first('description') }}</span>

                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-pencil">
                                            </i> Update</button>
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