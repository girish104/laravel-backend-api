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
                        <li class="breadcrumb-item"><a href="{{ route('admin.service.index') }}">Services</a></li>
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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> Service Create
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.service.store') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-7 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart"> * </span> </label>
                                            <input type="text" name="title" value="{{ old('title') }}" id="title" class="form-control" placeholder="Enter service title" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter service title">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                  
                                    <div class="col-md-1 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1">Active</option>
                                                <option value="0">Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Show on Home Page</label>
                                            <select class="select" id="show_on_home_page" name="show_on_home_page">
                                                <option value="1" @if (old('show_on_home_page')==1) selected @endif>Yes</option>
                                                <option value="0" @if (old('show_on_home_page')==0) selected @endif>No</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('show_on_home_page') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Col Width</label>
                                            <select class="select" id="col_width" name="col_width">
                                                @foreach(range(1, 12) as $width)
                                                <option value="{{ $width }}" @if (4==$width) selected @endif>{{ $width }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('col_width') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Position </label>
                                            <input type="number" name="position" value="{{ old('position') ? old('position') : 1 }}" class="form-control" min="1" max="10000">
                                            <span class="redstart">{{ $errors->first('position') }}</span>
                                        </div>
                                    </div>

                                    <input type="hidden" name="business_type" class="business_type"  value="{{ $business_types->id }}">
                                    @php $categories = []; @endphp
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Category<span class="redstart">*</span></label>
                                            <select class="select category_id"  name="category_id">
                                                <option value="">Select Category</option>
                                                    @foreach($business_types->category ?? [] as $category)
                                                        @php $categories[$business_types->id][] = array('id' => $category->id, 'title' => $category->title); @endphp
                                                        <option value="{{ $category->id }}" >{{ $category->title }}</option>
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
                                                @foreach($business_types->category ?? [] as $category)
                                                    @foreach($category->sub_category as $subCategory)
                                                        @php $subCategories[$business_types->id][$category->id][] = array('id' => $subCategory->id, 'title' => $subCategory->title); @endphp
                                                        <option value="{{ $subCategory->id }}" >{{ $subCategory->title }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('sub_category_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 hiddenCategories subSubCategory">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Sub Sub Category</label>
                                            <select class="select sub_sub_category_id"  name="sub_sub_category_id">
                                                <option value="">Select Sub Sub Category </option>
                                                @foreach($subSubCategories ?? [] as $businessTypesList)
                                                    @foreach($businessTypesList as $categoryTypeList)
                                                        @foreach($categoryTypeList as $subCatgoryTypeList)
                                                            @foreach($subCatgoryTypeList as $subSubCatgoryTypeList)
                                                                @php $subSubCatgoryTypeLists[$business_types->id][$subSubCatgoryTypeList->id][] = array('id' => $subSubCatgoryTypeList->id, 'title' => $subSubCatgoryTypeList->title); @endphp
                                                                <option value="{{ $subSubCatgoryTypeList->id }}" >{{ $subSubCatgoryTypeList->title }}</option>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('sub_sub_category_id') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Home Page Image<span class="redstart"> * </span> </label>
                                            <input type="hidden" id="icon_image" name="icon" value="">
                                            <div class="dropzone icon_image dropzone-file-area" style="min-height: 150px;">
                                                <div class="dz-default dz-message">
                                                    <h3 class="sbold">Drop Image here to upload</h3>
                                                    <span>You can also click to open file browser</span>
                                                </div>
                                            </div>
                                            <span class="redstart">{{ $errors->first('icon') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
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
                                    <div class="col-md-5">
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
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Overview <span class="redstart"> * </span> </label>
                                            <textarea min-height="200px" id="summary" name="summary" data-parsley-trigger="keyup" data-parsley-required-message="Please enter service overview" class="form-control summary">{{ old('summary') }}</textarea>
                                            <span class="redstart">{{ $errors->first('summary') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Starting Price <span class="redstart"> * </span></label>
                                            <input type="number" name="price" id="price" min="0" max="100000000" value="{{ old('price') }}" class="form-control" placeholder="Enter service price" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter service price">
                                            <span class="redstart">{{ $errors->first('price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Price Onwards </label>
                                            <input type="checkbox" name="price_onwards" id="price_onwards"  value="1" class="form-control" placeholder="Is  price onwards"  data-parsley-trigger="keyup">
                                            <span class="redstart">{{ $errors->first('price_onwards') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Original Price</label>
                                            <input type="number" name="old_price" id="old_price" min="0" max="100000000" value="{{ old('old_price') }}" class="form-control" placeholder="Enter service original price" data-parsley-trigger="keyup" data-parsley-required-message="Please enter service original price">
                                            <span class="redstart">{{ $errors->first('old_price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Tags </label>
                                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter service tags" value="{{ old('tags') }}" data-parsley-trigger="keyup" data-parsley-required-message="Please enter service tags">
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
                                            <label for="exampleDescriptions">Service Detail</label>
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
                                    
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Add to Package</label>
                                            <select class="select package"  name="packages[]" multiple>
                                                <option value="">Select Package</option>
                                                    @foreach($packages ?? [] as $package)
                                                        <option value="{{ $package->id }}">{{ $package->title }}</option>
                                                    @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('package') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Festivals</label>
                                            <select class="select" id="festivals" name="festivals[]" multiple>
                                                @foreach($festivals as $festival)
                                                <option value="{{ $festival->id }}" >{{ $festival->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
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
                                </div>
                                <hr>

                                <div class="row">
                                    <div class="col-md-12 ">
                                        <label for="exampleInputEmail1">Faqs</label>
                                        <table style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th width="30%">Question</th>
                                                    <th width="30%">Answer</th>
                                                    <th width="5%">Remove</th>
                                                </tr>
                                            </thead>
                                            <tbody class="faq_list">
                                            </tbody>
                                        </table>
                                        <br>
                                        <button type="button" class="btn btn-sm btn-primary add_faq">Add Faq</button>
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
        url: "{{ route('storage.upload', ['service']) }}",
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

    var icon_image = new Dropzone(".icon_image", {
        url: "{{ route('storage.upload', ['service']) }}",
        autoProcessQueue: true,
        uploadMultiple: false,
        maxFilesize: 5,
        acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
    });
    icon_image.on("sending", function(file, xhr, formData) {
        formData.append("_token", CSRF_TOKEN);
        // $('.oldImage').remove();
    });
    icon_image.on("error", function(file, response) {
        $(file.previewElement).addClass("dz-error").find('.dz-error-message').text('Please upload valid file');
    });
    icon_image.on("success", function(file, response) {
        if (response.status)
            $('#icon_image').val(response.url)
    });



    var images = new Dropzone(".images", {
        url: "{{ route('storage.upload', ['service']) }}",
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
        if (response.status){
            response.url.forEach(url => {
                $('.imageList').append(`<input type="hidden" name="images[]" value="${url}" >`)
            });
        }
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
                        updateSubSubCategoryDropDown()
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
                        updateSubSubCategoryDropDown()
                    }
                }
            });
            $('.sub_category_id')[0].selectize.setValue(sub_category_id);
        } catch (error) {}
        updateSubSubCategoryDropDown()
    });

    $('.category_id').change(function() {
        updateSubCategoryDropDown()
        updateSubSubCategoryDropDown()
    });

    $('.sub_category_id').change(function() {
        updateSubSubCategoryDropDown()
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
                    updateSubSubCategoryDropDown()
                }
            }
        });
        $('.sub_category_id')[0].selectize.setValue(oldValue);
    } catch (error) {}
}


function updateSubSubCategoryDropDown(){    
    const business_type = $('.business_type').val();
    const category_id   = $('.category_id').val();
    const sub_category_id = $('.sub_category_id').val();
    const sub_sub_category_id = $('.sub_sub_category_id').val();

    let categoryList =  subSubCategories[business_type] ?? [];
    categoryList     =  categoryList[category_id] ?? [];
    categoryList     =  categoryList[sub_category_id] ?? [];

    let html = `<option value=""> Select Sub Sub Category </option>`;
    categoryList.forEach(element => {
        html += `<option value="${element.id}"> ${element.title} </option>`;
    });
    console.log(html)
 
    try {
        $('.subSubCategory').show();
        $('.sub_sub_category_id')[0].selectize.destroy()
        $('.sub_sub_category_id').html(html);
        $('.sub_sub_category_id').selectize({
            plugins: ["remove_button"],
        });
        $('.sub_sub_category_id')[0].selectize.setValue(sub_sub_category_id);
    } catch (error) {}
}


updateSubSubCategoryDropDown()
</script>


<script>
    function getFaqtemplate(){
        return  `<tr>
                <td>
                    <textarea name="faq_question[]" rows="2" class="form-control" placeholder="Enter FAQ question" ></textarea>
                </td>
                <td>
                    <textarea name="faq_answer[]" rows="2" placeholder="Enter FAQ answer"class="form-control"  ></textarea>
                </td>
                <td>
                    <button type="button" class="btn btn-danger btn-sm remove_faq">X</button>
                </td>
            </tr>`
    }


    $( ".faq_list" ).delegate( ".remove_faq", "click", function() {
        $( this ).closest( "tr" ).remove();
    });

    $('.add_faq').click(function(){
        $('.faq_list').append(getFaqtemplate())
    })
</script>


@endpush
@endsection