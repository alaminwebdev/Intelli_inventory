@extends('admin.layouts.app')
@section('content')
    <style>
        .requisition-div {
            border-radius: 15px;
            height: 300px;
            background: #fff;
            position: relative;
        }

        .dashboard-banner {
            border-radius: 15px;
            height: 300px;
            background: #3E97FF;
        }

        .requisition-div .bg {
            position: relative;
            height: 185px;
            border-radius: 12px;
            background: linear-gradient(102deg, #33B46E 0%, #44D486 100%);
            overflow: hidden;
        }

        .bg::before {
            position: absolute;
            content: '';
            width: 110%;
            height: 60%;
            left: 50%;
            bottom: 0;
            background: url('{{ asset('common/images/dashboard1.png') }}');
            background-repeat: no-repeat;
            background-size: cover;
            transform: translateX(-50%);
            overflow: hidden;
        }

        .requisition-card {
            position: relative;
            z-index: 99;
        }

        .requisition-card .text a {
            font-weight: 600;
            color: #2a527b;
        }

        .requisition-card .box {
            background: #fff;
            height: 120px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .card-header .card-title span {
            color: #979797;
            font-size: 12px;
        }
        .table thead th{
            color: #979797;
            text-align: left;
        }
        .table  tr td{
            color: #A1A5B7;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="requisition-div shadow-sm">
                        <div class="bg">
                            <div class="content px-3 py-4 text-white">
                                <h4 class="m-0" style="font-weight: 600;">আমার টাস্ক</h4>
                                <p class="m-0" style="font-weight: 600;">আপনার ২ টি অপেক্ষ্মান চাহিদাপত্র আছে।</p>
                                <span class="mt-1 rounded" style="display:block; background: #fff; width:30px; height:2px;"></span>
                            </div>
                        </div>
                        <div class="requisition-card p-3" style="margin-top: -55px;">
                            <div class="row">
                                <div class="col-sm-6 col-6">
                                    <div class="box requisition-make p-3 rounded shadow-sm" style="background: #FFF5F8">
                                        <div class="icon">
                                            <img src="{{ asset('common/images/icon1.png') }}" alt="requisition-make">
                                        </div>
                                        <div class="text pt-1">
                                            <a href="{{ route('admin.section.requisition.list') }}">চাহিদাপত্র তৈরি করুন</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-6">
                                    <div class="box product-receive p-3 rounded shadow-sm" style="background: #E8FFF3">
                                        <div class="icon">
                                            <img src="{{ asset('common/images/icon2.png') }}" alt="product-reecive">
                                        </div>
                                        <div class="text pt-1">
                                            <a href="{{ route('admin.section.requisition.receive.list') }}">পন্য গ্রহন করুন</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="dashboard-banner p-5 d-flex align-items-center">
                        <div class="row">
                            <div class="col-lg-7 text d-flex align-items-center">
                                <h3 style="font-weight: 600; color:#fff;">
                                    সহজেই আপনার চাহিদাপত্রের পন্য বুঝে নিন।
                                </h3>
                            </div>
                            <div class="col-lg-5 image d-flex align-items-center">
                                <img src="{{ asset('common/images/payment_by_phone.png') }}" class="img-fluid" alt="payment_by_phone">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="requisition-list">
                        <div class="card shadow-sm">
                            <div class="card-header text-right border-0">
                                <h4 class="card-title">চাহিদাপত্র <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                                <a href="#" class="btn btn-sm btn-light" style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table">
                                    <thead style="background: #fff !important;">
                                        <tr>
                                            <th width="30%">চাহিদাপত্র নাম্বার</th>
                                            <th width="30%">তৈরি সময়</th>
                                            <th width="30%">অবস্থা</th>
                                            <th width="10%">অ্যাকশন</th>
                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        <tr>
                                            <td>১৮৬৫৬</td>
                                            <td>তৈরি সময়</td>
                                            <td><span class="badge badge-info">সুপারিশ করা হয়েছে</span></td>
                                            <td><button class="btn btn-sm btn-light px-1 py-0" style="font-size: 11px !important;"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td>৪৫৫৫৬</td>
                                            <td>তৈরি সময়</td>
                                            <td><span class="badge badge-success">অনুমোদন করা হয়েছে</span></td>
                                            <td><button class="btn btn-sm btn-light px-1 py-0" style="font-size: 11px !important;"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                        <tr>
                                            <td>৬৭৬৭৭</td>
                                            <td>তৈরি সময়</td>
                                            <td><span class="badge badge-warning">সুপারিশের জন্য প্রেরন করা হয়েছে</span></td>
                                            <td><button class="btn btn-sm btn-light px-1 py-0" style="font-size: 11px !important;"><i class="fas fa-plus"></i></button></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="prodduct-list">
                        <div class="card shadow-sm">
                            <div class="card-header text-right border-0">
                                <h4 class="card-title">সর্বশেষ প্রাপ্ত পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                                <a href="#" class="btn btn-sm btn-light" style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                            </div>
                            <div class="card-body pt-0">
                                <table class="table">
                                    <thead style="background: #fff !important;">
                                        <tr>
                                            <th width="10%">আইডি</th>
                                            <th width="80%">পন্যের নাম</th>
                                            <th width="10%">পরিমান</th>
                                        </tr>
                                    </thead>
                                    <tbody id="">
                                        <tr>
                                            <td>১৮৬৫৬</td>
                                            <td>ওয়াল ফ্যান ১৮"</td>
                                            <td>5454</td>
                                        </tr>
                                        <tr>
                                            <td>৪৫৫৫৬</td>
                                            <td>ফ্যান ক্যাপাসিটার</td>
                                            <td>4545</td>
                                        </tr>
                                        <tr>
                                            <td>৬৭৬৭৭</td>
                                            <td>টেবিল গ্লাস</td>
                                            <td>4545</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
