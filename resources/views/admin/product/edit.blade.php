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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> Product Update
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart"> * </span> </label>
                                            <input type="text" name="title" value="{{ $product->title }}" id="title" class="form-control" placeholder="Enter product title" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter product title">
                                            <span class="redstart">{{ $errors->first('title') }}</span>
                                        </div>
                                    </div>
                  
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
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
                                                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                    @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('category_id') }}</span>
                                        </div>
                                    </div>
                                    @php $subCategories = []; @endphp
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Sub Category<span class="redstart">*</span></label>
                                            <select class="select sub_category_id"  name="sub_category_id">
                                                <option value="">Select Sub Category</option>
                                                @foreach($business_types->category ?? [] as $category)
                                                    @foreach($category->sub_category as $subCategory)
                                                        @php $subCategories[$business_types->id][$category->id][] = array('id' => $subCategory->id, 'title' => $subCategory->title); @endphp
                                                        <option value="{{ $subCategory->id }}" {{ $product->sub_category_id == $subCategory->id ? 'selected' : '' }}>{{ $subCategory->title }}</option>
                                                    @endforeach
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('sub_category_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 hiddenCategories subSubCategory_1">
                                        <div class="form-group">
                                            @php 
                                                $categoryList = $subSubCategoriesGroupedByType[1] ?? [];
                                            @endphp
                                            <label for="exampleSelectBorder">Sub Sub Category<span class="redstart">*</span></label>
                                            <select class="select sub_sub_category_1_id"  name="sub_sub_category_1_id">
                                                <option value="">Select Sub Sub Category </option>
                                                @foreach($categoryList as $category)
                                                    <option value="{{ $category->id }}" {{ @$product['sub_sub_category_1_id'] === $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('sub_sub_category_1_id') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Thumbnail<span class="redstart"> * </span> </label>
                                            <input type="hidden" id="thumb_image" name="image" value="{{ $product->image_original }}">
                                            <div class="dropzone thumb_image dropzone-file-area" style="min-height: 150px;">
                                                <div class="dz-default dz-message">
                                                    <h3 class="sbold">Drop Image here to upload</h3>
                                                    <span>You can also click to open file browser</span>
                                                </div>
                                                <img src="{{ $product->image }}" height="100" width="100px">
                                            </div>
                                            <span class="redstart">{{ $errors->first('image') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Images<span class="redstart"> * </span> </label>
                                            <div class="imageList">
                                            </div>
                                            <div class="dropzone images dropzone-file-area" style="min-height: 150px;">
                                                <div class="dz-default dz-message">
                                                    <h3 class="sbold">Drop Images here to upload</h3>
                                                    <span>You can also click to open file browser</span>
                                                </div>
                                                <div class="oldImages">
                                                    @foreach($product->images ?? []  as $img)
                                                    <img src="{{ $img->url }}" height="100" width="100px">
                                                    @endforeach
                                                </div>
                                            </div>
                                            <span class="redstart">{{ $errors->first('images') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Overview <span class="redstart"> * </span> </label>
                                            <textarea min-height="200px" id="summary" name="summary" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product overview" class="form-control summary">{!! $product->summary !!}</textarea>
                                            <span class="redstart">{{ $errors->first('summary') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Price <span class="redstart"> * </span></label>
                                            <input type="number" name="price" id="price" min="0" max="100000000" value="{{ $product->price }}" class="form-control" placeholder="Enter product price" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter product price">
                                            <span class="redstart">{{ $errors->first('price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Price Onwards </label>
                                            <input type="hidden" name="price_onwards" value="0">
                                            <input type="checkbox" name="price_onwards" id="price_onwards"  value="1" ?? {{ $product->price_onwards ? 'checked' : '' }} class="form-control" placeholder="Is  price onwards"  data-parsley-trigger="keyup">
                                            <span class="redstart">{{ $errors->first('price_onwards') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Original Price</label>
                                            <input type="number" name="old_price" id="old_price" min="0" max="100000000" value="{{ $product->old_price }}" class="form-control" placeholder="Enter product original price" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product original price">
                                            <span class="redstart">{{ $errors->first('old_price') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Stock</label>
                                            <input type="number" name="stock" id="stock" min="0" max="100000000" value="{{ $product->stock }}" class="form-control" placeholder="Enter product stock" required data-parsley-trigger="keyup" data-parsley-required-message="Please enter product stock">
                                            <span class="redstart">{{ $errors->first('stock') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Weight</label>
                                            <input type="text" name="weight" id="weight" class="form-control" value="{{ $product->weight }}" placeholder="Enter product weight" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product weight">
                                            <span class="redstart">{{ $errors->first('weight') }}</span>
                                        </div>
                                    </div>
      
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Dimensions</label>
                                            <input type="text" name="dimensions" id="dimensions" class="form-control" value="{{ $product->dimensions }}" placeholder="Enter product dimensions" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product dimensions">
                                            <span class="redstart">{{ $errors->first('dimensions') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-1 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">SKU</label>
                                            <input type="text" name="sku" id="sku" class="form-control" value="{{ $product->sku }}" placeholder="Enter product sku" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product sku">
                                            <span class="redstart">{{ $errors->first('sku') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-9 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Tags </label>
                                            <input type="text" name="tags" id="tags" class="form-control" placeholder="Enter product tags" value="{{ $product->tags }}" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product tags">
                                            <span class="redstart">{{ $errors->first('tags') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Minimum order Quantity</label>
                                            <input type="number" min="1" name="min_order_qty" id="min_order_qty" class="form-control" value="{{ $product->min_order_qty }}" placeholder="Enter product min order qty" data-parsley-trigger="keyup" data-parsley-required-message="Please enter product min_order_qty">
                                            <span class="redstart">{{ $errors->first('min_order_qty') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Description</label>
                                            <textarea min-height="200px" id="description" name="description" class="form-control description">{!! $product->description !!}</textarea>
                                            <span class="redstart">{{ $errors->first('description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Product Detail</label>
                                            <textarea min-height="200px" id="product_detail" name="product_detail" class="form-control product_detail">{!! $product->product_detail !!}</textarea>
                                            <span class="redstart">{{ $errors->first('product_detail') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Delivery Info</label>
                                            <textarea min-height="200px" id="delivery_info" name="delivery_info" class="form-control delivery_info"> {!! $product->delivery_info !!}</textarea>
                                            <span class="redstart">{{ $errors->first('delivery_info') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Cancellation Policy</label>
                                            <textarea min-height="200px" id="cancellation_policy" name="cancellation_policy" class="form-control cancellation_policy"> {!! $product->cancellation_policy !!}</textarea>
                                            <span class="redstart">{{ $errors->first('cancellation_policy') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleDescriptions">Terms and condition</label>
                                            <textarea min-height="200px" id="terms_and_conditions" name="terms_and_conditions" class="form-control terms_and_conditions"> {!! $product->terms_and_conditions !!}</textarea>
                                            <span class="redstart">{{ $errors->first('terms_and_conditions') }}</span>
                                        </div>
                                    </div>
                                    
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Add to Package</label>
                                            <select class="select package"  name="packages[]" multiple>
                                                <option value="">Select Package</option>
                                                    @foreach($packages ?? [] as $package)
                                                        <option value="{{ $package->id }}"   {{ in_array($package->id, $selectedPackages)  ? 'selected' : '' }}>{{ $package->title }}</option>
                                                    @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('package') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Festivals</label>
                                            <select class="select" id="festivals" name="festivals[]" multiple>
                                                @foreach($festivals as $festival)
                                                <option value="{{ $festival->id }}" {{ in_array($festival->id, $selectedFestivals) ? 'selected' : '' }}>{{ $festival->title }}</option>
                                                @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-2 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Gift Type</label>
                                            <select class="select"  name="gift_type_id">
                                                <option value="0">Not a gift</option>
                                                    @foreach($gifts ?? [] as $gift)
                                                        <option value="{{ $gift->id }}"   {{ $gift->id == $product->gift_type_id  ? 'selected' : '' }}>{{ $gift->title }}</option>
                                                    @endforeach
                                            </select>
                                            <span class="redstart">{{ $errors->first('gift') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Seo Url</label>
                                            <input type="text" name="slug" id="slug" value="{{ $product->slug }}" class="form-control" placeholder="Enter SEO url">
                                            <span class="redstart">{{ $errors->first('slug') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-5 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Title </label>
                                            <input type="text" name="meta_title" id="meta_title" value="{{ $product->meta_title }}" class="form-control" placeholder="Enter meta title">
                                            <span class="redstart">{{ $errors->first('meta_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-7 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta Keywords </label>
                                            <input type="text" name="meta_keywords" id="meta_keywords" value="{{ $product->meta_keywords }}" class="form-control" placeholder="Enter meta keywords">
                                            <span class="redstart">{{ $errors->first('meta_keywords') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Meta descriptions </label>
                                            <input type="text" name="meta_descriptions" id="meta_descriptions" value="{{ $product->meta_descriptions }}" class="form-control" placeholder="Enter meta description">
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
                                                @foreach($faqs as $faq)
                                                <tr>
                                                    <td>
                                                        <textarea name="faq_question[]" rows="2" class="form-control" placeholder="Enter FAQ question" >{{ $faq->question }}</textarea>
                                                    </td>
                                                    <td>
                                                        <textarea name="faq_answer[]" rows="2" placeholder="Enter FAQ answer"class="form-control"  >{{ $faq->answer }}</textarea>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-danger btn-sm remove_faq">X</button>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>

                                        <br>
                                        <button type="button" class="btn btn-sm btn-primary add_faq">Add Faq</button>

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
        // autoProcessQueue: true,
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
    
    ClassicEditor.create(document.querySelector('#terms_and_conditions')).then(editor => {
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
                    }
                }
            });
            $('.sub_category_id')[0].selectize.setValue(sub_category_id);
        } catch (error) {}

        updateSubSubCategory_1_DropDown()
    });

    $('.category_id').change(function() {
        updateSubCategoryDropDown()
        updateSubSubCategory_1_DropDown()
    });

    $('.type').change(function(){
        updateSubSubCategory_1_DropDown()
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

    // try {
        $('.sub_category_id')[0].selectize.destroy()
        $('.sub_category_id').html(subCategoryHtml);
        $('.sub_category_id').selectize({
            plugins: ["remove_button"],
            onChange: function(value, isOnInitialize) {
                if(value !== '') {
                    updateSubSubCategory_1_DropDown()
                }
            }
        });
        $('.sub_category_id')[0].selectize.setValue(oldValue);
    // } catch (error) {}
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

    let html = `<option value=""> Select Sub Sub 1 Category </option>`;
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
                }
            }
        });
    } catch (error) {}
}


</script>

<script>
    $('.sub_category_id, .category_id, .type').change(function(){
        updateSubSubCategory_1_DropDown()
    });

    $('.sub_sub_category_1_id').click(function(){
        updateSubSubCategory_1_DropDown()
    })
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