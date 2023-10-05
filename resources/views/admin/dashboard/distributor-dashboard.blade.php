@extends('admin.layouts.app')
@section('content')
    <style>
        #mostDistributedProductsChart{
            width: 100%;
            height: 300px;
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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="requisition-div shadow-sm">
                        <div class="bg">
                            <div class="content px-3 py-4 text-white">
                                <h4 class="m-0" style="font-weight: 600;">আমার টাস্ক</h4>
                                <p class="m-0" style="font-weight: 600;">আপনার {{ en2bn($pendingRequistion ?? 0) }} টি চাহিদাপত্র বিতরণের অপেক্ষায় রয়েছে। </p>
                                <span class="mt-1 rounded" style="display:block; background: #fff; width:30px; height:2px;"></span>
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
                                            <a href="{{ route('admin.distribute.list') }}">পন্য বিতরণ করুন</a>
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
                                    সহজেই পন্য বিতরণ করুন।
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
                <div class="col-md-12">
                    <div class="card shadow-sm" style="border-radius: 12px;">
                        <div class="card-header text-right border-0 pb-0 pt-3">
                            <h4 class="card-title">সর্বাধিক বিতরণ করা পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                            <div class="card-tools mr-0 d-flex align-items-center">
                                <a href="{{ route('admin.dashboard.distributed-products') }}" class="btn btn-sm btn-light mr-1" style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                                <div class="dropdown show">
                                    <a class="btn btn-sm btn-light" data-toggle="dropdown" href="#" aria-expanded="true" style="margin-right:2rem; padding: 1px 6px;">
                                        <i class="far fa-calendar-alt"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right p-3 border-0" style="min-width: 200px !important;">
                                        {{-- <button type="button" class="close" aria-label="Close" id="closeDropdown">
                                                <span aria-hidden="true">&times;</span>
                                            </button> --}}
                                        <form action="" method="post" id="mostRequisitionProductsForm" autocomplete="off">
                                            @csrf
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="most_req_date_from" class="text-navy">শুরুর তারিখ :</label>
                                                        <input required="" type="text" value="" name="most_req_date_from" class="form-control form-control-sm text-gray singledatepicker" id="most_req_date_from" placeholder="শুরুর তারিখ">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label for="most_req_date_to" class="text-navy">শেষ তারিখ :</label>
                                                        <input required="" type="text" value="" name="most_req_date_to" class="form-control form-control-sm text-gray singledatepicker" id="most_req_date_to" placeholder="শেষ তারিখ">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group mb-0 d-flex">
                                                        <input required="" type="submit" value="খুজুন" class="form-control form-control-sm btn btn-sm btn-primary" id="">
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
        </div>
    </section>


    <!-- mostDistributedProductsChart code -->
    <script>
        let chart2;
        let xAxis2, yAxis2, series2;
        let mostDistributedProducts = <?php echo json_encode(@$mostDistributedProducts); ?>;
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
                fontSize: 10,
            });
            yRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            });


            yAxis2 = chart2.yAxes.push(am5xy.CategoryAxis.new(root, {
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
                categoryYField: "product",
                tooltip: am5.Tooltip.new(root, {
                    pointerOrientation: "left",
                    labelText: "{valueX}"
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
@endsection
