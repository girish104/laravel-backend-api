@extends('admin.master')
@section('child')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css">
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
                        <form role="form" action="{{ route('admin.' . $route . '.update', $event->id) }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-7 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product title" value="{{ $event->title }}">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Position</label>
                                            <input type="number" min="1" name="position" id="position" class="form-control" placeholder="Enter festival position" data-parsley-trigger="keyup" data-parsley-required-message="Please enter position" value="{{ $event->position }}">
                                            <span class="redstart">{{ $errors->first('position') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" @if ($event->status == 1) selected @endif>Active</option>
                                                <option value="0" @if ($event->status == 0) selected @endif>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Home Page</label>
                                            <select class="select" id="show_on_home_page" name="show_on_home_page">
                                                <option value="1" @if ($event->show_on_home_page == 1) selected @endif>Yes</option>
                                                <option value="0" @if ($event->show_on_home_page == 0) selected @endif>No</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('show_on_home_page') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Featured</label>
                                            <select class="select" id="is_featured" name="is_featured">
                                                <option value="1" @if ($event->is_featured == 1) selected @endif>Yes</option>
                                                <option value="0" @if ($event->is_featured == 0) selected @endif>No</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('is_featured') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Col Width</label>
                                            <select class="select" id="col_width" name="col_width">
                                                @foreach(range(1, 12) as $width)
                                                <option value="{{ $width }}" @if ($event->col_width == $width) selected @endif>{{ $width }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('col_width') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thumbnail<span class="redstart"> * </span> </label>
                                            <input type="hidden" id="thumb_image" name="image" value="{{ $event->image_original }}">
                                            <div class="dropzone thumb_image dropzone-file-area" style="min-height: 150px;">
                                                <div class="dz-default dz-message">
                                                    <h3 class="sbold">Drop Image here to upload</h3>
                                                    <span>You can also click to open file browser</span>
                                                </div>
                                                <img src="{{ $event->image }}" height="100" width="100px">
                                            </div>
                                            <span class="redstart">{{ $errors->first('image') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Overview <span class="redstart"> * </span> </label>
                                            <textarea min-height="200px" id="summary" name="summary" data-parsley-trigger="keyup" data-parsley-required-message="Please enter event overview" class="form-control summary">{!! $event->summary !!}</textarea>
                                            <span class="redstart">{{ $errors->first('summary') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Price <span class="redstart"> * </span></label>
                                            <input type="number" name="price" id="price" min="0" max="100000000" value="{{ $event->price }}" class="form-control" placeholder="Enter event price" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter event price">
                                            <span class="redstart">{{ $errors->first('price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Original Price</label>
                                            <input type="number" name="old_price" id="old_price" min="0" max="100000000" value="{{ $event->old_price }}" class="form-control" placeholder="Enter event original price" data-parsley-trigger="keyup" data-parsley-required-message="Please enter event original price">
                                            <span class="redstart">{{ $errors->first('old_price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Tags </label>
                                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter event tags" value="{{ $event->tags }}" data-parsley-trigger="keyup" data-parsley-required-message="Please enter event tags">
                                            <span class="redstart">{{ $errors->first('tags') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Detail</label>
                                            <textarea min-height="200px" id="description" name="description" class="form-control description">{!! $event->description !!}</textarea>
                                            <span class="redstart">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Cancellation Policy</label>
                                            <textarea min-height="200px" id="cancellation_policy" name="cancellation_policy" class="form-control cancellation_policy"> {!! $event->cancellation_policy !!}</textarea>
                                            <span class="redstart">{{ $errors->first('cancellation_policy') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Seo Url</label>
                                            <input type="text" name="slug" id="slug" value="{{ $event->slug }}" class="form-control" placeholder="Enter SEO url">
                                            <span class="redstart">{{ $errors->first('slug') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Title </label>
                                            <input type="text" name="meta_title" id="meta_title" value="{{ $event->meta_title }}" class="form-control" placeholder="Enter meta title">
                                            <span class="redstart">{{ $errors->first('meta_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-7 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Keywords </label>
                                            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ $event->meta_keywords }}" class="form-control" placeholder="Enter meta keywords">
                                            <span class="redstart">{{ $errors->first('meta_keywords') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta descriptions </label>
                                            <input type="text" name="meta_descriptions" id="meta_descriptions" value="{{ $event->meta_descriptions }}" class="form-control" placeholder="Enter meta description">
                                            <span class="redstart">{{ $errors->first('meta_descriptions') }}</span>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/dropzone.min.js"></script>
<script>
    var thumb_image = new Dropzone(".thumb_image", {
        url: "{{ route('storage.upload', ['event']) }}",
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


<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#summary')).then(editor => {
        // editor.ui.view.editable.element.style.minHeight = '100px';
    }).catch(console.error);

    ClassicEditor.create(document.querySelector('#description')).then(editor => {
        // editor.ui.view.editable.element.style.minHeight = '100px';
    }).catch(console.error);

    ClassicEditor.create(document.querySelector('#cancellation_policy')).then(editor => {
        // editor.ui.view.editable.element.style.minHeight = '100px';
    }).catch(console.error);
</script>


@endpush
@endsection