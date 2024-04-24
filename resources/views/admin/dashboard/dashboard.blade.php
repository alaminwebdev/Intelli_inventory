@extends('admin.layouts.app')
@section('content')
<style>
    #mostProductsChart {
        width: 100%;
        height: 300px;
        font-size: 14px;
    }

    #productsInRequisitionChart {
        width: 100%;
        height: 300px;
        font-size: 10px;
    }


    #totalProductsInRequisitionChart {
        width: 100%;
        height: 300px;
        font-size: 14px;
    }

    #stockProductsChart {
        width: 100%;
        height: 300px;
        font-size: 14px;
    }

    #mostProductsChart::before,
    #productsInRequisitionChart::before,
    #totalProductsInRequisitionChart::before,
    #stockProductsChart::before {
        position: absolute;
        content: '';
        bottom: 12px;
        left: 20px;
        width: 60px;
        height: 30px;
        background: #fff;
        z-index: 1;


    }

    .requisition-div {
        border-radius: 15px;
        height: 362px;
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
        height: 230px;
        border-radius: 12px;
        background: linear-gradient(102deg, #923993 0%, #50d8d7 100%);
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
        height: 140px;
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
        color: #3f6791;
        font-size: 12px;
        font-weight: 500;
    }

    .table {
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    /* Extra small devices (portrait phones, less than 576px) */
    @media (max-width: 575.98px) {
        #productsInRequisitionChart {
            width: 100%;
            height: 600px;
            font-size: 8px;
        }


        .requisition-card {
            margin-top: -120px !important;
            height: 140px !important;
        }

        .my-card {
            height: 120px !important;
        }

        .add-stock {
            height: 115px !important;
        }

        .present-stock {
            height: 115px !important;
            margin-top: 8px;
        }

        .heighest-demand {
            margin-top: 10px !important;
        }

        .requisition-div {
            height: 400px !important;
        }

        .joint-stock {
            margin-bottom: 8px;
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

        #mostProductsChart,
        #stockProductsChart,
        #totalProductsInRequisitionChart {
            font-size: 7px;
        }
        .requisition-statistics-form{
            display: none;
        }
    }


    /* Small devices (landscape phones, 576px and up) */
    @media (min-width: 576px) and (max-width: 767.98px) {
        .heighest-demand {
            margin-top: 10px !important;
        }

        #productsInRequisitionChart {
            height: 600px;
            font-size: 8px;
        }
        .requisition-statistics-form{
            display: none;
        }

    }

    /* Medium devices (tablets, 768px and up) */
    @media (min-width: 768px) and (max-width: 991.98px) {
        .requisition-statistics-form{
            display: none;
        }
    }
</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="requisition-div shadow-sm">
                    <div class="bg">
                        <div class="content px-3 py-4 text-white">
                            <h4 class="m-0 text-uppercase" style="font-weight: 600;">My Task</h4>
                            <p class="m-0" style="font-weight: 600;">{{ $pendingRequistion ?? 0 }} requisition have been generated</p>
                            <span class="mt-1 rounded"
                                style="display:block; background: #fff; width:30px; height:2px;"></span>
                        </div>
                    </div>
                    <div class="requisition-card p-3" style="margin-top: -55px;">
                        <div class="row my-card">
                            <div class="col-sm-6 col-12 joint-stock">
                                <div class="add-stock box requisition-make p-3 rounded shadow-sm"
                                    style="background: #FFF5F8;">
                                    <div class="icon">
                                        <img src="{{ asset('common/images/icon1.png') }}" alt="stock-in">
                                    </div>
                                    <div class="text pt-1">
                                        <a href="{{ route('admin.stock.in.product.selection') }}">Add stock</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class=" present-stock box product-receive p-3 rounded shadow-sm"
                                    style="background: #E8FFF3;">
                                    <div class="icon">
                                        <img src="{{ asset('common/images/icon2.png') }}" alt="product-reecive">
                                    </div>
                                    <div class="text pt-1">
                                        <a href="{{ route('admin.report.current.stock.in.list') }}">Current stock</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8  heighest-demand">
                <div class="most-requisition-products">
                    <div class="card shadow-sm" style="border-radius: 12px;">
                        <div class="card-header border-0 pb-0 pt-3">
                            <h4 class="card-title">Most demanded product<span>( Latest 10 reports )</span></h4>
                            <div class="card-tools mr-0 d-flex align-items-center">
                                <a href="{{ route('admin.product.statistics') }}" class="btn btn-sm btn-light mr-1"
                                    style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> More</a>
                                <div class="dropdown show">
                                    <a class="btn btn-sm btn-light" data-toggle="dropdown" href="#" aria-expanded="true"
                                        style="margin-right:2rem; padding: 1px 6px;">
                                        <i class="far fa-calendar-alt"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right p-3 border-0"
                                        style="min-width: 200px !important;">
                                        {{-- <button type="button" class="close" aria-label="Close" id="closeDropdown">
                                            <span aria-hidden="true">&times;</span>
                                        </button> --}}
                                        <form action="" method="post" id="mostRequisitionProductsForm"
                                            autocomplete="off">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="most_req_date_from" class="text-navy">Start Date
                                                            :</label>
                                                        <input required="" type="text" value=""
                                                            name="most_req_date_from"
                                                            class="form-control form-control-sm text-gray singledatepicker"
                                                            id="most_req_date_from" placeholder="Start Date">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="most_req_date_to" class="text-navy">End Date
                                                            :</label>
                                                        <input required="" type="text" value="" name="most_req_date_to"
                                                            class="form-control form-control-sm text-gray singledatepicker"
                                                            id="most_req_date_to" placeholder="End Date">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0 d-flex">
                                                        <input required="" type="submit" value="Search"
                                                            class="form-control form-control-sm btn btn-sm btn-primary"
                                                            id="">
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div id="mostProductsChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-radius: 12px;">
                    <div class="card-header border-0 pb-0 pt-3">
                        <h3 class="card-title">Requisition statistics <span>( According to the Department )</span></h3>
                        <div class="card-tools mr-0">
                            <div class="dropdown show requisition-statistics-form" >
                                <a class="btn btn-sm btn-light" data-toggle="dropdown" href="#" aria-expanded="true"
                                    style="margin-right:2rem; padding: 1px 6px;">
                                    <i class="far fa-calendar-alt"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right p-3 border-0"
                                    style="min-width: 200px !important;">
                                    {{-- <button type="button" class="close" aria-label="Close" id="closeDropdown">
                                        <span aria-hidden="true">&times;</span>
                                    </button> --}}
                                    <form action="" method="post" id="requisitionProductsForm" autocomplete="off">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="date_from" class="text-navy">Start Date :</label>
                                                    <input required="" type="text" value="" name="date_from"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="date_from" placeholder="Start Date">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="date_to" class="text-navy">End Date :</label>
                                                    <input required="" type="text" value="" name="date_to"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="date_to" placeholder="End Date">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group mb-0 d-flex">
                                                    <input required="" type="submit" value="Search"
                                                        class="form-control form-control-sm btn btn-sm btn-primary"
                                                        id="">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="productsInRequisitionChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-radius: 12px;">
                    <div class="card-header border-0 pb-0 pt-3">
                        <h4 class="card-title">Requisition and product statistics<span>( According to the Section )</span></h4>
                        <div class="card-tools mr-0">
                            <div class="dropdown show">
                                <a class="btn btn-sm btn-light" data-toggle="dropdown" href="#" aria-expanded="true"
                                    style="margin-right:2rem; padding: 1px 6px;">
                                    <i class="far fa-calendar-alt"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right p-3 border-0"
                                    style="min-width: 200px !important;">
                                    {{-- <button type="button" class="close" aria-label="Close" id="closeDropdown">
                                        <span aria-hidden="true">&times;</span>
                                    </button> --}}
                                    <form action="" method="post" id="totalSectionRequisitionForm" autocomplete="off">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="req_date_from" class="text-navy">Start Date :</label>
                                                    <input required="" type="text" value="" name="req_date_from"
                                                        class="form-control form-control-sm singledatepicker text-gray"
                                                        id="req_date_from" placeholder="Start Date">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="req_date_to" class="text-navy">End Date:</label>
                                                    <input required="" type="text" value="" name="req_date_to"
                                                        class="form-control form-control-sm singledatepicker text-gray"
                                                        id="req_date_to" placeholder="End Date">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group mb-0 d-flex">
                                                    <input required="" type="submit" value="Search"
                                                        class="form-control form-control-sm btn btn-sm btn-primary"
                                                        id="">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="totalProductsInRequisitionChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-radius: 12px;">
                    <div class="card-header border-0 pb-0 pt-3">
                        <h4 class="card-title">Most stocked products <span>( Latest 10 reports )</span></h4>
                        <div class="card-tools mr-0 d-flex align-items-center">
                            <a href="{{ route('admin.dashboard.stock-in-products') }}" class="btn btn-sm btn-light mr-1"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> More</a>
                            <div class="dropdown show">
                                <a class="btn btn-sm btn-light" data-toggle="dropdown" href="#" aria-expanded="true"
                                    style="margin-right:2rem; padding: 1px 6px;">
                                    <i class="far fa-calendar-alt"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right p-3 border-0"
                                    style="min-width: 200px !important;">
                                    {{-- <button type="button" class="close" aria-label="Close" id="closeDropdown">
                                        <span aria-hidden="true">&times;</span>
                                    </button> --}}
                                    <form action="" method="post" id="stockProductsForm" autocomplete="off">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="stock_date_from" class="text-navy">Start Date :</label>
                                                    <input required="" type="text" value="" name="stock_date_from"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="stock_date_from" placeholder="Start Date">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="stock_date_to" class="text-navy">End Date :</label>
                                                    <input required="" type="text" value="" name="stock_date_to"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="stock_date_to" placeholder="End Date">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group mb-0 d-flex">
                                                    <input required="" type="submit" value="Search"
                                                        class="form-control form-control-sm btn btn-sm btn-primary"
                                                        id="">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div id="stockProductsChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-lg-6">
                <div class="requisition-list">
                    <div class="card shadow-sm">
                        <div class="card-header border-0">
                            <h4 class="card-title">Requisition <span>( Latest 10 reports )</span></h4>
                            <a href="{{ route('admin.section.requisition.list') }}" class="btn btn-sm btn-light"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> More</a>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table">
                                <thead style="background: #fff !important;">
                                    <tr>
                                        <th width="30%">Requisition No.</th>
                                        <th width="20%">Created at</th>
                                        <th width="20%">Section</th>
                                        <th width="20%">Status</th>
                                        <th width="10%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @foreach ($sectionRequisitions as $item)
                                    <tr>
                                        <td>{{ $item->requisition_no }}</td>
                                        <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td>
                                        <td>{{ $item->section->name }}</td>
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
            <div class="col-lg-6">
                <div class="prodduct-list">
                    <div class="card shadow-sm">
                        <div class="card-header border-0">
                            <h4 class="card-title">Last received product <span>( Latest 10 reports )</span></h4>
                            <a href="{{ route('admin.dashboard.received-products') }}" class="btn btn-sm btn-light"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> More</a>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table">
                                <thead style="background: #fff !important;">
                                    <tr>
                                        <th width="20%">Requisition No.</th>
                                        <th width="20%">Section</th>
                                        <th width="40%">Product</th>
                                        <th width="20%" class="text-right">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @foreach ($sectionRequisitionProducts as $item)
                                    <tr>
                                        <td>{{ $item->requisition_no }}</td>
                                        <td>{{ $item->section }}</td>
                                        <td>{{ $item->product }} ({{ $item->unit }})</td>
                                        <td class="text-right">{{ $item->final_approve_quantity }}</td>
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
                    style="font-weight: 600;color: #2a527b;text-transform: uppercase;">Product details</h6>
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
                            <th>Approve Quantity</th>
                            <th>Remarks</th>
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

<!-- mostProductsChart code -->
<script>
    let chart2;
        let xAxis2, yAxis2, series2;
        let mostRequestedProducts = <?php echo json_encode(@$mostRequestedProducts); ?>;

        if (window.innerWidth > 576) {
            var textSize = 11;
            var yCategoryName = "product";
            var tooltipText = "{valueX}";
        } else {
            var textSize = 7;
            var yCategoryName = "product_short";
            var tooltipText = "{valueX} ({product})";
        }

        am5.ready(function() {

            // Create root element
            var root = am5.Root.new("mostProductsChart");


            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root),
            ]);


            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            chart2 = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "none",
                wheelY: "none",
            }));

            // We don't want zoom-out button to appear while animating, so we hide it
            chart2.zoomOutButton.set("forceHidden", true);


            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var yRenderer = am5xy.AxisRendererY.new(root, {
                minGridDistance: 10,
            });
            yRenderer.labels.template.setAll({
                strokeDasharray: [2, 2],
                fontSize: textSize,
            });
            yRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            });


            yAxis2 = chart2.yAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: yCategoryName,
                renderer: yRenderer,
                // tooltip: am5.Tooltip.new(root, {
                //     themeTags: ["axis"]
                // })
            }));

            var xRenderer = am5xy.AxisRendererX.new(root, {});
            xRenderer.labels.template.setAll({
                strokeDasharray: [2, 2],
                fontSize: textSize,
            });

            xRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            })

            xAxis2 = chart2.xAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0,
                min: 0,
                extraMax: 0.1,
                renderer: xRenderer,
            }));


            // Add series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            series2 = chart2.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis2,
                yAxis: yAxis2,
                valueXField: "quantity",
                categoryYField: yCategoryName,
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "left",
                    labelText: tooltipText
                })
            }));


            // Rounded corners for columns
            series2.columns.template.setAll({
                cornerRadiusTR: 5,
                cornerRadiusBR: 5,
                strokeOpacity: 0
            });

            // Make each column to be of a different color
            series2.columns.template.adapters.add("fill", function(fill, target) {
                return chart2.get("colors").getIndex(series2.columns.indexOf(target));
            });

            series2.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart2.get("colors").getIndex(series2.columns.indexOf(target));
            });


            // Set data
            // var data = [{
            //         "product": "ফ্যান ক্যাপাসিটার ২.৫/৩.৫(N/A)",
            //         "quantity": 2255250000
            //     },
            //     {
            //         "product": "টেবিল গ্লাস (ফোমসহ)(N/A)",
            //         "quantity": 430000000
            //     },
            //     {
            //         "product": "হ্যান্ড ড্রিল মেশিন(N/A)",
            //         "quantity": 1000000000
            //     }
            // ];
            var data = mostRequestedProducts.reverse();

            yAxis2.data.setAll(data);
            series2.data.setAll(data);

            chart2.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none",
                xAxis: xAxis2,
                yAxis: yAxis2
            }));

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series2.appear(1000);
            chart2.appear(1000, 100);

            var exporting = am5plugins_exporting.Exporting.new(root, {
                menu: am5plugins_exporting.ExportingMenu.new(root, {
                    container: document.getElementById("mostProductsChart")
                }),
                dataSource: data
            });

            exporting.events.on("dataprocessed", function(ev) {
                for (var i = 0; i < ev.data.length; i++) {
                    ev.data[i].sum = ev.data[i].value + ev.data[i].value2;
                }
            });
            exporting.get("menu").set("items", [{
                    type: "format",
                    format: "png",
                    label: "Export as Image"
                }, {
                    type: "format",
                    format: "json",
                    label: "Export as JSON"
                },
                {
                    type: "format",
                    format: "csv",
                    label: "Export as CSV"
                }, {
                    type: "format",
                    format: "print",
                    label: "Print"
                }
            ]);

        });
        $(document).on('submit', '#mostRequisitionProductsForm', function(e) {
            e.preventDefault();
            let most_req_date_from = $('#most_req_date_from').val();
            let most_req_date_to = $('#most_req_date_to').val();
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.dashboard.total-requisition-products') }}",
                type: "POST",
                data: {
                    date_from: most_req_date_from,
                    date_to: most_req_date_to
                },
                beforeSend: function() {
                    $('#loading-spinner').show();
                },
                success: function(response) {
                    var newData = response.reverse();
                    console.log(newData);

                    // Hide the existing chart div
                    $("#mostProductsChart").css({
                        display: "none"
                    });

                    // Update the chart data and show the chart div
                    var data = newData;

                    yAxis2.data.setAll(newData);
                    series2.data.setAll(newData);

                    // Show the chart div again
                    $("#mostProductsChart").css({
                        display: "block"
                    });
                    $('#loading-spinner').hide();
                },
                error: function() {
                    console.log('error');
                },
                complete: function() {
                    $('#loading-spinner').hide();
                }
            });
        });
</script>

<script>
    let allRequisitionInfoByDepartment = <?php echo json_encode(@$requisitionInfoByDepartment); ?>;

    var requisitionInfoByDepartment;

    if (window.innerWidth <= 425) {
        requisitionInfoByDepartment = allRequisitionInfoByDepartment.slice(0, 1);
    } else if (window.innerWidth <= 576) {
        requisitionInfoByDepartment = allRequisitionInfoByDepartment.slice(0, 2);
    } else if (window.innerWidth <= 991) {
        requisitionInfoByDepartment = allRequisitionInfoByDepartment.slice(0, 2);
    } else {
        requisitionInfoByDepartment = allRequisitionInfoByDepartment;
    }
        let series;
        am5.ready(function() {
            // Create root element
            var root = am5.Root.new("productsInRequisitionChart");

            // Set themes
            root.setThemes([am5themes_Animated.new(root)]);

            // Create chart
            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: 'panx',
                wheelY: 'zoomX',
                pinchZoomX:true,
                layout: root.verticalLayout,

            }));


            // Add legend
            var legend = chart.children.push(am5.Legend.new(root, {
                centerX: am5.p50,
                x: am5.p50
            }));

            // var data = [{
            //     "department": "2021",
            //     "totalRequisition": 12,
            //     "section1": 45,
            //     "section2": 124,
            //     "section3": 56
            // }, {
            //     "department": "2022",
            //     "totalRequisition": 23,
            //     "section4": 23,
            //     "section5": 89,
            //     "section6": 123
            // }, {
            //     "department": "2023",
            //     "totalRequisition": 15,
            //     "section7": 79,
            //     "section8": 34,
            //     "section9": 45
            // }];

            var data = requisitionInfoByDepartment;

            // Create axes
            var xRenderer = am5xy.AxisRendererX.new(root, {
                cellStartLocation: 0.1,
                cellEndLocation: 0.9
            });

            if (window.innerWidth > 767 ) {
                xRenderer.labels.template.setAll({
                    strokeDasharray: [2, 2],
                    rotation: 0,
                    centerY: am5.p50,
                    centerX: am5.p50,
                    paddingRight: 5,
                    fontSize: 11,

                });

            } else {
                xRenderer.labels.template.setAll({
                    strokeDasharray: [2, 2],
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 0,
                    fontSize: 7,

                });
            }

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                categoryField: "department",
                renderer: xRenderer,
                autoWrap: true,

                tooltip: am5.Tooltip.new(root, {})
            }));

            // xRenderer.labels.template.setAll({
            //     strokeDasharray: [2, 2],
            //     fontSize: 8,
            // });

            xRenderer.grid.template.setAll({
                location: 1,
                strokeOpacity: 0.1,
            })


            var yRenderer = am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1,
            });
            yRenderer.labels.template.setAll({
                fontSize: 12
            });
            yRenderer.grid.template.setAll({
                strokeDasharray: [2, 2]
            });

            var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                min: 0,
                // renderer: am5xy.AxisRendererY.new(root, {
                //     strokeOpacity: 0.1
                // }),
                renderer: yRenderer
            }));

            // Add series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            function makeSeries(name, fieldName, stacked) {
                series = chart.series.push(am5xy.ColumnSeries.new(root, {
                    stacked: stacked,
                    name: name,
                    xAxis: xAxis,
                    yAxis: yAxis,
                    valueYField: fieldName,
                    categoryXField: "department",
                }));

                series.columns.template.setAll({
                    tooltipText: "{name}:{valueY}",
                    width: am5.percent(100),
                    tooltipY: am5.percent(10)
                });
                series.data.setAll(data);

                // Make stuff animate on load
                // https://www.amcharts.com/docs/v5/concepts/animations/
                series.appear();

                series.bullets.push(function() {
                    return am5.Bullet.new(root, {
                        locationY: 0.5,
                        sprite: am5.Label.new(root, {
                            text: "{valueY}",
                            fill: root.interfaceColors.get("alternativeText"),
                            centerY: am5.percent(50),
                            centerX: am5.percent(50),
                            populateText: true
                        })
                    });
                });

                legend.data.push(series);
            }

            // Loop through data to create series for each section in each department
            data.forEach((item) => {
                let hasTotalRequisition = false;
                for (var key in item) {
                    // console.log(item[key]);
                    if (key !== "department" && key !== "totalRequisition") {
                        makeSeries(key, key, true);
                    }
                    if (key == "totalRequisition" && !hasTotalRequisition) {
                        hasTotalRequisition = true; // Mark as created
                    }
                }
            });

            makeSeries("Total Requisition", "totalRequisition", false);

            xAxis.data.setAll(data);
            // Make stuff animate on load
            chart.appear(1000, 100);

            $(document).on('submit', '#requisitionProductsForm', function(e) {
                e.preventDefault();
                let date_from = $('#date_from').val();
                let date_to = $('#date_to').val();
                // Set up CSRF token for all AJAX requests
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    url: "{{ route('admin.dashboard.requisition-info-by-department') }}",
                    type: "POST",
                    data: {
                        date_from: date_from,
                        date_to: date_to
                    },
                    beforeSend: function() {
                        $('#loading-spinner').show();
                    },
                    success: function(response) {

                        // Hide the existing chart div
                        $("#productsInRequisitionChart").css({
                            display: "none"
                        });

                        // Update the chart data and show the chart div
                        var updateData = response;

                        // Remove existing series and legend items
                        chart.series.clear();
                        legend.data.clear();

                        function makeSeries(name, fieldName, stacked) {
                            series = chart.series.push(am5xy.ColumnSeries.new(root, {
                                stacked: stacked,
                                name: name,
                                xAxis: xAxis,
                                yAxis: yAxis,
                                valueYField: fieldName,
                                categoryXField: "department",
                            }));

                            series.columns.template.setAll({
                                tooltipText: "{name}:{valueY}",
                                width: am5.percent(100),
                                tooltipY: am5.percent(10)
                            });
                            series.data.setAll(updateData);

                            // Make stuff animate on load
                            // https://www.amcharts.com/docs/v5/concepts/animations/
                            series.appear();

                            series.bullets.push(function() {
                                return am5.Bullet.new(root, {
                                    locationY: 0.5,
                                    sprite: am5.Label.new(root, {
                                        text: "{valueY}",
                                        fill: root.interfaceColors.get(
                                            "alternativeText"),
                                        centerY: am5.percent(50),
                                        centerX: am5.percent(50),
                                        populateText: true
                                    })
                                });
                            });

                            legend.data.push(series);
                        }

                        // Loop through data to create series for each section in each department
                        updateData.forEach((item) => {
                            let hasTotalRequisition = false;
                            for (var key in item) {
                                // console.log(item[key]);
                                if (key !== "department" && key !==
                                    "totalRequisition") {
                                    makeSeries(key, key, true);
                                }
                                if (key == "totalRequisition" && !hasTotalRequisition) {
                                    hasTotalRequisition = true; // Mark as created
                                }
                            }
                        });

                        makeSeries("Total Requisition", "totalRequisition", false);

                        xAxis.data.setAll(updateData);
                        chart.appear(1000, 100);

                        // Update the content of the card title
                        // $('.receive-time').text(date_from + ' - ' + date_to);

                        // Show the chart div again
                        $("#productsInRequisitionChart").css({
                            display: "block"

                        });
                        $('#loading-spinner').hide();
                    },
                    error: function() {
                        console.log('error');
                    },
                    complete: function() {
                        $('#loading-spinner').hide();
                    }
                });
            });

            var exporting3 = am5plugins_exporting.Exporting.new(root, {
                menu: am5plugins_exporting.ExportingMenu.new(root, {
                    container: document.getElementById("productsInRequisitionChart")
                }),
                dataSource: data
            });

            exporting3.events.on("dataprocessed", function(ev) {
                for (var i = 0; i < ev.data.length; i++) {
                    ev.data[i].sum = ev.data[i].value + ev.data[i].value2;
                }
            });
            exporting3.get("menu").set("items", [{
                    type: "format",
                    format: "png",
                    label: "Export as Image"
                }, {
                    type: "format",
                    format: "json",
                    label: "Export as JSON"
                },
                {
                    type: "format",
                    format: "csv",
                    label: "Export as CSV"
                }, {
                    type: "format",
                    format: "print",
                    label: "Print"
                }
            ]);
        });
</script>


<script>
    let chart3;
        let xAxis3, seriesEx, seriesMn, spacerSeries;
        let allTotalProductsInRequisition = <?php echo json_encode(@$totalProductsInRequisition); ?>;

        if (window.innerWidth > 600) {
            var totalProductsInRequisition = allTotalProductsInRequisition;
        } else {
            var totalProductsInRequisition = allTotalProductsInRequisition.slice(0, 5);
        }

        am5.ready(function() {

            // Create root element
            var root = am5.Root.new("totalProductsInRequisitionChart");

            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);

            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            chart3 = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "none",
                wheelY: "none",
                pinchZoomX: false

            }));

            // Add cursor
            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart3.set("cursor", am5xy.XYCursor.new(root, {}));
            cursor.lineY.set("visible", false);

            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xRenderer = am5xy.AxisRendererX.new(root, {
                minGridDistance: 30
            });

            if (window.innerWidth > 600) {
                xRenderer.labels.template.setAll({
                    rotation: 0,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 5,
                    fontSize: 11,

                });

            } else {
                xRenderer.labels.template.setAll({
                    rotation: -90,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 5,
                    fontSize: 10,

                });
            }

            xRenderer.grid.template.setAll({
                location: 1,
                strokeOpacity: 0
            });


            xAxis3 = chart3.xAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "section_short",
                renderer: xRenderer,
                autoWrap: true,
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{section}"
                })
            }));


            var yRenderer = am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1,
            });
            yRenderer.labels.template.setAll({
                fontSize: 12
            });
            yRenderer.grid.template.setAll({
                strokeDasharray: [2, 2]
            });

            var yAxis2 = chart3.yAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                // renderer: am5xy.AxisRendererY.new(root, {
                //     strokeOpacity: 0.1
                // }),
                renderer: yRenderer
            }));

            // Create extra series (Series 2) for the extra bars
            seriesEx = chart3.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 2",
                xAxis: xAxis3,
                yAxis: yAxis2,
                valueYField: "totalRequisitions", // Use the same value field as the main series
                sequencedInterpolation: true,
                categoryXField: "section_short",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "Total Requisitions: {valueY}"
                }),
                clustered: true,
                clusterGutter: am5.percent(5)

            }));

            seriesEx.columns.template.setAll({
                cornerRadiusTL: 0,
                cornerRadiusTR: 0,
                strokeOpacity: 0,
                width: am5.percent(100),
                fill: "#F1F1F2",
            });

            // Create main series (Series 1)
            seriesMn = chart3.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis3,
                yAxis: yAxis2,
                valueYField: "totalProducts",
                sequencedInterpolation: true,
                categoryXField: "section_short",
                tooltip: am5.Tooltip.new(root, {
                    labelText: "Number of Products: {valueY}"
                }),
                clustered: true,
                clusterGutter: am5.percent(0)
            }));

            seriesMn.columns.template.setAll({
                cornerRadiusTL: 0,
                cornerRadiusTR: 0,
                strokeOpacity: 0,
                width: am5.percent(100),
            });

            seriesMn.columns.template.adapters.add("fill", function(fill, target) {
                return chart3.get("colors").getIndex(seriesMn.columns.indexOf(target));
            });

            seriesMn.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart3.get("colors").getIndex(seriesMn.columns.indexOf(target));
            });


            // Add a transparent spacer bar after each extra bar
            spacerSeries = chart3.series.push(am5xy.ColumnSeries.new(root, {
                name: "Spacer Series",
                xAxis: xAxis3,
                yAxis: yAxis2,
                valueYField: "totalProducts",
                sequencedInterpolation: true,
                categoryXField: "section",
                clustered: true, // Enable clustering
                clusterGutter: am5.percent(0),
                hiddenInLegend: true, // Hide this series in the legend
            }));

            spacerSeries.columns.template.setAll({
                cornerRadiusTL: 0,
                cornerRadiusTR: 0,
                strokeOpacity: 0,
                width: am5.percent(100),
                fill: "transparent", // Set the fill color to transparent
            });


            // Set data for both series
            //     var data = [ {
            //         section: "USAPPPPPP 000",
            //         section_short:"hhhh",
            //         totalRequisitions: 4545,
            //         totalProducts: 1882
            //     }, {
            //         section: "Japan 000",
            //         section_short:"aaaa",
            //         totalRequisitions: 5600,
            //         totalProducts: 1809
            //     }, {
            //         section: "Germany 000",
            //         section_short:"bbbb",
            //         totalRequisitions: 5656,
            //         totalProducts: 1322
            //     }, {
            //         section: "UK 000",
            //         section_short:"rrrrr",
            //         totalRequisitions: 234,
            //         totalProducts: 1122
            //     },
            //      {
            //         section: "AMIK 000",
            //         section_short:"kkkkk",
            //         totalRequisitions: 234,
            //         totalProducts: 1122
            //     },
            //      {
            //         section: "PPPPPP 00",
            //         section_short:"nnnnnnn",
            //         totalRequisitions: 234,
            //         totalProducts: 1122
            //     },
            //      {
            //         section: "JJJJ ooJ",
            //         section_short:"MMMM",
            //         totalRequisitions: 2340,
            //         totalProducts: 1120
            //     }
            // ];
            var data = totalProductsInRequisition;



            xAxis3.data.setAll(data);
            seriesMn.data.setAll(data);
            seriesEx.data.setAll(data);
            spacerSeries.data.setAll(data);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            seriesMn.appear(1000);
            seriesEx.appear(1000);
            spacerSeries.appear(1000);
            chart3.appear(1000, 100);

            var exporting2 = am5plugins_exporting.Exporting.new(root, {
                menu: am5plugins_exporting.ExportingMenu.new(root, {
                    container: document.getElementById("totalProductsInRequisitionChart")
                }),
                dataSource: data
            });

            exporting2.events.on("dataprocessed", function(ev) {
                for (var i = 0; i < ev.data.length; i++) {
                    ev.data[i].sum = ev.data[i].value + ev.data[i].value2;
                }
            });
            exporting2.get("menu").set("items", [{
                    type: "format",
                    format: "png",
                    label: "Export as Image"
                }, {
                    type: "format",
                    format: "json",
                    label: "Export as JSON"
                },
                {
                    type: "format",
                    format: "csv",
                    label: "Export as CSV"
                }, {
                    type: "format",
                    format: "print",
                    label: "Print"
                }
            ]);

        }); // end am5.ready()

        $(document).on('submit', '#totalSectionRequisitionForm', function(e) {
            e.preventDefault();
            let req_date_from = $('#req_date_from').val();
            let req_date_to = $('#req_date_to').val();
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.dashboard.total-products-in-requisition-by-section') }}",
                type: "POST",
                data: {
                    date_from: req_date_from,
                    date_to: req_date_to
                },
                beforeSend: function() {
                    $('#loading-spinner').show();
                },
                success: function(response) {
                    var allNewData = response;

                    if (window.innerWidth > 600) {
                        var newData = allNewData;
                    } else {
                        var newData = allNewData.slice(0, 5);
                    }



                    // Hide the existing chart div
                    $("#totalProductsInRequisitionChart").css({
                        display: "none"
                    });

                    // Update the chart data and show the chart div
                    var data = newData;

                    // Shuffle the data array randomly
                    // data = data.sort(function() {
                    //     return 0.5 - Math.random();
                    // });

                    xAxis3.data.setAll(newData);
                    seriesMn.data.setAll(newData);
                    seriesEx.data.setAll(newData);
                    spacerSeries.data.setAll(newData);

                    // Update the content of the card title
                    // $('.receive-time').text(date_from + ' - ' + date_to);

                    // Show the chart div again
                    $("#totalProductsInRequisitionChart").css({
                        display: "block"
                    });
                    $('#loading-spinner').hide();
                },
                error: function() {
                    console.log('error');
                },
                complete: function() {
                    $('#loading-spinner').hide();
                }
            });
        });
</script>

<script>
    let chart4;
        let xAxis4, yAxis4, series4;
        let mostStockProducts = <?php echo json_encode(@$mostStockProducts); ?>;

        if (window.innerWidth > 576) {
            var textSize4 = 11;
            var yCategoryName4 = "product";
            var tooltipText4 = "{valueX}";
        } else {
            var textSize4 = 7;
            var yCategoryName4 = "product_short";
            var tooltipText4 = "{valueX} ({product})";
        }

        am5.ready(function() {

            // Create root element
            var root = am5.Root.new("stockProductsChart");


            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root),
            ]);


            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            chart4 = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "none",
                wheelY: "none",
            }));

            // We don't want zoom-out button to appear while animating, so we hide it
            chart4.zoomOutButton.set("forceHidden", true);


            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var yRenderer = am5xy.AxisRendererY.new(root, {
                minGridDistance: 10,
            });
            yRenderer.labels.template.setAll({
                strokeDasharray: [2, 2],
                fontSize: textSize4,
            });
            yRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            });


            yAxis4 = chart4.yAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: yCategoryName4,
                renderer: yRenderer,
                // tooltip: am5.Tooltip.new(root, {
                //     themeTags: ["axis"]
                // })
            }));

            var xRenderer = am5xy.AxisRendererX.new(root, {});
            xRenderer.labels.template.setAll({
                strokeDasharray: [2, 2],
                fontSize: textSize4,
            });

            xRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            })

            xAxis4 = chart4.xAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0,
                min: 0,
                extraMax: 0.1,
                renderer: xRenderer,
            }));


            // Add series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            series4 = chart4.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis4,
                yAxis: yAxis4,
                valueXField: "quantity",
                categoryYField: yCategoryName4,
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "left",
                    labelText: tooltipText4
                })
            }));


            // Rounded corners for columns
            series4.columns.template.setAll({
                cornerRadiusTR: 5,
                cornerRadiusBR: 5,
                strokeOpacity: 0
            });

            // Make each column to be of a different color
            series4.columns.template.adapters.add("fill", function(fill, target) {
                return chart4.get("colors").getIndex(series4.columns.indexOf(target));
            });

            series4.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart4.get("colors").getIndex(series4.columns.indexOf(target));
            });


            // Set data
            // var data = [{
            //         "product": "ফ্যান ক্যাপাসিটার ২.৫/৩.৫(N/A)",
            //         "quantity": 2255250000
            //     },
            //     {
            //         "product": "টেবিল গ্লাস (ফোমসহ)(N/A)",
            //         "quantity": 430000000
            //     },
            //     {
            //         "product": "হ্যান্ড ড্রিল মেশিন(N/A)",
            //         "quantity": 1000000000
            //     }
            // ];
            var data = mostStockProducts.reverse();

            yAxis4.data.setAll(data);
            series4.data.setAll(data);

            chart4.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none",
                xAxis: xAxis4,
                yAxis: yAxis4
            }));

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series4.appear(1000);
            chart4.appear(1000, 100);

            var exporting4 = am5plugins_exporting.Exporting.new(root, {
                menu: am5plugins_exporting.ExportingMenu.new(root, {
                    container: document.getElementById("stockProductsChart")
                }),
                dataSource: data
            });

            exporting4.events.on("dataprocessed", function(ev) {
                for (var i = 0; i < ev.data.length; i++) {
                    ev.data[i].sum = ev.data[i].value + ev.data[i].value2;
                }
            });
            exporting4.get("menu").set("items", [{
                    type: "format",
                    format: "png",
                    label: "Export as Image"
                }, {
                    type: "format",
                    format: "json",
                    label: "Export as JSON"
                },
                {
                    type: "format",
                    format: "csv",
                    label: "Export as CSV"
                }, {
                    type: "format",
                    format: "print",
                    label: "Print"
                }
            ]);

        });

        $(document).on('submit', '#stockProductsForm', function(e) {
            e.preventDefault();
            let stock_date_from = $('#stock_date_from').val();
            let stock_date_to = $('#stock_date_to').val();
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.dashboard.total-stock-products') }}",
                type: "POST",
                data: {
                    date_from: stock_date_from,
                    date_to: stock_date_to
                },
                beforeSend: function() {
                    $('#loading-spinner').show();
                },
                success: function(response) {
                    var newData = response.reverse();
                    console.log(newData);

                    // Hide the existing chart div
                    $("#stockProductsChart").css({
                        display: "none"
                    });

                    // Update the chart data and show the chart div
                    var data = newData;

                    // Shuffle the data array randomly
                    // data = data.sort(function() {
                    //     return 0.5 - Math.random();
                    // });

                    yAxis4.data.setAll(newData);
                    series4.data.setAll(newData);

                    // Update the content of the card title
                    // $('.receive-time').text(date_from + ' - ' + date_to);

                    // Show the chart div again
                    $("#stockProductsChart").css({
                        display: "block"
                    });
                    $('#loading-spinner').hide();
                },
                error: function() {
                    console.log('error');
                },
                complete: function() {
                    $('#loading-spinner').hide();
                }
            });
        });
</script>
@endsection