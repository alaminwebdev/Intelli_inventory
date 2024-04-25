@extends('admin.layouts.app')
@section('content')
<style>
    #mostProductsChart {
        width: 100%;
        height: 300px;
    }

    #totalProductsInRequisitionChart {
        width: 100%;
        height: 300px;
    }

    #mostProductsChart::before,
    #totalProductsInRequisitionChart::before {
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
</style>
@include('admin.dashboard.media-query')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="requisition-div shadow-sm">
                    <div class="bg">
                        <div class="content px-3 py-4 text-white">
                            <h4 class="m-0" style="font-weight: 600;">আমার টাস্ক</h4>
                            <p class="m-0" style="font-weight: 600;">আপনার {{ en2bn($pendingRequistion) }} টি চাহিদাপত্র
                                সুপারিশের অপেক্ষায় রয়েছে।</p>
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
                                        <a href="{{ route('admin.recommended.requisition.list') }}">সুপারিশের অপেক্ষায়
                                            চাহিদাপত্র</a>
                                    </div>
                                </div>
                            </div>
                            {{-- <div class="col-sm-6 col-6">
                                <div class="box product-receive p-3 rounded shadow-sm" style="background: #E8FFF3">
                                    <div class="icon">
                                        <img src="{{ asset('common/images/icon2.png') }}" alt="product-reecive">
                                    </div>
                                    <div class="text pt-1">
                                        <a href="#">Product গ্রহন করুন</a>
                                    </div>
                                </div>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="most-requisition-products">
                    <div class="card shadow-sm" style="border-radius: 12px;">
                        <div class="card-header border-0 pb-0 pt-3">
                            <h4 class="card-title">সর্বাধিক চাহিদাকৃত পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <div class="card-tools mr-0 d-flex align-items-center">
                                {{-- <a href="#" class="btn btn-sm btn-light mr-1"
                                    style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a> --}}
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
                                                        <label for="most_req_date_from" class="text-navy">শুরুর তারিখ
                                                            :</label>
                                                        <input required="" type="text" value=""
                                                            name="most_req_date_from"
                                                            class="form-control form-control-sm text-gray singledatepicker"
                                                            id="most_req_date_from" placeholder="শুরুর তারিখ">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="most_req_date_to" class="text-navy">শেষ তারিখ
                                                            :</label>
                                                        <input required="" type="text" value="" name="most_req_date_to"
                                                            class="form-control form-control-sm text-gray singledatepicker"
                                                            id="most_req_date_to" placeholder="শেষ তারিখ">
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
                            <div id="mostProductsChart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-0 mt-sm-3">
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-radius: 12px;">
                    <div class="card-header border-0 pb-0 pt-3">
                        <h4 class="card-title">সর্বাধিক চাহিদাপত্র এবং Product</h4>
                        <div class="card-tools mr-0">
                            <div class="dropdown show">
                                <a class="btn btn-sm btn-light" data-toggle="dropdown" href="#" aria-expanded="true"
                                    style="margin-right:2rem; padding: 1px 6px;">
                                    <i class="far fa-calendar-alt"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right p-3 border-0"
                                    style="min-width: 200px !important;">
                                    {{-- <button type="button" class="close" aria-label="Close" id="closeDropdown">
                                        <span aria-hidden="true">&times;</span>
                                    </button> --}}
                                    <form action="" method="post" id="requisitionProductsForm">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="date_from" class="text-navy">শুরুর তারিখ :</label>
                                                    <input required="" type="text" value="" name="date_from"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="date_from" placeholder="শুরুর তারিখ">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="date_to" class="text-navy">শেষ তারিখ :</label>
                                                    <input required="" type="text" value="" name="date_to"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="date_to" placeholder="শেষ তারিখ">
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
                        <div id="totalProductsInRequisitionChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-0 mt-sm-3">
            <div class="col-lg-6">
                <div class="requisition-list">
                    <div class="card shadow-sm">
                        <div class="card-header text-right border-0">
                            <h4 class="card-title">চাহিদাপত্র <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <a href="{{ route('admin.recommended.requisition.list') }}" class="btn btn-sm btn-light"
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
            <div class="col-lg-6">
                <div class="prodduct-list">
                    <div class="card shadow-sm">
                        <div class="card-header text-right border-0">
                            <h4 class="card-title">সর্বশেষ প্রাপ্ত পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <a href="{{ route('admin.dashboard.received-products') }}" class="btn btn-sm btn-light"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table">
                                <thead style="background: #fff !important;">
                                    <tr>
                                        <th width="20%">Requisition No.</th>
                                        <th width="20%">Section</th>
                                        <th width="40%">Productের নাম</th>
                                        <th width="20%" class="text-right">পরিমান</th>
                                    </tr>
                                </thead>
                                <tbody id="">
                                    @foreach ($sectionRequisitionProducts as $item)
                                    <tr>
                                        <td>{{ en2bn($item->requisition_no) }}</td>
                                        <td>{{ $item->section }}</td>
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


<!-- mostProductsChart code -->
<script>
    let chart;
        let xAxis, yAxis, series;
        let mostRequestedProducts = <?php echo json_encode(@$mostRequestedProducts); ?>;
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
            chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "none",
                wheelY: "none",
            }));

            // We don't want zoom-out button to appear while animating, so we hide it
            chart.zoomOutButton.set("forceHidden", true);


            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var yRenderer = am5xy.AxisRendererY.new(root, {
                minGridDistance: 10,
            });
            yRenderer.labels.template.setAll({
                strokeDasharray: [2, 2],
                fontSize: 10,
            });
            yRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            });


            yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "product",
                renderer: yRenderer,
                // tooltip: am5.Tooltip.new(root, {
                //     themeTags: ["axis"]
                // })
            }));

            var xRenderer = am5xy.AxisRendererX.new(root, {});
            xRenderer.labels.template.setAll({
                strokeDasharray: [2, 2],
                fontSize: 10,
            });

            xRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            })

            xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0,
                min: 0,
                extraMax: 0.1,
                renderer: xRenderer,
            }));


            // Add series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            series = chart.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis,
                yAxis: yAxis,
                valueXField: "quantity",
                categoryYField: "product",
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "left",
                    labelText: "{valueX}"
                })
            }));


            // Rounded corners for columns
            series.columns.template.setAll({
                cornerRadiusTR: 5,
                cornerRadiusBR: 5,
                strokeOpacity: 0
            });

            // Make each column to be of a different color
            series.columns.template.adapters.add("fill", function(fill, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
            });

            series.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart.get("colors").getIndex(series.columns.indexOf(target));
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

            yAxis.data.setAll(data);
            series.data.setAll(data);

            chart.set("cursor", am5xy.XYCursor.new(root, {
                behavior: "none",
                xAxis: xAxis,
                yAxis: yAxis
            }));

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series.appear(1000);
            chart.appear(1000, 100);

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

        }); // end am5.ready()

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

                    yAxis.data.setAll(newData);
                    series.data.setAll(newData);

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
    let chart2;
        let xAxis2, series2, series1, spacerSeries;

        let allTotalProductsInRequisition = <?php echo json_encode(@$totalProductsInRequisition); ?>;

        if (window.innerWidth > 767) {
            var totalProductsInRequisition = allTotalProductsInRequisition;
            var textRotate = 0;
            var textSize = 10;
        } else {
            var totalProductsInRequisition = allTotalProductsInRequisition.slice(0, 5);
            var textRotate = -90;
            var textSize = 7;
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
            chart2 = root.container.children.push(am5xy.XYChart.new(root, {
                panX: true,
                panY: true,
                wheelX: "none",
                wheelY: "none",
                pinchZoomX: true
                // wheelX: "panX",
                // wheelY: "zoomX",
            }));

            // Add cursor
            // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
            var cursor = chart2.set("cursor", am5xy.XYCursor.new(root, {}));
            cursor.lineY.set("visible", false);

            // Create axes
            // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
            var xRenderer = am5xy.AxisRendererX.new(root, {
                minGridDistance: 30
            });

            xRenderer.labels.template.setAll({
                rotation: textRotate,
                centerY: am5.p50,
                centerX: am5.p100,
                paddingRight: 15,
                fontSize: textSize
            });

            xRenderer.grid.template.setAll({
                location: 1,
                strokeOpacity: 0
            });

            xAxis2 = chart2.xAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "section_short",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {
                    labelText: "{section}"
                })
            }));

            var yRenderer = am5xy.AxisRendererY.new(root, {
                strokeOpacity: 0.1,
            });
            yRenderer.labels.template.setAll({
                fontSize: textSize
            });
            yRenderer.grid.template.setAll({
                strokeDasharray: [2, 2]
            });

            var yAxis2 = chart2.yAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0.3,
                // renderer: am5xy.AxisRendererY.new(root, {
                //     strokeOpacity: 0.1
                // }),
                renderer: yRenderer
            }));

            // Create extra series (Series 2) for the extra bars
            series2 = chart2.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 2",
                xAxis: xAxis2,
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

            series2.columns.template.setAll({
                cornerRadiusTL: 0,
                cornerRadiusTR: 0,
                strokeOpacity: 0,
                width: am5.percent(100),
                fill: "#F1F1F2",
            });

            // Create main series (Series 1)
            series1 = chart2.series.push(am5xy.ColumnSeries.new(root, {
                name: "Series 1",
                xAxis: xAxis2,
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

            series1.columns.template.setAll({
                cornerRadiusTL: 0,
                cornerRadiusTR: 0,
                strokeOpacity: 0,
                width: am5.percent(100),
            });

            series1.columns.template.adapters.add("fill", function(fill, target) {
                return chart2.get("colors").getIndex(series1.columns.indexOf(target));
            });

            series1.columns.template.adapters.add("stroke", function(stroke, target) {
                return chart2.get("colors").getIndex(series1.columns.indexOf(target));
            });


            // Add a transparent spacer bar after each extra bar
            spacerSeries = chart2.series.push(am5xy.ColumnSeries.new(root, {
                name: "Spacer Series",
                xAxis: xAxis2,
                yAxis: yAxis2,
                valueYField: "totalProducts",
                sequencedInterpolation: true,
                categoryXField: "section_short",
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
            // var data = [{
            //     section: "USA",
            //     totalRequisitions: 876,
            //     totalProducts: 2025
            // }, {
            //     section: "USA",
            //     totalRequisitions: 4545,
            //     totalProducts: 1882
            // }, {
            //     section: "Japan",
            //     totalRequisitions: 56,
            //     totalProducts: 1809
            // }, {
            //     section: "Germany",
            //     totalRequisitions: 5656,
            //     totalProducts: 1322
            // }, {
            //     section: "UK",
            //     totalRequisitions: 234,
            //     totalProducts: 1122
            // }];
            var data = totalProductsInRequisition;

            xAxis2.data.setAll(data);
            series1.data.setAll(data);
            series2.data.setAll(data);
            spacerSeries.data.setAll(data);

            // Make stuff animate on load
            // https://www.amcharts.com/docs/v5/concepts/animations/
            series1.appear(1000);
            series2.appear(1000);
            spacerSeries.appear(1000);
            chart2.appear(1000, 100);

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
                url: "{{ route('admin.dashboard.total-products-in-requisition-by-section') }}",
                type: "POST",
                data: {
                    date_from: date_from,
                    date_to: date_to
                },
                beforeSend: function() {
                    $('#loading-spinner').show();
                },
                success: function(response) {
                    var allNewData = response;

                    if (window.innerWidth > 767) {
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

                    xAxis2.data.setAll(newData);
                    series1.data.setAll(newData);
                    series2.data.setAll(newData);
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
@endsection