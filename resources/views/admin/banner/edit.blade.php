@extends('admin.master')
@section('child')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css">
@endpush

@php
$title = 'Banner';
$route = 'banner';
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
                        <form role="form" action="{{ route('admin.' . $route . '.update', $banner->id) }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title"  data-parsley-trigger="keyup" data-parsley-required-message="Please enter product title" value="{{ $banner->title }}">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Youtube Video Id </label>
                                            <input type="text" name="video_id" id="video_id" class="form-control" placeholder="Enter Youtube Video Id"  data-parsley-trigger="keyup" data-parsley-required-message="Please enter video id" value="{{ $banner->video_id }}">
                                            <span class="redstart">{{ $errors->first('video_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" @if ($banner->status == 1) selected @endif>Active</option>
                                                <option value="0" @if ($banner->status == 0) selected @endif>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Category</label>
                                            <select class="select" id="category" name="category">
                                                @foreach(['HOME'] as $key => $category)
                                                <option value="{{ $key }}" @if ($banner->category == $key) selected @endif>{{ $category }}</option>
                                                @endforeach
                                                @foreach($business_types as $type)
                                                <option value="{{ $type->id }}" @if ($banner->category == $type->id) selected @endif>{{ $type->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('category') }}</span>
                                        </div>
                                    </div> -->

                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Type<span class="redstart">*</span></label>
                                            @php $subSubSubCategoryTypes = []; @endphp
                                            <select class="select business_type"  name="business_type_id">
                                                <option value="">Select Business Type</option>
                                                @foreach(['HOME'] as $key => $category)
                                                <option value="{{ $key }}" @if ($banner->business_type_id == $key) selected @endif>{{ $category }}</option>
                                                @endforeach
                                                @foreach($business_types as $type)
                                                @php 
                                                    if($type->title == 'Product') $subSubSubCategoryTypes[$type->id][] = [1];
                                                    else if($type->title == 'Celebrity') $subSubSubCategoryTypes[$type->id][] = [];
                                                    else $subSubSubCategoryTypes[$type->id][] = range(1, 6);
                                                @endphp
                                                <option value="{{ $type->id }}" {{ $banner->business_type_id == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('business_type') }}</span>
                                        </div>
                                    </div>
                                    @php $categories = []; @endphp
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Category<span class="redstart">*</span></label>
                                            <select class="select category_id"  name="category_id">
                                                <option value="">Select Category</option>
                                                @foreach($business_types as $type)
                                                    @foreach($type->category as $category)
                                                        @php $categories[$type->id][] = array('id' => $category->id, 'title' => $category->title); @endphp
                                                        <option value="{{ $category->id }}" {{ $banner->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('category_id') }}</span>
                                        </div>
                                    </div>
 
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Show on</label>
                                            <select class="select" id="show_on" name="show_on">
                                                <option value="0" @if ($banner->show_on == 0) selected @endif>Type</option>
                                                <option value="1" @if ($banner->show_on == 1) selected @endif>Category</option>
                                                <option value="2" @if ($banner->show_on == 2) selected @endif>Both Category And Type</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('show_on') }}</span>
                                        </div>
                                    </div>
                                  
                                    <!-- <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Show on Home Page</label>
                                            <select class="select" id="show_on_home_page" name="show_on_home_page">
                                                <option value="1" @if ($banner->show_on_home_page == 1) selected @endif>Yes</option>
                                                <option value="0" @if ($banner->show_on_home_page == 0) selected @endif>No</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('show_on_home_page') }}</span>
                                        </div>
                                    </div> -->
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thumbnail<span class="redstart"> * </span> </label>
                                            <input type="hidden" id="thumb_image" name="image" value="{{ $banner->image_original }}">
                                            <div class="dropzone thumb_image dropzone-file-area" style="min-height: 150px;">
                                                <div class="dz-default dz-message">
                                                    <h3 class="sbold">Drop Image here to upload</h3>
                                                    <span>You can also click to open file browser</span>
                                                </div>
                                                <img src="{{ $banner->image }}" height="300" width="300px">
                                            </div>
                                            <span class="redstart">{{ $errors->first('image') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea height="200px" id="description" name="description" data-parsley-trigger="keyup" data-parsley-required-message="Please enter description" class="form-control">{{ $banner->description }}</textarea>
                                            <span class="redstart">{{ $errors->first('description') }}</span>
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
        url: "{{ route('storage.upload', ['banner']) }}",
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

<script>
    const categoryList = @json($categories);
</script>
<script>
    $('.business_type').change(function() {
        const business_type   = $('.business_type').val();
        const category_id     = $('.category_id').val();
        const sub_category_id = $('.sub_category_id').val();
        
        let categoryHtml = '<option value=""> Select Category </option>';
        categoryList[business_type]?.forEach(element => {
            categoryHtml += `<option value="${element.id}"> ${element.title} </option>`;
        });

        
        try {
            $('.type')[0].selectize.destroy()
            $('.type').html(typeHtml);
            $('.type').selectize({
                plugins: ["remove_button"], 
                onChange: function(value, isOnInitialize) {
                    if(value !== '') {
                        updateSubCategoryDropDown()
                    }
                }
            });
            $('.type')[0].selectize.setValue(type);
        } catch (error) {}

        try {
            $('.category_id')[0].selectize.destroy()
            $('.category_id').html(categoryHtml);
            $('.category_id').selectize({
                plugins: ["remove_button"], 
                onChange: function(value, isOnInitialize) {
                    if(value !== '') {
                        updateSubCategoryDropDown()
                    }
                }
            });
            $('.category_id')[0].selectize.setValue(category_id);
        } catch (error) {}

    });

    
</script>

@endpush
@endsection