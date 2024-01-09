@extends('admin.layouts.app')
@section('content')
<style>
    #mostProductsChart {
        width: 100%;
        height: 300px;
    }

    #productsInRequisitionChart {
        width: 100%;
        height: 300px;
        font-size: 10px;
    }

    #stockProductsChart {
        width: 100%;
        height: 300px;
    }

    #mostProductsChart::before,
    #productsInRequisitionChart::before,
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
        background: url('{{ asset(' common/images/dashboard1.png') }}');
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
                            <p class="m-0" style="font-weight: 600;">আপনার {{ en2bn($pendingRequistion ?? 0) }} টি
                                চাহিদাপত্র অনুমোদনের অপেক্ষায় রয়েছে।</p>
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
                                        <a href="{{ route('admin.distribution.list') }}">অনুমোদনের অপেক্ষায়
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
                                        <a href="#">পন্য গ্রহন করুন</a>
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
        <div class="row mt-0 mt-md-3">
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-radius: 12px;">
                    <div class="card-header border-0 pb-0 pt-3">
                        <h4 class="card-title">চাহিদাপত্রের পরিসংখ্যান</h4>
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
                                    <form action="" method="post" id="requisitionProductsForm" autocomplete="off">
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
                        <div id="productsInRequisitionChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-0 mt-md-3">
            <div class="col-md-12">
                <div class="card shadow-sm" style="border-radius: 12px;">
                    <div class="card-header text-right border-0 pb-0 pt-3">
                        <h4 class="card-title">সর্বাধিক মজুদকৃত পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                        <div class="card-tools mr-0 d-flex align-items-center">
                            <a href="{{ route('admin.dashboard.stock-in-products') }}" class="btn btn-sm btn-light mr-1"
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
                                    <form action="" method="post" id="stockProductsForm" autocomplete="off">
                                        @csrf
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="stock_date_from" class="text-navy">শুরুর তারিখ :</label>
                                                    <input required="" type="text" value="" name="stock_date_from"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="stock_date_from" placeholder="শুরুর তারিখ">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="stock_date_to" class="text-navy">শেষ তারিখ :</label>
                                                    <input required="" type="text" value="" name="stock_date_to"
                                                        class="form-control form-control-sm text-gray singledatepicker"
                                                        id="stock_date_to" placeholder="শেষ তারিখ">
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
                        <div id="stockProductsChart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-0 mt-md-3">
            <div class="col-lg-6">
                <div class="requisition-list">
                    <div class="card shadow-sm">
                        <div class="card-header border-0">
                            <h4 class="card-title">চাহিদাপত্র <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <a href="{{ route('admin.recommended.requisition.list') }}" class="btn btn-sm btn-light"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table">
                                <thead style="background: #fff !important;">
                                    <tr>
                                        <th width="30%">চাহিদাপত্র নাম্বার</th>
                                        <th width="20%">তৈরি সময়</th>
                                        <th width="20%">শাখা</th>
                                        <th width="20%">অবস্থা</th>
                                        <th width="10%">অ্যাকশন</th>
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
                        <div class="card-header border-0">
                            <h4 class="card-title">সর্বশেষ প্রাপ্ত পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <a href="{{ route('admin.dashboard.received-products') }}" class="btn btn-sm btn-light"
                                style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                        </div>
                        <div class="card-body pt-0">
                            <table class="table">
                                <thead style="background: #fff !important;">
                                    <tr>
                                        <th width="20%">চাহিদাপত্র নাম্বার</th>
                                        <th width="20%">শাখা</th>
                                        <th width="40%">পন্যের নাম</th>
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
                    style="font-weight: 600;color: #2a527b;text-transform: uppercase;">পন্যের বিবরনী</h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <thead style="background: #fff !important;">
                        <tr>
                            <th>পন্য</th>
                            <th>বর্তমান মজূদ</th>
                            <th>চাহিদার পরিমান</th>
                            <th>সুপারিশ পরিমান</th>
                            <th>অনুমোদিত পরিমান</th>
                            <th>যৌক্তিকতা</th>
                        </tr>
                    </thead>
                    <tbody id="productDetailsTable">
                        <!-- Product details will be displayed here -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">বন্ধ করুন</button>
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
            let most_req_date_from  = $('#most_req_date_from').val();
            let most_req_date_to    = $('#most_req_date_to').val();
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
    let requisitionInfoByDepartment = <?php echo json_encode(@$requisitionInfoByDepartment); ?>;
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
                wheelX: "panX",
                wheelY: "zoomX",
                pinchZoomX:true,
                layout: root.verticalLayout
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

            if (window.innerWidth > 576 ) {
                xRenderer.labels.template.setAll({
                    strokeDasharray: [2, 2],
                    rotation: 0,
                    centerY: am5.p50,
                    centerX: am5.p100,
                    paddingRight: 5,
                    fontSize: 10,

                });

            } else {
                xRenderer.labels.template.setAll({
                    strokeDasharray: [2, 2],
                    rotation: -90,
                    centerY: am5.p0,
                    centerX: am5.p50,
                    paddingRight: 0,
                    fontSize: 8,

                });
            }

            var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
                categoryField: "department",
                renderer: xRenderer,
                tooltip: am5.Tooltip.new(root, {})
            }));

            // xRenderer.labels.template.setAll({
            //     strokeDasharray: [2, 2],
            //     fontSize: 12,
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
                        updateData.forEach((item) => {
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
    let chart4;
        let xAxis4, yAxis4, series4;
        let mostStockProducts = <?php echo json_encode(@$mostStockProducts); ?>;

        if (window.innerWidth > 576) {
            var textSize4 = 10;
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