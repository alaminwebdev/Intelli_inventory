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

    .table thead th {
        color: #595959;
        text-align: left;
    }

    .table tr td {
        color: #A1A5B7;
        font-size: 12px;
        font-weight: 600;
    }

    .table {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Extra small devices (portrait phones, less than 576px) */
    @media (max-width: 575.98px) {
        .requisition-div {
            height: 270px;
        }

        .requisition-card {
            margin-top: -80px !important;
        }

        .dashboard-banner {
            margin-top: 18px;
        }

        .dashboard-banner .image img {
            width: 60%;
        }

        .dashboard-banner-text {
            font-size: 24px;
        }

        .card-header .card-title {
            font-size: 14px;
        }

        .card-header .card-title span {
            font-size: 10px;
        }

        .table {
            display: block;
        }

        .table thead th {
            font-size: 12px;
        }

        .table tr td {
            font-size: 10px;
        }
    }

    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) and (max-width: 767.98px) {
        .requisition-div {
            height: 270px;
        }

        .requisition-card {
            margin-top: -80px !important;
        }

        .dashboard-banner {
            margin-top: 18px;
        }

        .dashboard-banner .image img {
            width: 60%;
        }

        .dashboard-banner-text {
            font-size: 24px;
        }

        .dashboard-banner .image img {
            width: 40%;
        }


    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .dashboard-banner .image img {
            width: 40%;
        }
    }

    /* Large devices (desktops, 992px and up) */
    @media (min-width: 992px) and (max-width: 1199.98px) {}

    /* Extra large devices (large desktops, 1200px and up) */
    @media (min-width: 1200px) {}
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="requisition-div shadow-sm">
                    <div class="bg">
                        <div class="content px-3 py-4 text-white">
                            <h4 class="m-0" style="font-weight: 600;">আমার টাস্ক</h4>
                            <p class="m-0" style="font-weight: 600;">আপনার {{ en2bn($pendingRequistion) }} টি অপেক্ষমান
                                চাহিদাপত্র আছে।</p>
                            <span class="mt-1 rounded"
                                style="display:block; background: #fff; width:30px; height:2px;"></span>
                        </div>
                    </div>
                    <div class="requisition-card p-3" style="margin-top: -55px;">
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="box requisition-make p-3 rounded shadow-sm" style="background: #FFF5F8">
                                    <div class="icon">
                                        <img src="{{ asset('common/images/icon1.png') }}" alt="requisition-make">
                                    </div>
                                    <div class="text pt-1">
                                        <a href="{{ route('admin.section.requisition.product.selection') }}">চাহিদাপত্র
                                            তৈরি করুন</a>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6 col-6">
                                <div class="box product-receive p-3 rounded shadow-sm" style="background: #E8FFF3">
                                    <div class="icon">
                                        <img src="{{ asset('common/images/icon2.png') }}" alt="product-reecive">
                                    </div>
                                    <div class="text pt-1">
                                        <a href="{{ route('admin.section.requisition.receive.list') }}">Product গ্রহন
                                            করুন</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="dashboard-banner p-5 d-flex align-items-center">
                    <div class="row">
                        <div class="col-lg-7 text d-flex align-items-center">
                            <h3 style="font-weight: 600; color:#fff;" class="dashboard-banner-text">
                                সহজেই আপনার চাহিদাপত্রের Product বুঝে নিন।
                            </h3>
                        </div>
                        <div class="col-lg-5 image d-flex align-items-center">
                            <img src="{{ asset('common/images/payment_by_phone.png') }}" class="img-fluid"
                                alt="payment_by_phone">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-6">
                <div class="requisition-list">
                    <div class="card shadow-sm">
                        <div class="card-header border-0">
                            <h4 class="card-title">চাহিদাপত্র <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <a href="{{ route('admin.section.requisition.list') }}" class="btn btn-sm btn-light"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table">
                                <thead style="background: #fff !important;">
                                    <tr>
                                        <th width="30%">Requisition No.</th>
                                        <th width="30%">তৈরি সময়</th>
                                        <th width="30%">অবস্থা</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @foreach ($sectionRequisitions as $item)
                                    @php
                                    $formatter = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG,
                                    IntlDateFormatter::NONE);
                                    $formatter->setPattern('d-MMMM-y');
                                    $date = $formatter->format($item->created_at);
                                    @endphp
                                    <tr>
                                        <td>{{ en2bn($item->requisition_no) }}</td>
                                        {{-- <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td> --}}
                                        <td>{{ $date }}</td>
                                        <td>{!! requisitionStatus($item->status) !!}</td>
                                        <td><button class="btn btn-sm btn-light px-1 py-0 view-products"
                                                style="font-size: 11px !important;" data-toggle="modal"
                                                data-target="#productDetailsModal"
                                                data-requisition-id="{{ $item->id }}"><i
                                                    class="fas fa-plus"></i></button></td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="prodduct-list">
                    <div class="card shadow-sm">
                        <div class="card-header border-0">
                            <h4 class="card-title">সর্বশেষ প্রাপ্ত পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <a href="{{ route('admin.dashboard.received-products') }}" class="btn btn-sm btn-light"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table">
                                <thead style="background: #fff !important;">
                                    <tr>
                                        <th width="30%">Requisition No.</th>
                                        <th width="50%">Productের নাম</th>
                                        <th width="20%" class="text-right">পরিমান</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @foreach ($sectionRequisitionProducts as $item)
                                    <tr>
                                        <td>{{ en2bn($item->requisition_no) }}</td>
                                        <td>{{ $item->product }} ({{ $item->unit }})</td>
                                        <td class="text-right">{{ en2bn($item->final_approve_quantity) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal for Product Details -->
<div class="modal" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="productDetailsModalLabel"
                    style="font-weight: 600;color: #2a527b;text-transform: uppercase;">Product Detail</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead style="background: #fff !important;">
                        <tr>
                            <th>Product</th>
                            <th>Current Stock</th>
                            <th>Demand Quantity</th>
                            <th>Recommended Quantity</th>
                            <th>Approved Quantity</th>
                            <th>Remark</th>
                        </tr>
                    </thead>
                    <tbody id="productDetailsTable">
                        <!-- Product details will be displayed here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
            $('.view-products').on('click', function() {
                var requistionID = $(this).data('requisition-id');

                document.getElementById('loading-spinner').style.display = 'block';
                $.ajax({
                    url: "{{ route('admin.get.requistion.details.by.id') }}",
                    type: "GET",
                    data: {
                        requisition_id: requistionID
                    },
                    success: function(products) {

                        // Clear any existing content in the modal table
                        $('#productDetailsTable').html('');

                        // Loop through the products and add them to the table
                        for (var i = 0; i < products.length; i++) {
                            var product = products[i];

                            var productName = product.product || "";
                            var unitName = product.unit || "";
                            var currentStock = product.current_stock || "";
                            var demandQuantity = product.demand_quantity || "";
                            var recommendedQuantity = product.recommended_quantity || "";
                            var finalApproveQuantity = product.final_approve_quantity || "";
                            var remarks = product.remarks || "";


                            // Append the product details to the table
                            $('#productDetailsTable').append(`
                                    <tr>
                                        <td>${productName} (${unitName})</td>
                                        <td class="text-right">${currentStock}</td>
                                        <td class="text-right">${demandQuantity}</td>
                                        <td class="text-right">${recommendedQuantity}</td>
                                        <td class="text-right">${finalApproveQuantity}</td>
                                        <td>${remarks}</td>
                                    </tr>
                                `);
                        }
                        document.getElementById('loading-spinner').style.display = 'none';
                    },
                    error: function(error) {
                        document.getElementById('loading-spinner').style.display = 'none';
                        console.error("Error:", error);

                    }
                });

            });

        });
</script>
@endsection