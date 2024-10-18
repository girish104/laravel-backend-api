@extends('admin.master')
@section('child')

@php
$title = 'Sub Sub Category';
$route = 'sub-sub-category';
@endphp

<style>
    .hiddenCategories{
        display: none;
    }
</style>
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
                        <form role="form" action="{{ route('admin.' . $route . '.update', $sub_sub_category->id) }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart">*</span></label>
                                            <input type="text" name="title" id="title" value="{{ $sub_sub_category->title }}" class="form-control" placeholder="Enter title"  data-parsley-trigger="keyup" data-parsley-required-message="Please enter title">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Sub Sub Category Type</label>
                                            <select class="select type" id="type" name="type">
                                                <option value="" selected> Select Sub Sub Category Type </option>
                                                @foreach(range(1, 6) as $type)
                                                    <option value="{{ $type }}" {{ $sub_sub_category->type == $type ? 'selected' : '' }}>{{ $type }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div> -->
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" {{ $sub_sub_category->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $sub_sub_category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Business Type<span class="redstart">*</span></label>
                                            @php $subSubSubCategoryTypes = []; @endphp
                                            <select class="select business_type"  name="business_type">
                                                <option value="">Select Business Type</option>
                                                @foreach($business_types as $type)
                                                @php 
                                                    if($type->title == 'Product') $subSubSubCategoryTypes[$type->id][] = [1];
                                                    else if($type->title == 'Celebrity') $subSubSubCategoryTypes[$type->id][] = [];
                                                    else $subSubSubCategoryTypes[$type->id][] = range(1, 6);
                                                @endphp
                                                <option value="{{ $type->id }}" {{ $sub_sub_category->business_type == $type->id ? 'selected' : '' }}>{{ $type->title }}</option>
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
                                                        <option value="{{ $category->id }}" {{ $sub_sub_category->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('category_id') }}</span>
                                        </div>
                                    </div>
                                    @php $subCategories = []; @endphp
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Sub Category</label>
                                            <select class="select sub_category_id"  name="sub_category_id">
                                                <option value="">Select Sub Category</option>
                                                @foreach($business_types as $type)
                                                    @foreach($type->category as $category)
                                                        @foreach($category->sub_category as $subCategory)
                                                            @php $subCategories[$type->id][$category->id][] = array('id' => $subCategory->id, 'title' => $subCategory->title); @endphp
                                                            <option value="{{ $subCategory->id }}" {{ $sub_sub_category->sub_category_id == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->title }}</option>
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('sub_category_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <textarea height="200px" id="description" name="description" data-parsley-trigger="keyup" data-parsley-required-message="Please enter description" class="form-control">{{ $sub_sub_category->description }}</textarea>
                                            <span class="redstart">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
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
    const subCategoryList = @json($subCategories);
    const subSubCategories = @json($subSubCategories);
    const subSubSubCategoryTypes = @json($subSubSubCategoryTypes);
</script>
<script>
    $('.business_type').change(function() {
        const business_type   = $('.business_type').val();
        const category_id     = $('.category_id').val();
        const sub_category_id = $('.sub_category_id').val();
        
        let typeHtml = '<option value=""> Select Sub Sub Category Type </option>';
        subSubSubCategoryTypes[business_type]?.forEach(element => {
            element.forEach(function(type){
                typeHtml += `<option value="${type}"> ${type} </option>`;
            })
        });

        let categoryHtml = '<option value=""> Select Category </option>';
        categoryList[business_type]?.forEach(element => {
            categoryHtml += `<option value="${element.id}"> ${element.title} </option>`;
        });

        

        let subCategoryHtml = '<option value=""> Select Sub Category </option>';
        const selectedTypeCategories = subCategoryList[business_type] ?? [];
        for (var key in selectedTypeCategories) {
            if (Boolean(category_id)) {
                if (key != category_id) continue;
            }
            const selectedSubCategories = selectedTypeCategories[key] ?? [];
            for (var key in selectedSubCategories) {
                const element = selectedSubCategories[key] ?? {};
                subCategoryHtml += `<option value="${element.id}"> ${element.title} </option>`;
            }
        }

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

        try {
            $('.sub_category_id')[0].selectize.destroy()
            $('.sub_category_id').html(subCategoryHtml);
            $('.sub_category_id').selectize({
                plugins: ["remove_button"],
                onChange: function(value, isOnInitialize) {
                    if(value !== '') {
                    }
                }
            });
            $('.sub_category_id')[0].selectize.setValue(sub_category_id);
        } catch (error) {}

    });

    
</script>

<script>
function updateSubCategoryDropDown(){
    const business_type = $('.business_type').val();
    const category_id   = $('.category_id').val();
    const oldValue      = $('.sub_category_id').val();

    let subCategoryHtml = '<option value=""> Select Sub Category </option>';
    const selectedTypeCategories = subCategoryList[business_type] ?? [];
    const selectedSubCategories = selectedTypeCategories[category_id] ?? [];

    for (var key in selectedSubCategories) {
        const element = selectedSubCategories[key] ?? {};
        subCategoryHtml += `<option value="${element.id}"> ${element.title} </option>`;
    }

    try {
        $('.sub_category_id')[0].selectize.destroy()
        $('.sub_category_id').html(subCategoryHtml);
        $('.sub_category_id').selectize({
            plugins: ["remove_button"]
        });
        $('.sub_category_id')[0].selectize.setValue(oldValue);
    } catch (error) {}
}

</script>

@endpush
@endsection