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
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="requisition-div shadow-sm">
                        <div class="bg">
                            <div class="content px-3 py-4 text-white">
                                <h4 class="m-0" style="font-weight: 600;">আমার টাস্ক</h4>
                                <p class="m-0" style="font-weight: 600;"></p>
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
                                            <a href="{{ route('admin.section.requisition.product.selection') }}">চাহিদাপত্র তৈরি করুন</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-6">
                                    <div class="box product-receive p-3 rounded shadow-sm" style="background: #E8FFF3">
                                        <div class="icon">
                                            <img src="{{ asset('common/images/icon2.png') }}" alt="product-reecive">
                                        </div>
                                        <div class="text pt-1">
                                            <a href="{{ route('admin.section.requisition.receive.list') }}">Product গ্রহন করুন</a>
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
                                    সহজেই আপনার চাহিদাপত্রের Product বুঝে নিন।
                                </h3>
                            </div>
                            <div class="col-lg-5 image d-flex align-items-center">
                                <img src="{{ asset('common/images/payment_by_phone.png') }}" class="img-fluid" alt="payment_by_phone">
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

@endsection
