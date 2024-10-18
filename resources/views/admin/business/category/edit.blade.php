@extends('admin.master')
@section('child')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css">
@endpush


@php
$title = 'Category';
$route = 'category';
@endphp

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.' . $route . '.index') }}">{{ $title }}</a></li>
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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i>{{ $title }} Update
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.' . $route . '.update', $category->id) }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-5 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title"  data-parsley-trigger="keyup" data-parsley-required-message="Please enter product title" value="{{ $category->title }}">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Business Type</label>
                                            <select class="select"  name="business_type">
                                                <option value="">Select Business Type</option>
                                                @foreach($business_types as $type)
                                                <option value="{{ $type->id }}" {{ $category->business_type === $type->id ? 'selected' : '' }} >{{ $type->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('business_type') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" @if ($category->status == 1) selected @endif>Active</option>
                                                <option value="0" @if ($category->status == 0) selected @endif>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Show On Home Page</label>
                                            <select class="select" id="status" name="show_on_home_page">
                                                <option value="1" @if ($category->show_on_home_page == 1) selected @endif>Active</option>
                                                <option value="0" @if ($category->show_on_home_page == 0) selected @endif>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('show_on_home_page') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thumbnail<span class="redstart"> * </span> </label>
                                            <input type="hidden" id="thumb_image" name="image" value="{{ $category->image_original }}">
                                            <div class="dropzone thumb_image dropzone-file-area" style="min-height: 150px;">
                                                <div class="dz-default dz-message">
                                                    <h3 class="sbold">Drop Image here to upload</h3>
                                                    <span>You can also click to open file browser</span>
                                                </div>
                                                <img src="{{ $category->image }}" height="100" width="100px">
                                            </div>
                                            <span class="redstart">{{ $errors->first('image') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea height="200px" id="description" name="description" data-parsley-trigger="keyup" data-parsley-required-message="Please enter description" class="form-control">{{ $category->description }}</textarea>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script>
    var thumb_image = new Dropzone(".thumb_image", {
        url: "{{ route('storage.upload', ['festival']) }}",
        autoProcessQueue: true,
        uploadMultiple: false,
        maxFilesize: 5,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
    });
    thumb_image.on("sending", function(file, xhr, formData) {
        formData.append("_token", CSRF_TOKEN);
        // $('.oldImage').remove();
    });
    thumb_image.on("error", function(file, response) {
        $(file.previewElement).addClass("dz-error").find('.dz-error-message').text('Please upload valid file');
    });
    thumb_image.on("success", function(file, response) {
        if (response.status)
            $('#thumb_image').val(response.url)
    });

</script>
@endpush
@endsection