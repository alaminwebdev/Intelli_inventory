@extends('admin.layouts.app')
@section('content')
    <style>
        #chartdiv {
            width: 100%;
            height: 300px;
        }

        .requisition-div {
            border-radius: 15px;
            height: 360px;
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
            height: 220px;
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
                                <p class="m-0" style="font-weight: 600;">আপনার {{ en2bn($pendingRequistion) }} টি চাহিদাপত্র সুপারিশের অপেক্ষায় রয়েছে।</p>
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
                                            <a href="{{ route('admin.recommended.requisition.list') }}">সুপারিশের অপেক্ষায় চাহিদাপত্র</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-6">
                                    <div class="box product-receive p-3 rounded shadow-sm" style="background: #E8FFF3">
                                        <div class="icon">
                                            <img src="{{ asset('common/images/icon2.png') }}" alt="product-reecive">
                                        </div>
                                        <div class="text pt-1">
                                            <a href="#">পন্য গ্রহন করুন</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="most-requisition-products">
                        <div class="card shadow-sm" style="border-radius: 12px;">
                            <div class="card-header text-right border-0 pb-0">
                                <h4 class="card-title">সর্বাধিক চাহিদাকৃত পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                                <a href="{{ route('admin.recommended.requisition.list') }}" class="btn btn-sm btn-light" style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
                            </div>
                            <div class="card-body pt-0">
                                <div id="chartdiv"></div>
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
                                <a href="{{ route('admin.recommended.requisition.list') }}" class="btn btn-sm btn-light" style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
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
                                                $formatter = new IntlDateFormatter('bn_BD', IntlDateFormatter::LONG, IntlDateFormatter::NONE);
                                                $formatter->setPattern('d-MMMM-y');
                                                $date = $formatter->format($item->created_at);
                                            @endphp
                                            <tr>
                                                <td>{{ en2bn($item->requisition_no) }}</td>
                                                {{-- <td>{{ date('d-M-Y', strtotime($item->created_at)) }}</td> --}}
                                                <td>{{ $date }}</td>
                                                <td>{{ $item->section->name }}</td>
                                                <td>{!! requisitionStatus($item->status) !!}</td>
                                                <td><button class="btn btn-sm btn-light px-1 py-0 view-products" style="font-size: 11px !important;" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id="{{ $item->id }}"><i class="fas fa-plus"></i></button></td>
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
                            <div class="card-header text-right border-0">
                                <h4 class="card-title">সর্বশেষ প্রাপ্ত পণ্য <span>( সর্বশেষ ১০ টি প্রতিবেদন )</span></h4>
                                <a href="{{ route('admin.dashboard.received-products') }}" class="btn btn-sm btn-light" style="font-size: 11px !important;"><i class="fas fa-list mr-1"></i> আরও</a>
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
    <div class="modal" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="productDetailsModalLabel" style="font-weight: 600;color: #2a527b;text-transform: uppercase;">পন্যের বিবরনী</h6>
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

    <!-- Resources -->
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>

    <!-- Chart code -->
    <script>
        am5.ready(function() {

            // Create root element
            var root = am5.Root.new("chartdiv");


            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root),
            ]);


            // Create chart
            // https://www.amcharts.com/docs/v5/charts/xy-chart/
            var chart = root.container.children.push(am5xy.XYChart.new(root, {
                panX: false,
                panY: false,
                wheelX: "none",
                wheelY: "none"
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
                textAlign: "start",
            });
            yRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            });


            var yAxis = chart.yAxes.push(am5xy.CategoryAxis.new(root, {
                maxDeviation: 0.3,
                categoryField: "product",
                renderer: yRenderer,
                tooltip: am5.Tooltip.new(root, {
                    themeTags: ["axis"]
                })
            }));

            var xRenderer = am5xy.AxisRendererX.new(root, {});
            xRenderer.labels.template.setAll({
                strokeDasharray: [2, 2],
                fontSize: 10
            });

            xRenderer.grid.template.setAll({
                strokeOpacity: 0.1,
            })

            var xAxis = chart.xAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0,
                min: 0,
                extraMax: 0.1,
                renderer: xRenderer,
            }));


            // Add series
            // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
            var series = chart.series.push(am5xy.ColumnSeries.new(root, {
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
            var data = [{
                    "product": "ফ্যান ক্যাপাসিটার ২.৫/৩.৫(N/A)",
                    "quantity": 2255250000
                },
                {
                    "product": "টেবিল গ্লাস (ফোমসহ)(N/A)",
                    "quantity": 430000000
                },
                {
                    "product": "হ্যান্ড ড্রিল মেশিন(N/A)",
                    "quantity": 1000000000
                },
                {
                    "product": "ডিস লাইনের জ্যাক(N/A)",
                    "quantity": 246500000
                },
                {
                    "product": "রয়েল প্লাগ প্লাস্টিকের(N/A)",
                    "quantity": 355000000
                },
                {
                    "product": "টু পিন প্লাগ(N/A)",
                    "quantity": 500000000
                },
                {
                    "product": "ওয়াল ফ্যান ১৮(N/A)",
                    "quantity": 624000000
                },
                {
                    "product": "ভ্যাকুয়াম ক্লিনার(N/A)",
                    "quantity": 329500000
                },
                {
                    "product": "গ্লাস লক(N/A)",
                    "quantity": 1433333333
                },
                {
                    "product": "ওয়াটার পিউরিফিকেশন ফিল্টার (পিপি)(N/A)",
                    "quantity": 1900000000
                }
            ];

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

        }); // end am5.ready()
    </script>
@endsection
