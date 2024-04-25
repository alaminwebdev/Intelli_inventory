@extends('admin.layouts.app')
@section('content')
<style>
    #mostDistributedProductsChart {
        width: 100%;
        height: 300px;
    }

    #mostDistributedProductsChart::before {
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
        height: 170px;
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
                            <p class="m-0" style="font-weight: 600;">আপনার {{ en2bn($pendingRequistion ?? 0) }} টি
                                চাহিদাপত্র বিতরণের অপেক্ষায় রয়েছে। </p>
                            <span class="mt-1 rounded"
                                style="display:block; background: #fff; width:30px; height:2px;"></span>
                        </div>
                    </div>
                    <div class="requisition-card p-3" style="margin-top: -55px;">
                        <div class="row">
                            <div class="col-sm-12 col-12">
                                <div class="box product-receive p-3 rounded shadow-sm" style="background: #E8FFF3">
                                    <div class="icon">
                                        <img src="{{ asset('common/images/icon2.png') }}" alt="product-reecive">
                                    </div>
                                    <div class="text pt-1">
                                        <a href="{{ route('admin.distribute.list') }}">Product বিতরণ করুন</a>
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
                            <h3 style="font-weight: 600; color:#fff;" class="dashboard-banner-text">
                                সহজেই Product বিতরণ করুন।
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
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-radius: 12px;">
                    <div class="card-header border-0 pb-0 pt-3">
                        <h4 class="card-title">সর্বাধিক বিতরণ করা পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                        <div class="card-tools mr-0 d-flex align-items-center">
                            <a href="{{ route('admin.product.statistics') }}" class="btn btn-sm btn-light mr-1"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
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
                                    <form action="" method="post" id="mostDistributedProductsForm" autocomplete="off">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="most_dist_date_from" class="text-navy">শুরুর তারিখ
                                                        :</label>
                                                    <input required="" type="text" value="" name="most_dist_date_from"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="most_dist_date_from" placeholder="শুরুর তারিখ">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="most_dist_date_to" class="text-navy">শেষ তারিখ :</label>
                                                    <input required="" type="text" value="" name="most_dist_date_to"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="most_dist_date_to" placeholder="শেষ তারিখ">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group mb-0 d-flex">
                                                    <input required="" type="submit" value="খুজুন"
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
                        <div id="mostDistributedProductsChart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-0 mt-md-3">
            <div class="col-md-12">
                <div class="requisition-list">
                    <div class="card shadow-sm">
                        <div class="card-header border-0">
                            <h4 class="card-title">বিতরণ করা চাহিদাপত্র <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <a href="{{ route('admin.distribute.list') }}" class="btn btn-sm btn-light"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table">
                                <thead style="background: #fff !important;">
                                    <tr>
                                        <th width="30%">Requisition No.</th>
                                        <th width="20%">তৈরি সময়</th>
                                        <th width="20%">Section</th>
                                        <th width="20%">অবস্থা</th>
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


<!-- mostDistributedProductsChart code -->
<script>
    let chart2;
        let xAxis2, yAxis2, series2;
        let mostDistributedProducts = <?php echo json_encode(@$mostDistributedProducts); ?>;
        if (window.innerWidth > 576) {
            var textSize = 10;
            var yCategoryName = "product";
            var tooltipText = "{valueX}";
        } else {
            var textSize = 7;
            var yCategoryName = "product_short";
            var tooltipText = "{valueX} ({product})";
        }
        am5.ready(function() {

            // Create root element
            var root = am5.Root.new("mostDistributedProductsChart");


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
                //     themeTags: ["axis"],
                //     labelText: "{product}"
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
                    labelText: tooltipText,
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
            var data = mostDistributedProducts.reverse();

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
                    container: document.getElementById("mostDistributedProductsChart")
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
        $(document).on('submit', '#mostDistributedProductsForm', function(e) {
            e.preventDefault();
            let most_dist_date_from = $('#most_dist_date_from').val();
            let most_dist_date_to = $('#most_dist_date_to').val();
            // Set up CSRF token for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: "{{ route('admin.dashboard.get-distributed-products') }}",
                type: "POST",
                data: {
                    date_from: most_dist_date_from,
                    date_to: most_dist_date_to
                },
                beforeSend: function() {
                    $('#loading-spinner').show();
                },
                success: function(response) {
                    var newData = response.reverse();
                    console.log(newData);

                    // Hide the existing chart div
                    $("#mostDistributedProductsChart").css({
                        display: "none"
                    });

                    // Update the chart data and show the chart div
                    var data = newData;

                    yAxis2.data.setAll(newData);
                    series2.data.setAll(newData);

                    // Show the chart div again
                    $("#mostDistributedProductsChart").css({
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