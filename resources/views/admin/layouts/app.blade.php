<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <noscript>
        {{-- Your browser does not support JavaScript! --}}
        <img id="noscript" src="https://cms-assets.tutsplus.com/uploads/users/30/posts/25498/preview_image/preview-tag-noscript.png" alt="Your browser does not support JavaScript!">
        <style>
            #noscript {
                width: 100%;
                height: 100vh;
            }

            div {
                display: none;
            }
        </style>
    </noscript>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ fileExist(['url' => @$site_setting->favicon, 'type' => 'favicon']) }}" type="image/x-icon">
    <link rel="icon" href="{{ fileExist(['url' => @$site_setting->favicon, 'type' => 'favicon']) }}" type="image/x-icon">
    <title>{{ @$site_setting->title_suffix ? @$site_setting->title_suffix : 'Project Name' }} | {{ @$title ?? 'Dashboard' }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,400;0,500;0,700;0,900;1,400;1,500;1,700;1,900&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('plugins') }}/fontawesome-free/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('plugins') }}/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
    <link rel="stylesheet" href="{{ asset('plugins') }}/select2/css/select2.min.css">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('admin') }}/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="{{ asset('common') }}/css/common.css">

    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="{{ asset('plugins') }}/jquery/jquery.min.js"></script>
    <script src="{{ asset('plugins/amcharts/index.js') }}"></script>
    <script src="{{ asset('plugins/amcharts/xy.js') }}"></script>
    <script src="{{ asset('plugins/amcharts/animated.js') }}"></script>
    <script src="{{ asset('plugins/amcharts/exporting.js') }}"></script>
    <style>
        body {
            font-family: "Roboto", sans-serif;
        }

        ::-webkit-scrollbar {
            width: 5px;
        }

        /* Track */
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }

        /* Handle */
        ::-webkit-scrollbar-thumb {
            /* background: #888; */
            background: linear-gradient(180deg, #5b86e5b5 0%, rgb(62, 151, 255) 100%);

        }

        /* Handle on hover */
        ::-webkit-scrollbar-thumb:hover {
            background: #5b86e5b5;
        }

        .content-wrapper {
            background: linear-gradient(to left, #5b86e51f, #36d1dc0d);
        }

        .navbar-white {
            background: linear-gradient(to right, #923993, #36d1dc26);
            backdrop-filter: blur(6.6px);
            -webkit-backdrop-filter: blur(6.6px);
        }

        table {
            width: 100%;
        }

        .table thead {
            background: linear-gradient(to right, #923993, #24757b) !important;
        }

        .table thead th {
            vertical-align: middle !important;
            text-align: center;
            color: #fff;
        }

        .table td,
        .table th {
            padding: .3rem;
            vertical-align: middle;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header .card-title {
            font-weight: 600;
            color: #2a527b;
            text-transform: uppercase;
        }

        .card-header::after {
            content: none;
        }

        .select2-container {
            display: block;
            width: auto !important;
        }

        .text-gray {
            color: #6c757d;
        }
        .text-navy {
            color: #2a527b;
        }
        .main-footer.text-sm, .text-sm .main-footer {
            padding: 0.55rem;
        }
        .main-footer {
            background-color: #fff;
            border-top: none;
            color: #2a527b;
            font-size: 12px;
        }
        .am5exporting-menu {
            font-size: 12px;
        }

        .am5exporting-menu.am5exporting-align-right,
        .am5exporting-icon.am5exporting-align-right,
        .am5exporting-list.am5exporting-align-right {
            right: 6px !important;
        }

        .am5exporting-menu.am5exporting-valign-top,
        .am5exporting-icon.am5exporting-valign-top,
        .am5exporting-list.am5exporting-align-top {
            top: 5px !important;
        }

        .am5exporting-icon:focus,
        .am5exporting-icon:hover,
        .am5exporting-menu-open .am5exporting-icon {
            background: #ececec !important;
            opacity: 1;
        }

        .am5exporting-list {
            margin: 10px !important;
            background: #ececec !important;
            padding: 5px 0px !important;
            border: none !important;
        }

        .am5exporting-list.am5exporting-align-right {
            margin-right: 45px !important;
        }

        .modal {
            background-color: rgba(255, 255, 255, 0.28);
            -webkit-backdrop-filter: blur(0.5px);
            backdrop-filter: blur(0.5px);
        }

        .modal-content {
            border: none;
            border-radius: .8rem;
            box-shadow: 0 0.5rem 20rem rgb(0 0 0 / 17%);
        }
        .swal2-container .swal2-backdrop-show,
        .swal2-container.swal2-noanimation {
            background: #001f3f8f;
        }
        .swal2-icon{
            margin-top: 10px;
        }
        .swal2-container .swal2-html-container {
            margin: 0
        }

        .gradient-border {
            background: linear-gradient(#fff, #fff) padding-box,
              linear-gradient(45deg, #b721ff , #00bce2 ) border-box;
            border: 1px solid transparent;
            border-radius: 8px;
            box-shadow: 0px 8px 18px 4px rgba(0, 195, 255, 0.1);
        }
        
    </style>

</head>

<body class="sidebar-mini layout-navbar-fixed layout-fixed layout-navbar-fixed layout-footer-fixed text-sm">

    <div class="wrapper">
        @include('admin.layouts.status-message')
        @include('admin.layouts.navbar')
        @include('admin.layouts.sidebar')
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
        @include('admin.layouts.footer')
        @include('admin.layouts.preloader')

    </div>
    <div id="loading-spinner" style="display:none; position:fixed; z-index:9999; top:50%; left:50%; transform:translate(-50%,-50%);">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <script src="{{ asset('plugins') }}/jquery-ui/jquery-ui.min.js"></script>
    <script src="{{ asset('plugins') }}/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('plugins') }}/sweetalert2/sweetalert2.min.js"></script>
    <script src="{{ asset('plugins') }}/jquery-validation/jquery.validate.min.js"></script>
    <script src="{{ asset('plugins') }}/jquery-validation/additional-methods.min.js"></script>
    <script src="{{ asset('plugins') }}/select2/js/select2.full.min.js"></script>
    <script src="{{ asset('admin') }}/dist/js/adminlte.js"></script>
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script src="{{ asset('common') }}/js/common.js"></script>

</body>

</html>
