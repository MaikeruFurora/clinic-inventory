<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
        <title>@yield('title')</title>
        {{-- <link rel="shortcut icon" href="{{ asset('assets/images/logos.png') }}"> --}}
        <!-- General CSS Files -->
        <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/modules/toast/iziToast.css') }}">
        <!-- CSS Libraries -->
        
        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
        @csrf
        <input type="hidden" name="userID" value="{{ auth()->user()->id }}">
        @yield('moreCss')
    </head>
    <body>
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            @include('../layout/navbar')
            @include('../layout/sidebar')
            <!-- Start app main Content -->
            <div class="main-content">
                @yield('content')
            </div>
            {{-- @include('../layout.footer') --}}
        </div>
    </div>
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/bundles/lib.vendor.bundle.js') }}"></script>
    <script src="{{ asset('assets/modules/toast/iziToast.js') }}"></script>

    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <script src="{{ asset('js/global.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    
    @yield('moreJs')
    </body>

<!-- blank.html  Tue, 07 Jan 2020 03:35:42 GMT -->
</html>