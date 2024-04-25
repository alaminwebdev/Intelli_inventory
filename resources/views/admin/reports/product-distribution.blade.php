@extends('admin.layouts.app')
@section('content')
    <style>
        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
            background-color: #0072bc;
        }

        .select2-container--default .select2-results__option--selected {
            background-color: #f8f9fa;
        }

        table,
        thead,
        th,
        tr {
            color: #2a527b !important;
        }

        table tr {
            font-size: 14px !important;
        }

        table.table-bordered.dataTable th,
        table.table-bordered.dataTable td {
            border-left-width: 1px !important;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-info"><i class="fas fa-tachometer-alt mr-1"></i>Dashboard</a>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.product.distribution.report') }}" id="filterForm" autocomplete="off">
                                @csrf
                                <div class="gradient-border px-3 pt-4 pb-3 mb-4">
                                    <div class="form-row">

                                        <div class="form-group col-md-4">
                                            <label class="control-label">Department : <span class="text-red">*</span></label>
                                            <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror select2 ">
                                                <option value="0">-- All Department --</option>
                                                @foreach ($departments as $item)
                                                    <option value="{{ $item->id }}" {{ request()->department_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('department_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-4">
                                            <label class="control-label">Section :</label>
                                            <select name="section_id" id="section_id" class="form-control select2 @error('section_id') is-invalid @enderror">
                                                <option value="0">-- All Section --</option>
                                                {{-- @if (request()->section_id) --}}
                                                @foreach ($sections as $item)
                                                    <option value="{{ $item->id }}" {{ request()->section_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                                {{-- @endif --}}
                                            </select>
                                            @error('section_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="date_from" class="text-navy">Start Date :</label>
                                            <input type="text" value="{{ request()->date_from }}" name="date_from" class="form-control form-control-sm text-gray customdatepicker" id="date_from" placeholder="Start Date">
                                        </div>

                                        <div class="form-group col-md-2">
                                            <label for="date_to" class="text-navy">End Date :</label>
                                            <input type="text" value="{{ request()->date_to }}" name="date_to" class="form-control form-control-sm text-gray customdatepicker" id="date_to" placeholder="End Date">
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="control-label">Product :</label>
                                            <select name="product_information_id[]" id="product_information_id" class="form-control select2" multiple="multiple">
                                                {{-- <option value="0">-- All Product --</option> --}}
                                                @foreach ($products as $item)
                                                    <option value="{{ $item->id }}" {{ in_array($item->id, $product_ids) ? 'selected' : '' }} >{{ $item->name }} ({{ $item->unit }})</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="form-group col-md-6">
                                            <label class="control-label d-block">Action</label>
                                            <button type="submit" name="type" value="search" class="btn btn-success btn-sm mr-1" style="box-shadow:rgba(40, 167, 69, 0.30) 0px 8px 18px 4px"><i class="fas fa-search mr-1"></i> Search</button>
                                            @if (isset($distributed_products) && count($distributed_products) > 0)
                                                <button type="submit" class="btn btn-sm btn-primary" name="type" value="pdf" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px"><i class="fas fa-file-pdf mr-1"></i> Download as PDF</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table class="table table-sm table-bordered" style="width: 100%;" id="">
                                <thead style="background: #fff4f4 !important;">
                                    <tr>
                                        <th class="text-center">Sl.</th>
                                        <th class="text-center">Product</th>
                                        <th class="text-center">Unit</th>
                                        {{-- <th class="text-center">Department</th> --}}
                                        <th class="text-center">Section</th>
                                        <th class="text-center">PO No.</th>
                                        <th class="text-center">Date</th>
                                        <th class="text-center">Distribute Quantity</th>
                                        <th class="text-center">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($distributed_products)
                                        @foreach ($distributed_products as $product_id => $product_info)
                                            @php
                                                $total_distribute_qty = array_sum(array_column($product_info, 'distribute_quantity'));
                                            @endphp
                                            @foreach ($product_info as $products)
                                                <tr>
                                                    @if ($loop->first)
                                                        <td rowspan="{{ count($product_info) }}">{{ $loop->parent->iteration }}</td>
                                                        <td rowspan="{{ count($product_info) }}">{{ $products['product'] }}</td>
                                                        <td rowspan="{{ count($product_info) }}">{{ $products['unit_name'] }}</td>
                                                    @endif
                                                    {{-- <td>{{ $products['department'] }}</td> --}}
                                                    <td>{{ $products['section'] }}</td>
                                                    <td>{{ $products['po_no'] }}</td>
                                                    <td>{{ date('d-M-Y', strtotime($products['date'])) }}</td>
                                                    <td class="text-right">{{ number_format($products['distribute_quantity'], 2, '.', ',') }}</td>
                                                    @if ($loop->first)
                                                        <td rowspan="{{ count($product_info) }}" class="align-middle text-center" style="font-weight: 600;">{{ number_format($total_distribute_qty, 2, '.', ',') }}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @endforeach
                                    @endisset
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {
            // Calculate the current date and previous 90 days
            var currentDate = new Date();
            var previousDate = new Date();
            previousDate.setDate(currentDate.getDate() - 90);

            // Format the dates as strings in the desired format (assuming 'DD-MM-YYYY' format)
            var currentDateFormatted = formatDate(currentDate);
            var previousDateFormatted = formatDate(previousDate);

            // Set default values for date_from and date_to only if they are empty
            if ($('#date_from').val() == '') {
                $('#date_from').val(previousDateFormatted);
            }
            if ($('#date_to').val() == '') {
                $('#date_to').val(currentDateFormatted);
            }

            // Initialize customdatepicker for date_from and date_to inputs
            $('.customdatepicker').daterangepicker({
                autoUpdateInput: true,
                autoclose: true,
                autoApply: true,
                singleDatePicker: true,
                showDropdowns: true,
                locale: {
                    format: 'DD-MM-YYYY',
                    daysOfWeek: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
                    firstDay: 0
                },
            });

            // Function to format date as 'DD-MM-YYYY'
            function formatDate(date) {
                var day = date.getDate();
                var month = date.getMonth() + 1; // Months are zero-based
                var year = date.getFullYear();

                // Pad day and month with leading zeros if needed
                day = day < 10 ? '0' + day : day;
                month = month < 10 ? '0' + month : month;

                return day + '-' + month + '-' + year;
            }
        });
    </script>


    <script>
        $(function() {
            $(document).on('click', '[name=type]', function(e) {
                var type = $(this).attr('value');
                if (type == 'pdf') {
                    $('#filterForm').attr('target', '_blank');
                } else {
                    $('#filterForm').removeAttr('target');
                }
            });
        })
    </script>

    <script>
        $(function() {

            $(document).on('change', '#department_id', function() {
                let department_id = $(this).val();
                console.log(department_id);
                $.ajax({
                    url: "{{ route('admin.get.sections.by.department') }}",
                    type: "GET",
                    data: {
                        department_id: department_id
                    },
                    success: function(data) {
                        console.log(data);
                        // Handle the data here
                        let section_div = document.getElementById('section_id');
                        section_div.innerHTML = '<option value="0">-- All Section --</option>';
                        data.forEach(item => {
                            section_div.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;
                        });
                    }
                });
            });

            $(document).on('change', '#product_type_id', function() {
                let product_type_id = $(this).val();
                console.log(product_type_id);
                $.ajax({
                    url: "{{ route('admin.get.products.by.type') }}",
                    type: "GET",
                    data: {
                        product_type_id: product_type_id
                    },
                    success: function(data) {
                        console.log(data);
                        // Handle the data here
                        let productInformation = document.getElementById('product_information_id');
                        productInformation.innerHTML = '<option value="0">-- All Product --</option>';
                        data.forEach(item => {
                            productInformation.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;
                        });
                    }
                });
            });
        });
    </script>

@endsection
