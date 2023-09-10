<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <noscript>
        {{-- Your browser does not support JavaScript! --}}
        <img id="noscript" src="https://cms-assets.tutsplus.com/uploads/users/30/posts/25498/preview_image/preview-tag-noscript.png" alt="Your browser does not support JavaScript!">
        <style>
            #noscript{
                width:100%;
                height:100vh;
            }

            div { display:none; }
        </style>
    </noscript>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{fileExist(['url'=>@$site_setting->favicon,'type'=>'favicon'])}}" type="image/x-icon">
    <link rel="icon" href="{{fileExist(['url'=>@$site_setting->favicon,'type'=>'favicon'])}}" type="image/x-icon">
    <title>{{(@$site_setting->title_suffix)?(@$site_setting->title_suffix):'Project Name'}} | {{@$title??'Dashboard'}}</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="{{asset('plugins')}}/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{asset('plugins')}}/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="{{asset('plugins')}}/select2/css/select2.min.css">
    <link rel="stylesheet" href="{{asset('plugins')}}/icheck-bootstrap/icheck-bootstrap.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{asset('admin')}}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{asset('common')}}/css/common.css">
    <script src="{{asset('plugins')}}/jquery/jquery.min.js"></script>
</head>
<body class="sidebar-mini layout-navbar-fixed layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">
    <div class="wrapper">
        @include('member.layouts.status-message')
        @include('member.layouts.navbar')
        @include('member.layouts.sidebar')
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container-fluid">
                    {{-- <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Dashboard</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">Dashboard v1</li>
                            </ol>
                        </div>
                    </div> --}}
                </div>
            </div>
            <section class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @include('member.layouts.footer')
        @include('member.layouts.preloader')
    </div>
    <script src="{{asset('plugins')}}/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{asset('plugins')}}/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('plugins')}}/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{asset('plugins')}}/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{asset('plugins')}}/jquery-validation/additional-methods.min.js"></script>
    <script src="{{asset('plugins')}}/select2/js/select2.full.min.js"></script>
    <script src="{{asset('admin')}}/dist/js/adminlte.js"></script>
    <script src="{{asset('common')}}/js/common.js"></script>

</body>
</html>
