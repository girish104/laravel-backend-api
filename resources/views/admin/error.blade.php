@extends('admin.master')
@section('child')
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
              <li class="breadcrumb-item active">  Error Page</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->



    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      
          <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3 titleClass">
                  <i class="fa fa-exclamation-triangle" aria-hidden="true"></i>

                  {{-- {{ session('status') }} --}}
                  Error Page
                </h3>
                
              </div><!-- /.card-header -->
              <div class="card-body">
               <div class="row">
                     <div class="col-lg-12 col-6 p-5">
                      <!-- small box -->
                        <div class="inner">


                          <h2 class="eeror1">{{ session('status') }}  {{ @$status }}</h2>
                          <p class="error_p">{{ session('Message') }}  {{ @$msg }}</p>


                          <a href="{{ route('admin.dash') }}" class="btn btn-danger error_button">Return to Dashboard <i class="nav-icon fa fa-home" aria-hidden="true"></i></a>
                        </div>
                       
                    </div>
                    <!-- ./col -->
                  </div>
           </div>

        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection
