<!DOCTYPE html>
<html lang="en">
<title>@yield('pdf-title')</title>
<style type="text/css">
    @page {
        header: page-header;
        footer: page-footer;
    }

    /* @font-face {
        font-family: examplefont;
        src: url('../../../../fonts/kalpurush.ttf');
    } */

    body {
        font-family: 'Times New Roman', Times, serif;
        /* font-family: 'examplefont', sans-serif; */
        margin: 0;
    }

    h2 h3 {
        margin: 0;
        padding: 0;
    }

    table {
        border-collapse: collapse;
        width: 100%;
    }

    .table tr td {
        vertical-align: top;
        padding: 5px;
        font-size: 12px;
    }

    .table.border tr td {
        padding-left: 0 !important;
        padding-right: 0 !important;
    }

    .table-bordered th,
    .table-bordered td,
    .table-bordered tr {
        vertical-align: middle;
        padding: 0.5rem;
        border: .1px solid #888;
        font-size: 12px;
    }

    .table-bordered tr td {
        font-size: 11px !important;
    }

    .text-center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right {
        text-align: right;
    }

    .footer,
    .header {
        width: 100%;
    }

    .header .left {
        float: left;
        width: 10%;
        text-align: left;
    }

    .header .center {
        float: left;
        width: 80%;
        text-align: center;
        font-weight: bold;
    }

    .header .center p {
        margin: 0;
        padding: 0;
    }

    .header .right {
        float: left;
        width: 10%;
        padding-top: 5px;
        text-align: right;
    }

    .footer .left {
        float: left;
        width: 30%;
    }

    .footer .center {
        float: left;
        width: 40%;
        text-align: center;
    }

    .footer .right {
        float: left;
        width: 30%;
        text-align: right;
    }

</style>

<body>
    <div class="header">
        <div class="left">
            <img src="{{ fileExist(['url' => @$site_setting->logo, 'type' => 'logo']) }}" alt="report_logo" style="padding-top: 8px; width:40px;">
        </div>
        <div class="center">
            <div class="content">
                @yield('pdf-header')
            </div>
        </div>
        @yield('pdf-header-partner')
    </div>
    {{-- 'pdf-content --}}
    @yield('pdf-content')

    @include('admin.layouts.pdf-footer')
</body>

</html>
