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
                        <li class="breadcrumb-item"><a href="{{ route('admin.product.index') }}">Products</a></li>
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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> Product Create
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.product.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart"> * </span> </label>
                                            <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control" placeholder="Enter product title" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter product title">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                  
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Overview <span class="redstart"> * </span> </label>
                                            <textarea min-height="200px" id="summary" name="summary" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product overview" class="form-control summary">{{ old('summary') }}</textarea>
                                            <span class="redstart">{{ $errors->first('summary') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Price <span class="redstart"> * </span></label>
                                            <input type="number" name="price" id="price" min="0" max="100000000" value="{{ old('price') }}" class="form-control" placeholder="Enter product price" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter product price">
                                            <span class="redstart">{{ $errors->first('price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Original Price</label>
                                            <input type="number" name="old_price" id="old_price" min="0" max="100000000" value="{{ old('old_price') }}" class="form-control" placeholder="Enter product original price" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product original price">
                                            <span class="redstart">{{ $errors->first('old_price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Stock</label>
                                            <input type="number" name="stock" id="stock" min="0" max="100000000" value="{{ old('stock') }}" class="form-control" placeholder="Enter product stock" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter product stock">
                                            <span class="redstart">{{ $errors->first('stock') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Weight</label>
                                            <input type="text" name="weight" id="weight" class="form-control" value="{{ old('weight') }}" placeholder="Enter product weight" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product weight">
                                            <span class="redstart">{{ $errors->first('weight') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Dimensions</label>
                                            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ old('dimensions') }}" placeholder="Enter product dimensions" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product dimensions">
                                            <span class="redstart">{{ $errors->first('dimensions') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}" placeholder="Enter product sku" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product sku">
                                            <span class="redstart">{{ $errors->first('sku') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Tags </label>
                                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter product tags" value="{{ old('tags') }}" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product tags">
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
                                            <label for="exampleDescriptions">Product Detail</label>
                                            <textarea min-height="200px" id="product_detail" name="product_detail" class="form-control product_detail">{{ old('product_detail') }}</textarea>
                                            <span class="redstart">{{ $errors->first('product_detail') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Delivery Info</label>
                                            <textarea min-height="200px" id="delivery_info" name="delivery_info" class="form-control delivery_info"> {{ old('delivery_info') }}</textarea>
                                            <span class="redstart">{{ $errors->first('delivery_info') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Cancellation Policy</label>
                                            <textarea min-height="200px" id="cancellation_policy" name="cancellation_policy" class="form-control cancellation_policy"> {{ old('cancellation_policy') }}</textarea>
                                            <span class="redstart">{{ $errors->first('cancellation_policy') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
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
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Images<span class="redstart"> * </span> </label>
                                            <div class="imageList"></div>
                                            <div class="dropzone images dropzone-file-area" style="min-height: 150px;">
                                                <div class="dz-default dz-message">
                                                    <h3 class="sbold">Drop Images here to upload</h3>
                                                    <span>You can also click to open file browser</span>
                                                </div>
                                            </div>
                                            <span class="redstart">{{ $errors->first('images') }}</span>
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
                                            <label for="exampleSelectBorder">Sub Category<span class="redstart">*</span></label>
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
                                    @foreach(range(1, 6) as $subCategoryType)
                                    <div class="col-md-4 hiddenCategories subSubCategory_{{ $subCategoryType }}">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Sub Sub Category {{ $subCategoryType }}<span class="redstart">*</span></label>
                                            <select class="select sub_sub_category_{{ $subCategoryType }}_id"  name="sub_sub_category_{{ $subCategoryType }}_id"></select>
                                            <span class="redstart">{{ $errors->first('sub_sub_category_' . $subCategoryType . '_id') }}</span>
                                        </div>
                                    </div>
                                    @endforeach
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
        url: "{{ route('storage.upload', ['product']) }}",
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


    var images = new Dropzone(".images", {
        url: "{{ route('storage.upload', ['product']) }}",
        autoProcessQueue: true,
        uploadMultiple: true,
        maxFilesize: 5,
        maxFiles: 20,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
    });
    images.on("sending", function(file, xhr, formData) {
        formData.append("_token", CSRF_TOKEN);
        formData.append("multiple", true);
    });
    images.on("error", function(file, response) {
        $(file.previewElement).addClass("dz-error").find('.dz-error-message').text('Please upload valid file');
    });
    images.on("success", function(file, response) {
        if (response.status)
            $('.imageList').append(`<input type="hidden" name="images[]" value="${response.url}" >`)
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

    ClassicEditor.create(document.querySelector('#product_detail')).then(editor => {
        // editor.ui.view.editable.element.style.minHeight = '100px';
    }).catch(console.error);

    ClassicEditor.create(document.querySelector('#delivery_info')).then(editor => {
        // editor.ui.view.editable.element.style.minHeight = '100px';
    }).catch(console.error);

    ClassicEditor.create(document.querySelector('#cancellation_policy')).then(editor => {
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
                        updateSubSubCategory_1_DropDown()
                        updateSubSubCategory_2_DropDown()
                        updateSubSubCategory_3_DropDown();
                        updateSubSubCategory_4_DropDown()
                        updateSubSubCategory_5_DropDown()
                        updateSubSubCategory_6_DropDown()
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
                        updateSubSubCategory_1_DropDown()
                        updateSubSubCategory_2_DropDown()
                        updateSubSubCategory_3_DropDown();
                        updateSubSubCategory_4_DropDown()
                        updateSubSubCategory_5_DropDown()
                        updateSubSubCategory_6_DropDown()
                    }
                }
            });
            $('.sub_category_id')[0].selectize.setValue(sub_category_id);
        } catch (error) {}

        updateSubSubCategory_1_DropDown()
        updateSubSubCategory_2_DropDown()
        updateSubSubCategory_3_DropDown();
        updateSubSubCategory_4_DropDown()
        updateSubSubCategory_5_DropDown()
        updateSubSubCategory_6_DropDown()
    });

    $('.category_id').change(function() {
        updateSubCategoryDropDown()
        updateSubSubCategory_1_DropDown()
        updateSubSubCategory_2_DropDown()
        updateSubSubCategory_3_DropDown();
        updateSubSubCategory_4_DropDown()
        updateSubSubCategory_5_DropDown()
        updateSubSubCategory_6_DropDown()
    });

    $('.type').change(function(){
        updateSubSubCategory_1_DropDown()
        updateSubSubCategory_2_DropDown()
        updateSubSubCategory_3_DropDown();
        updateSubSubCategory_4_DropDown()
        updateSubSubCategory_5_DropDown()
        updateSubSubCategory_6_DropDown()
    })
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
                    updateSubSubCategory_1_DropDown()
                    updateSubSubCategory_2_DropDown()
                    updateSubSubCategory_3_DropDown();
                    updateSubSubCategory_4_DropDown()
                    updateSubSubCategory_5_DropDown()
                    updateSubSubCategory_6_DropDown()
                }
            }
        });
        $('.sub_category_id')[0].selectize.setValue(oldValue);
    } catch (error) {}
}

</script>

<!-- .///// new  code / -->

<script>
// function loadSubCategories(){
//     updateSubSubCategory_1_DropDown()
//     updateSubSubCategory_2_DropDown()
//     updateSubSubCategory_3_DropDown();
//     updateSubSubCategory_4_DropDown()
// }

function updateSubSubCategory_1_DropDown(){
    const type          = 1;
    const selectedType = Number($('.type').val());
    if (type >= selectedType) {
        $('.subSubCategory_1').hide();
        return; 
    }
    
    const business_type = $('.business_type').val();
    const category_id   = $('.category_id').val();
    const sub_category_id = $('.sub_category_id').val();

    let categoryList =  subSubCategories[business_type] ?? [];
    categoryList     =  categoryList[category_id] ?? [];
    categoryList     =  categoryList[sub_category_id] ?? [];
    categoryList     =  categoryList[type] ?? [];

    let html = `<option value=""> Select Sub 1 Category </option>`;
    categoryList.forEach(element => {
        html += `<option value="${element.id}"> ${element.title} </option>`;
    });
 
    try {
        $('.subSubCategory_1').show();
        $('.sub_sub_category_1_id')[0].selectize.destroy()
        $('.sub_sub_category_1_id').html(html);
        $('.sub_sub_category_1_id').selectize({
            plugins: ["remove_button"],
            onChange: function(value, isOnInitialize) {
                if(value !== '') {
                    updateSubSubCategory_2_DropDown()
                    updateSubSubCategory_3_DropDown();
                    updateSubSubCategory_4_DropDown()
                    updateSubSubCategory_5_DropDown()
                    updateSubSubCategory_6_DropDown()
                }
            }
        });
    } catch (error) {}
}

function updateSubSubCategory_2_DropDown(){
    const type          = 2;
    const selectedType = Number($('.type').val());
    if (type >= selectedType) {
        $('.subSubCategory_2').hide();
        return; 
    }

    const business_type = $('.business_type').val();
    const category_id   = $('.category_id').val();
    const sub_category_id = $('.sub_category_id').val();
    const sub_sub_category_1_id = $('.sub_sub_category_1_id').val();

    let categoryList =  subSubCategories[business_type] ?? [];
    categoryList     =  categoryList[category_id] ?? [];
    categoryList     =  categoryList[sub_category_id] ?? [];
    categoryList     =  categoryList[type] ?? [];

    let html = `<option value=""> Select Sub 2 Category </option>`;
    categoryList.forEach(element => {
        if (sub_sub_category_1_id == element.sub_sub_category_1_id)
            html += `<option value="${element.id}"> ${element.title} </option>`;
    });
 
    try {
        $('.subSubCategory_2').show();
        $('.sub_sub_category_2_id')[0].selectize.destroy()
        $('.sub_sub_category_2_id').html(html);
        $('.sub_sub_category_2_id').selectize({
            plugins: ["remove_button"],
            onChange: function(value, isOnInitialize) {
                if(value !== '') {
                    updateSubSubCategory_3_DropDown();
                    updateSubSubCategory_4_DropDown()
                    updateSubSubCategory_5_DropDown()
                    updateSubSubCategory_6_DropDown()
                }
            }
        });
    } catch (error) {}
}

function updateSubSubCategory_3_DropDown(){
    const type          = 3;
    const selectedType = Number($('.type').val());
    if (type >= selectedType) {
        $('.subSubCategory_3').hide();
        return; 
    }

    const business_type = $('.business_type').val();
    const category_id   = $('.category_id').val();
    const sub_category_id = $('.sub_category_id').val();
    const sub_sub_category_1_id = $('.sub_sub_category_1_id').val();
    const sub_sub_category_2_id = $('.sub_sub_category_2_id').val();

    let categoryList =  subSubCategories[business_type] ?? [];
    categoryList     =  categoryList[category_id] ?? [];
    categoryList     =  categoryList[sub_category_id] ?? [];
    categoryList     =  categoryList[type] ?? [];

    let html = `<option value=""> Select Sub 3 Category </option>`;
    categoryList.forEach(element => {
        if (sub_sub_category_1_id == element.sub_sub_category_1_id)
            if (sub_sub_category_2_id == element.sub_sub_category_2_id)
                html += `<option value="${element.id}"> ${element.title} </option>`;
    });
 
    try {
        $('.subSubCategory_3').show();
        $('.sub_sub_category_3_id')[0].selectize.destroy()
        $('.sub_sub_category_3_id').html(html);
        $('.sub_sub_category_3_id').selectize({
            plugins: ["remove_button"],
            onChange: function(value, isOnInitialize) {
                if(value !== '') {
                    updateSubSubCategory_4_DropDown()
                    updateSubSubCategory_5_DropDown()
                    updateSubSubCategory_6_DropDown()
                }
            }
        });
    } catch (error) {}
}



function updateSubSubCategory_4_DropDown(){
    const type          = 4;
    const selectedType = Number($('.type').val());
    if (type >= selectedType) {
        $('.subSubCategory_4').hide();
        return; 
    }

    const business_type = $('.business_type').val();
    const category_id   = $('.category_id').val();
    const sub_category_id = $('.sub_category_id').val();
    const sub_sub_category_1_id = $('.sub_sub_category_1_id').val();
    const sub_sub_category_2_id = $('.sub_sub_category_2_id').val();
    const sub_sub_category_3_id = $('.sub_sub_category_3_id').val();

    let categoryList =  subSubCategories[business_type] ?? [];
    categoryList     =  categoryList[category_id] ?? [];
    categoryList     =  categoryList[sub_category_id] ?? [];
    categoryList     =  categoryList[type] ?? [];

    let html = `<option value=""> Select Sub 4 Category </option>`;
    categoryList.forEach(element => {
        if (sub_sub_category_1_id == element.sub_sub_category_1_id)
            if (sub_sub_category_2_id == element.sub_sub_category_2_id)
                if (sub_sub_category_3_id == element.sub_sub_category_3_id)
                    html += `<option value="${element.id}"> ${element.title} </option>`;
    });
 
    try {
        $('.subSubCategory_4').show();
        $('.sub_sub_category_4_id')[0].selectize.destroy()
        $('.sub_sub_category_4_id').html(html);
        $('.sub_sub_category_4_id').selectize({
            plugins: ["remove_button"],
            onChange: function(value, isOnInitialize) {
                if(value !== '') {
                    updateSubSubCategory_5_DropDown()
                    updateSubSubCategory_6_DropDown()
                }
            }
        });
    } catch (error) {}
}


function updateSubSubCategory_5_DropDown(){
    const type          = 5;
    const selectedType = Number($('.type').val());
    if (type >= selectedType) {
        $('.subSubCategory_5').hide();
        return; 
    }

    const business_type = $('.business_type').val();
    const category_id   = $('.category_id').val();
    const sub_category_id = $('.sub_category_id').val();
    const sub_sub_category_1_id = $('.sub_sub_category_1_id').val();
    const sub_sub_category_2_id = $('.sub_sub_category_2_id').val();
    const sub_sub_category_3_id = $('.sub_sub_category_3_id').val();
    const sub_sub_category_4_id = $('.sub_sub_category_4_id').val();

    let categoryList =  subSubCategories[business_type] ?? [];
    categoryList     =  categoryList[category_id] ?? [];
    categoryList     =  categoryList[sub_category_id] ?? [];
    categoryList     =  categoryList[type] ?? [];

    let html = `<option value=""> Select Sub 5 Category </option>`;
    categoryList.forEach(element => {
        if (sub_sub_category_1_id == element.sub_sub_category_1_id)
            if (sub_sub_category_2_id == element.sub_sub_category_2_id)
                if (sub_sub_category_3_id == element.sub_sub_category_3_id)
                    if (sub_sub_category_4_id == element.sub_sub_category_4_id)
                        html += `<option value="${element.id}"> ${element.title} </option>`;
    });
 
    try {
        $('.subSubCategory_5').show();
        $('.sub_sub_category_5_id')[0].selectize.destroy()
        $('.sub_sub_category_5_id').html(html);
        $('.sub_sub_category_5_id').selectize({
            plugins: ["remove_button"],
            onChange: function(value, isOnInitialize) {
                if(value !== '') {
                    updateSubSubCategory_6_DropDown()
                }
            }
        });
    } catch (error) {}
}


function updateSubSubCategory_6_DropDown(){
    const type          = 6;
    const selectedType = Number($('.type').val());
    if (type >= selectedType) {
        $('.subSubCategory_6').hide();
        return; 
    }

    const business_type = $('.business_type').val();
    const category_id   = $('.category_id').val();
    const sub_category_id = $('.sub_category_id').val();
    const sub_sub_category_1_id = $('.sub_sub_category_1_id').val();
    const sub_sub_category_2_id = $('.sub_sub_category_2_id').val();
    const sub_sub_category_3_id = $('.sub_sub_category_3_id').val();
    const sub_sub_category_4_id = $('.sub_sub_category_4_id').val();
    const sub_sub_category_5_id = $('.sub_sub_category_5_id').val();

    let categoryList =  subSubCategories[business_type] ?? [];
    categoryList     =  categoryList[category_id] ?? [];
    categoryList     =  categoryList[sub_category_id] ?? [];
    categoryList     =  categoryList[type] ?? [];

    let html = `<option value=""> Select Sub 6 Category </option>`;
    categoryList.forEach(element => {
        if (sub_sub_category_1_id == element.sub_sub_category_1_id)
            if (sub_sub_category_2_id == element.sub_sub_category_2_id)
                if (sub_sub_category_3_id == element.sub_sub_category_3_id)
                    if (sub_sub_category_4_id == element.sub_sub_category_4_id)
                        if (sub_sub_category_5_id == element.sub_sub_category_5_id)
                            html += `<option value="${element.id}"> ${element.title} </option>`;
    });
 
    try {
        $('.subSubCategory_6').show();
        $('.sub_sub_category_6_id')[0].selectize.destroy()
        $('.sub_sub_category_6_id').html(html);
        $('.sub_sub_category_6_id').selectize({
            plugins: ["remove_button"],
            onChange: function(value, isOnInitialize) {
               
            }
        });
    } catch (error) {}
}
</script>
@endpush
@endsection