@extends('admin.master')
@section('child')


@php
$title = 'Sub Category';
$route = 'sub-category';
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
                        <form role="form" action="{{ route('admin.' . $route . '.update', $sub_category->id) }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart">*</span></label>
                                            <input type="text" name="title" id="title" class="form-control" placeholder="Enter product title" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product title" value="{{ $sub_category->title }}">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" @if ($sub_category->status == 1) selected @endif>Active</option>
                                                <option value="0" @if ($sub_category->status == 0) selected @endif>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Business Type<span class="redstart">*</span></label>
                                            <select class="select business_type" name="business_type">
                                                <option value="">Select Business Type</option>
                                                @foreach($business_types as $type)
                                                    <option value="{{ $type->id }}" {{ $sub_category->business_type === $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('business_type') }}</span>
                                        </div>
                                    </div>
                                    @php $categories = []; @endphp
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Category<span class="redstart">*</span></label>
                                            <select class="select category_id" name="category_id">
                                                <option value="">Select Category</option>
                                                @foreach($business_types as $type)
                                                    @foreach($type->category as $category)
                                                        @php $categories[$type->id][] = array('id' => $category->id, 'title' => $category->title); @endphp
                                                        <option value="{{ $category->id }}" {{ $sub_category->category_id === $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('category_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea height="200px" id="description" name="description" data-parsley-trigger="keyup" data-parsley-required-message="Please enter description" class="form-control">{{ $sub_category->description }}</textarea>
                                            <span class="redstart">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-12">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Festivals</label>
                                            <select class="select" id="festivals" name="festivals[]" multiple>
                                                @foreach($festivals as $festival)
                                                <option value="{{ $festival->id }}" {{ in_array($festival->id, $selectedFestivals) ? 'selected' : '' }}>{{ $festival->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div> -->
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
<script>
    const categoryList = @json($categories);
</script>
<script>
    $('.business_type').change(function() {
        let html = '<option value=""> Select Category </option>';
        categoryList[$(this).val()]?.forEach(element => {
            html += `<option value="${element.id}"> ${element.title} </option>`;
        });

        try {
            $('.category_id')[0].selectize.destroy()
            $('.category_id').html(html);
            $('.category_id').selectize({
                plugins: ["remove_button"]
            });
        } catch (error) {}
    });
</script>
@endpush
@endsection