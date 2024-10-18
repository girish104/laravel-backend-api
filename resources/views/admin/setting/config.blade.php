@extends('admin.master')
@section('child')
@push('style')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/basic.min.css">
@endpush

<style>
    hr {
        margin-bottom: 20px;
        margin-top: 20px;
        width: 85%;
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
                        <li class="breadcrumb-item active">Setting</li>
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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i>Setting
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.setting.update', @$setting->id ?? 1) }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title <span class="redstart">*</span></label>
                                            <input type="text" name="home_page_header_title" id="title" class="form-control" placeholder="Enter home-page header title" data-parsley-trigger="keyup" value="{{ @$setting->home_page_header_title }}">
                                            <span class="redstart">{{ $errors->first('home_page_header_title') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="row">
                                    <!-- banner title description -->
                                    <div class="col-md-4 ">
                                        <center>
                                            <h3 for="">Title</h3>
                                        </center>
                                    </div>
                                    <div class="col-md-8 ">
                                        <center>
                                            <h3 for="">Description</h3>
                                        </center>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Banner<span class="redstart">*</span></label>
                                            <input type="text" name="home_page_banner_title" id="title" class="form-control" placeholder="Enter Banner Title" data-parsley-trigger="keyup" value="{{ @$setting->home_page_banner_title }}">
                                            <span class="redstart">{{ $errors->first('home_page_banner_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Banner<span class="redstart">*</span></label>
                                            <input type="text" name="home_page_banner_description" id="title" class="form-control" placeholder="Enter Banner Description " data-parsley-trigger="keyup" value="{{ @$setting->home_page_banner_description }}">
                                            <span class="redstart">{{ $errors->first('home_page_banner_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Service Group<span class="redstart">*</span></label>
                                            <input type="text" name="home_page_event_group_title" id="title" class="form-control" placeholder="Service event title" data-parsley-trigger="keyup" value="{{ @$setting->home_page_event_group_title }}">
                                            <span class="redstart">{{ $errors->first('home_page_event_group_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Service Group<span class="redstart">*</span></label>
                                            <input type="text" name="home_page_event_group_description" id="title" class="form-control" placeholder="Service Group Description " data-parsley-trigger="keyup" value="{{ @$setting->home_page_event_group_description }}">
                                            <span class="redstart">{{ $errors->first('home_page_event_group_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Why Choose Us<span class="redstart">*</span></label>
                                            <input type="text" name="why_choose_us_title" id="title" class="form-control" placeholder="Enter Why choose us title" data-parsley-trigger="keyup" value="{{ @$setting->why_choose_us_title }}">
                                            <span class="redstart">{{ $errors->first('why_choose_us_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Why Choose Us<span class="redstart">*</span></label>
                                            <input type="text" name="why_choose_us_description" id="title" class="form-control" placeholder="Enter Why Choose Us Description " data-parsley-trigger="keyup" value="{{ @$setting->why_choose_us_description }}">
                                            <span class="redstart">{{ $errors->first('why_choose_us_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Popular Gift<span class="redstart">*</span></label>
                                            <input type="text" name="popular_gift_collection_title" id="title" class="form-control" placeholder="Enter Popular gift collection title" data-parsley-trigger="keyup" value="{{ @$setting->popular_gift_collection_title }}">
                                            <span class="redstart">{{ $errors->first('popular_gift_collection_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Popular Gift<span class="redstart">*</span></label>
                                            <input type="text" name="popular_gift_collection_description" id="title" class="form-control" placeholder="Enter Popular Gift Description " data-parsley-trigger="keyup" value="{{ @$setting->popular_gift_collection_description }}">
                                            <span class="redstart">{{ $errors->first('popular_gift_collection_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Popular Celebrity<span class="redstart">*</span></label>
                                            <input type="text" name="popular_celebrities_title" id="title" class="form-control" placeholder="Enter Popular Celebrity title" data-parsley-trigger="keyup" value="{{ @$setting->popular_celebrities_title }}">
                                            <span class="redstart">{{ $errors->first('popular_celebrities_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Popular Celebrity<span class="redstart">*</span></label>
                                            <input type="text" name="popular_celebrities_description" id="title" class="form-control" placeholder="Enter Popular Celebrity Description " data-parsley-trigger="keyup" value="{{ @$setting->popular_celebrities_description }}">
                                            <span class="redstart">{{ $errors->first('popular_celebrities_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Popular Packages<span class="redstart">*</span></label>
                                            <input type="text" name="popular_packages_title" id="title" class="form-control" placeholder="Enter Popular Packages title" data-parsley-trigger="keyup" value="{{ @$setting->popular_packages_title }}">
                                            <span class="redstart">{{ $errors->first('popular_packages_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Popular Packages<span class="redstart">*</span></label>
                                            <input type="text" name="popular_packages_description" id="title" class="form-control" placeholder="Enter Popular Packages Description " data-parsley-trigger="keyup" value="{{ @$setting->popular_packages_description }}">
                                            <span class="redstart">{{ $errors->first('popular_packages_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Testimonial<span class="redstart">*</span></label>
                                            <input type="text" name="testimonial_title" id="title" class="form-control" placeholder="Enter Testimonial title" data-parsley-trigger="keyup" value="{{ @$setting->testimonial_title }}">
                                            <span class="redstart">{{ $errors->first('testimonial_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Testimonial <span class="redstart">*</span></label>
                                            <input type="text" name="testimonial_description" id="title" class="form-control" placeholder="Enter Testimonial Description " data-parsley-trigger="keyup" value="{{ @$setting->testimonial_description }}">
                                            <span class="redstart">{{ $errors->first('testimonial_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Celebration Contact Form Title<span class="redstart">*</span></label>
                                            <input type="text" name="contact_celebration_form_title" id="title" class="form-control" placeholder="Enter Celebration Contact Form Title" data-parsley-trigger="keyup" value="{{ @$setting->contact_celebration_form_title }}">
                                            <span class="redstart">{{ $errors->first('contact_celebration_form_title') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <center>
                                            <h3 for="">Footer</h3>
                                        </center>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Title<span class="redstart">*</span></label>
                                            <input type="text" name="footer_title" id="title" class="form-control" placeholder="Enter Footer Title" data-parsley-trigger="keyup" value="{{ @$setting->footer_title }}">
                                            <span class="redstart">{{ $errors->first('footer_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Description<span class="redstart">*</span></label>
                                            <input type="text" name="footer_description" id="title" class="form-control" placeholder="Enter Footer Description" data-parsley-trigger="keyup" value="{{ @$setting->footer_description }}">
                                            <span class="redstart">{{ $errors->first('footer_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Contact Title<span class="redstart">*</span></label>
                                            <input type="text" name="footer_contact_title" id="title" class="form-control" placeholder="Enter Contact Title" data-parsley-trigger="keyup" value="{{ @$setting->footer_contact_title }}">
                                            <span class="redstart">{{ $errors->first('footer_contact_title') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Contact Description<span class="redstart">*</span></label>
                                            <input type="text" name="footer_contact_description" id="title" class="form-control" placeholder="Enter Contact Description" data-parsley-trigger="keyup" value="{{ @$setting->footer_contact_description }}">
                                            <span class="redstart">{{ $errors->first('footer_contact_description') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Copyright Text<span class="redstart">*</span></label>
                                            <input type="text" name="footer_copyright_title" id="title" class="form-control" placeholder="Enter Copyright Text" data-parsley-trigger="keyup" value="{{ @$setting->footer_copyright_title }}">
                                            <span class="redstart">{{ $errors->first('footer_copyright_title') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <center>
                                            <h3 for="">SEO</h3>
                                        </center>
                                    </div>
                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Meta Title<span class="redstart">*</span></label>
                                            <input type="text" name="home_page_meta_title" id="title" class="form-control" placeholder="Enter Meta title" data-parsley-trigger="keyup" value="{{ @$setting->home_page_meta_title }}">
                                            <span class="redstart">{{ $errors->first('home_page_meta_title') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-8">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Meta Keyword<span class="redstart">*</span></label>
                                            <input type="text" name="home_page_meta_keyword" id="title" class="form-control" placeholder="Enter Meta keywords" data-parsley-trigger="keyup" value="{{ @$setting->home_page_meta_keyword }}">
                                            <span class="redstart">{{ $errors->first('home_page_meta_keyword') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Meta Description<span class="redstart">*</span></label>
                                            <input type="text" name="home_page_meta_description" id="title" class="form-control" placeholder="Enter Meta description" data-parsley-trigger="keyup" value="{{ @$setting->home_page_meta_description }}">
                                            <span class="redstart">{{ $errors->first('home_page_meta_description') }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <center>
                                            <h3 for="">Contact Us</h3>
                                        </center>
                                    </div>



                                    <div class="col-md-4 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Contact Greeting title<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_greeting_title" id="contact_page_greeting_title" class="form-control" placeholder="Enter Contact Title" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_greeting_title }}">
                                            <span class="redstart">{{ $errors->first('contact_page_greeting_title') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-8 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Contact Greeting message<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_greeting_content" id="contact_page_greeting_content" class="form-control" placeholder="Enter Contact Title" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_greeting_content }}">
                                            <span class="redstart">{{ $errors->first('contact_page_greeting_content') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Email<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_email" id="title" class="form-control" placeholder="Enter contact email" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_email }}">
                                            <span class="redstart">{{ $errors->first('contact_page_email') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Address<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_address" id="contact_page_address" class="form-control" placeholder="Enter Address" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_address }}">
                                            <span class="redstart">{{ $errors->first('contact_page_address') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Contact Number<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_contact_number" id="contact_page_contact_number" class="form-control" placeholder="Enter Contact Number" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_contact_number }}">
                                            <span class="redstart">{{ $errors->first('contact_page_contact_number') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Whatsapp Contact title<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_whatsapp_contact_title" id="contact_page_whatsapp_contact_title" class="form-control" placeholder="Enter Whatsapp Contact Title" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_whatsapp_contact_title }}">
                                            <span class="redstart">{{ $errors->first('contact_page_whatsapp_contact_title') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-6 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Contact Whatsapp Contact Content<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_whatsapp_contact_content" id="contact_page_whatsapp_contact_content" class="form-control" placeholder="Enter Whatsapp Contact Content" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_whatsapp_contact_content }}">
                                            <span class="redstart">{{ $errors->first('contact_page_whatsapp_contact_content') }}</span>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Whatsapp Contact Number<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_whatsapp_contact_number" id="title" class="form-control" placeholder="Enter Whatsapp Contact Number" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_whatsapp_contact_number }}">
                                            <span class="redstart">{{ $errors->first('contact_page_whatsapp_contact_number') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Whatsapp Contact Default text<span class="redstart">*</span></label>
                                            <input type="text" name="contact_page_whatsapp_contact_text" id="contact_page_whatsapp_contact_text" class="form-control" placeholder="Enter Whatsapp contact Default text" data-parsley-trigger="keyup" value="{{ @$setting->contact_page_whatsapp_contact_text }}">
                                            <span class="redstart">{{ $errors->first('contact_page_whatsapp_contact_text') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
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
    // var thumb_image = new Dropzone(".thumb_image", {
    //     url: "{{ route('storage.upload', ['site']) }}",
    //     autoProcessQueue: true,
    //     uploadMultiple: false,
    //     maxFilesize: 5,
    //     acceptedFiles: ".jpeg,.jpg,.png,.gif,.svg",
    // });
    // thumb_image.on("sending", function(file, xhr, formData) {
    //     formData.append("_token", CSRF_TOKEN);
    //     // $('.oldImage').remove();
    // });
    // thumb_image.on("error", function(file, response) {
    //     $(file.previewElement).addClass("dz-error").find('.dz-error-message').text('Please upload valid file');
    // });
    // thumb_image.on("success", function(file, response) {
    //     if (response.status)
    //         $('#thumb_image').val(response.url)
    // });
</script>
@endpush
@endsection