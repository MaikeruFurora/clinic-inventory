<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Inventory Management Record</title>
        <meta content="Admin Dashboard" name="description" />
        <meta content="ThemeDesign" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <link rel="shortcut icon" href="{{ asset('assets/images/logos.png') }}">

        <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" type="text/css">

    </head>


    <body class="fixed-left">

        <!-- Loader -->
        <div id="preloader"><div id="status"><div class="spinner"></div></div></div>

        <!-- Begin page -->
        <div class="accountbg">
            
            <div class="content-center">
                <div class="content-desc-center">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5 col-md-8">
                                @if (session()->has('msg'))
                                <div class="alert alert-danger text-center text-black" role="alert">
                                    {{ session('msg') }}
                                </div>
                                @endif
                                <div class="card">
                                    <div class="card-body">
                
                                        <h3 class="text-center mt-0 m-b-20">
                                            <a href="index.html" class="logo logo-admin"><img src="assets/images/berinalogo-landscape.png" height="100" alt="logo"></a>
                                        </h3>
                
                                        <h4 class="text-muted text-center font-20 m-t-15"><b>Sign In</b></h4>
                
                                        <div class="p-2">
                                            <form class="form-horizontal m-t-1" action="{{ route('auth.login') }}" method="POST">@csrf
                                                @method('POST')
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <input class="form-control" type="text"  value="{{ old('username') }}" name="username" placeholder="Username">
                                                        @error('username')
                                                            <small class="text-danger">{{ $errors->first('username') }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <input class="form-control" type="password"  name="password" placeholder="Password">
                                                        @error('password')
                                                            <small class="text-danger">{{ $errors->first('password') }}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                
                                                <div class="form-group row">
                                                    <div class="col-12">
                                                        <a href="#" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                                    </div>
                                                </div>
                
                                                <div class="form-group text-center row m-t-20">
                                                    <div class="col-12">
                                                        <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">Log In</button>
                                                    </div>
                                                </div>
                
                                                {{-- <div class="form-group m-t-10 mb-0 row">
                                                    <div class="col-sm-7 m-t-20">
                                                        <a href="pages-recoverpw.html" class="text-muted"><i class="mdi mdi-lock"></i> Forgot your password?</a>
                                                    </div>
                                                    <div class="col-sm-5 m-t-20">
                                                        <a href="pages-register.html" class="text-muted"><i class="mdi mdi-account-circle"></i> Create an account</a>
                                                    </div>
                                                </div> --}}
                                            </form>
                                        </div>
                
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end row -->
                    </div>
                </div>
            </div>
        </div>

        <!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/detect.js') }}"></script>
        <script src="{{ asset('assets/js/fastclick.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>

        <!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

    </body>
</html>