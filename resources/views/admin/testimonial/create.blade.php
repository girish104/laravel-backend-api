@extends('admin.master')
@section('child')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css">
@endpush

@php
$title = 'Testimonial';
$route = 'testimonial';
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
                        <li class="breadcrumb-item active">Create</li>
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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i>{{ $title }} Create
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.' . $route . '.store') }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Name <span class="redstart">*</span></label>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Enter name" value="{{ old('name') }}" data-parsley-trigger="keyup" data-parsley-required-message="Please enter name">
                                            <span class="redstart">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Designation </label>
                                            <input type="text" name="designation" id="designation" class="form-control" placeholder="Enter Designation. (Like: CEO of xyz.)" value="{{ old('designation') }}" data-parsley-trigger="keyup" data-parsley-required-message="Please enter designation">
                                            <span class="redstart">{{ $errors->first('designation') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Position</label>
                                            <input type="number" min="1" name="position" id="position" class="form-control" placeholder="Enter festival position"  data-parsley-trigger="keyup" data-parsley-required-message="Please enter position" value="1">
                                            <span class="redstart">{{ $errors->first('position') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Rating</label>
                                            <select class="select" id="rating" name="rating">
                                                @foreach(range(5, 1) as $rating)
                                                <option value="{{ $rating }}" {{ old('rating') == $rating ? 'selected' : '' }}>{{ $rating }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('rating') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Image</label>
                                        <input type="hidden" id="thumb_image" name="image" value="{{ old('image') }}">
                                        <div class="dropzone thumb_image dropzone-file-area" style="min-height: 150px;">
                                            <div class="dz-default dz-message">
                                                <h3 class="sbold">Drop Image here to upload</h3>
                                                <span>You can also click to open file browser</span>
                                            </div>
                                        </div>
                                        <span class="redstart">{{ $errors->first('image') }}</span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter title" value="{{ old('title') }}" data-parsley-trigger="keyup" data-parsley-required-message="Please enter title">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea height="200px" id="description" name="description" data-parsley-trigger="keyup" data-parsley-required-message="Please enter description" class="form-control">{{ old('description') }}</textarea>
                                            <span class="redstart">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-pencil"></i> Create</button>
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
        url: "{{ route('storage.upload', ['celebrity']) }}",
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