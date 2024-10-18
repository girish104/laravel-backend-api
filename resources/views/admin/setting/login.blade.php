<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('AdminAssets/assets/css/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script type="text/javascript">
    var baseURL = "{{ url('/') }}";
    </script>
</head>

<body>
    <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper">
            <div class="content-wrapper d-flex align-items-center auth">
                <div class="row flex-grow">
                    <div class="col-lg-10 mx-auto">
                        <div class="main_login">
                            <div class="main_login_left">
                                <div class="brand-logo">
                                    <img src="{{  asset('assets/images/logo.png') }}">
                                </div>
                                
                            </div>
                            <div class="main_login_right">
                                <div class="main_login_right_head">Login</div>




                                <p class="login-box-msg">Sign in to start your session</p>
                                 
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                @if (session('status'))
                                    <div class="alert alert-{{ session('status') }}">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                
                                        <i class="fa fa-info"></i> {{ session('msg') }}
                                    </div>
                                @endif
                
                
                                <form action="{{ route('admin.login') }}" method="post">
                                    @csrf
                                    <div class="form-group has-feedback">
                                        <input type="email" class="form-control" placeholder="Email" name="email"
                                            value="{{ old('email') }}" required>
                                        <span style="color: red;">{{ $errors->first('email') }}</span>
                
                
                                    </div>
                                    <div class="form-group has-feedback">
                                        <input type="password" class="form-control" placeholder="Password" name="password" required>
                                        <span style="color: red;">{{ $errors->first('password') }}</span>
                
                                    </div>
                                    <div class="row">
                
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-danger btn-block btn-flat">Sign In</button>
                                        </div>
                                        <!-- /.col -->
                                    </div>
                                </form>
                            </div>
                        </div>
                       
                    </div>
                </div>
            </div>
            <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>

</body>


</html>