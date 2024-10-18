@extends('admin.master')
@section('child')

@php
$title = 'Frequently-asked questions';
$route = 'faq';
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
                        <li class="breadcrumb-item"><a href="{{ route('admin.'. $route .'.index') }}">{{ $title }}</a></li>
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
                                <i class="fa fa-newspaper-o" aria-hidden="true"></i> {{ $title }} Create
                            </h3>
                        </div>
                        <form role="form" action="{{ route('admin.'. $route .'.store') }}" method="post" enctype="multipart/form-data" id="form">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-9 ">
                                        <div class="form-group">
                                            <label for="exampleInputTitle">Question <span class="redstart">*</span></label>
                                            <input type="text" name="question" id="question" class="form-control" placeholder="Enter question"  data-parsley-trigger="keyup" data-parsley-required-message="Please enter question" value="{{ old('question') }}">
                                            <span class="redstart">{{ $errors->first('question') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="exampleSelectBorder">Status</label>
                                            <select class="select" id="status" name="status">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>Active</option>
                                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            <span class="redstart">{{ $errors->first('status') }}</span>
                                        </div>
                                    </div>
                                    <div class="col-md-12 ">
                                        <div class="form-group">
                                            <label for="answer">Answer</label>
                                            <textarea height="200px" id="answer" name="answer" data-parsley-trigger="keyup" data-parsley-required-message="Please enter answer" class="form-control">{{ old('answer') }}</textarea>
                                            <span class="redstart">{{ $errors->first('answer') }}</span>
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

@endpush
@endsection