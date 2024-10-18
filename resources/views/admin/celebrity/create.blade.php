@extends('admin.master')


@section('child')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css">
@endpush

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
                        <li class="breadcrumb-item"><a href="{{ route('admin.celebrity.index') }}">Celebrities</a></li>
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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> Celebrity Create
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.celebrity.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Name <span class="redstart"> * </span> </label>
                                            <input type="text" name="name" value="{{ old('name') }}" id="name" class="form-control" placeholder="Enter celebrity name" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter celebrity name">
                                            <span class="redstart">{{ $errors->first('name') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Popular</label>
                                            <select class="select" id="is_popular" name="is_popular">
                                                <option value="1">Yes</option>
                                                <option value="0">No</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('is_popular') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <input type="hidden" name="business_type" class="business_type"  value="{{ $business_types->id }}">
                                    @php $categories = []; @endphp
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Category<span class="redstart">*</span></label>
                                            <select class="select category_id"  name="category_id">
                                                <option value="">Select Category</option>
                                                    @foreach($business_types->category ?? [] as $category)
                                                        @php $categories[$business_types->id][] = array('id' => $category->id, 'title' => $category->title); @endphp
                                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                    @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('category_id') }}</span>
                                        </div>
                                    </div>
                                    @php $subCategories = []; @endphp
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Sub Category</label>
                                            <select class="select sub_category_id"  name="sub_category_id">
                                                <option value="">Select Sub Category</option>
                                                @foreach($business_types->category ?? [] as $category)
                                                    @foreach($category->sub_category as $subCategory)
                                                        @php $subCategories[$business_types->id][$category->id][] = array('id' => $subCategory->id, 'title' => $subCategory->title); @endphp
                                                        <option value="{{ $subCategory->id }}" {{ old('sub_category_id') == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->title }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('sub_category_id') }}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Overview <span class="redstart"> * </span> </label>
                                            <textarea min-height="200px" id="summary" name="summary" data-parsley-trigger="keyup" data-parsley-required-message="Please enter celebrity overview" class="form-control summary">{{ old('summary') }}</textarea>
                                            <span class="redstart">{{ $errors->first('summary') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Price <span class="redstart"> * </span></label>
                                            <input type="number" name="price" id="price" min="0" max="100000000" value="{{ old('price') }}" class="form-control" placeholder="Enter celebrity price" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter celebrity price">
                                            <span class="redstart">{{ $errors->first('price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Price Onwards </label>
                                            <input type="hidden" name="price_onwards" value="0">
                                            <input type="checkbox" name="price_onwards" id="price_onwards"  value="1" ??  class="form-control" placeholder="Is  price onwards"  data-parsley-trigger="keyup">
                                            <span class="redstart">{{ $errors->first('price_onwards') }}</span>
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Original Price</label>
                                            <input type="number" name="old_price" id="old_price" min="0" max="100000000" value="{{ old('old_price') }}" class="form-control" placeholder="Enter celebrity original price" data-parsley-trigger="keyup" data-parsley-required-message="Please enter celebrity original price">
                                            <span class="redstart">{{ $errors->first('old_price') }}</span>
                                        </div>
                                    </div> -->
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Tags </label>
                                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter celebrity tags" value="{{ old('tags') }}" data-parsley-trigger="keyup" data-parsley-required-message="Please enter celebrity tags">
                                            <span class="redstart">{{ $errors->first('tags') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Description</label>
                                            <textarea min-height="200px" id="description" name="description" class="form-control description">{{ old('description') }}</textarea>
                                            <span class="redstart">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Celebrity Detail</label>
                                            <textarea min-height="200px" id="celebrity_detail" name="celebrity_detail" class="form-control celebrity_detail">{{ old('celebrity_detail') }}</textarea>
                                            <span class="redstart">{{ $errors->first('celebrity_detail') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thumbnail<span class="redstart"> * </span> </label>
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
                                   
                                </div>

                                <hr>    
                                
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Seo Url</label>
                                            <input type="text" name="slug" id="slug" value="" class="form-control" placeholder="Enter SEO url">
                                            <span class="redstart">{{ $errors->first('slug') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Title </label>
                                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title') }}" class="form-control" placeholder="Enter meta title">
                                            <span class="redstart">{{ $errors->first('meta_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-7 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Keywords </label>
                                            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords') }}" class="form-control" placeholder="Enter meta keywords">
                                            <span class="redstart">{{ $errors->first('meta_keywords') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta descriptions </label>
                                            <input type="text" name="meta_descriptions" id="meta_descriptions" value="{{ old('meta_descriptions') }}" class="form-control" placeholder="Enter meta description">
                                            <span class="redstart">{{ $errors->first('meta_descriptions') }}</span>
                                        </div>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <button type="submit" class="btn btn-danger"><i class="fa fa-pencil">
                                            </i> Create</button>
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

<script src="https://cdn.ckeditor.com/ckeditor5/35.3.2/classic/ckeditor.js"></script>
<script>
    ClassicEditor.create(document.querySelector('#summary')).then(editor => {
        // editor.ui.view.editable.element.style.minHeight = '100px';
    }).catch(console.error);

    ClassicEditor.create(document.querySelector('#description')).then(editor => {
        // editor.ui.view.editable.element.style.minHeight = '100px';
    }).catch(console.error);

    ClassicEditor.create(document.querySelector('#celebrity_detail')).then(editor => {
        // editor.ui.view.editable.element.style.minHeight = '100px';
    }).catch(console.error);
</script>






<script>
    const categoryList = @json($categories);
    const subCategoryList = @json($subCategories);
    const subSubCategories = @json($subSubCategories);
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

    $('.category_id').change(function() {
        updateSubCategoryDropDown()
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
            plugins: ["remove_button"],
            onChange: function(value, isOnInitialize) {
                if(value !== '') {
                }
            }
        });
        $('.sub_category_id')[0].selectize.setValue(oldValue);
    } catch (error) {}
}

</script>

<!-- .///// new  code / -->
@endpush
@endsection