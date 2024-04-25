@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>

                        </div>
                        <div class="card-body">
                            <form method="get" action="" id="filterForm">
                                @csrf
                                <div class="gradient-border px-3 pt-4 pb-3 mb-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="control-label" style="color:#2a527b;">Requisition Type</label>
                                            <select class="form-select form-select-sm select2" name="requisition_status" id="requisition_status">
                                                <option value="3">Approved Requisitions</option>
                                                <option value="4">Distributed Requisitions</option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="date_from" class="text-navy">Start Date :</label>
                                            <input type="text" value="" name="date_from" class="form-control form-control-sm text-gray customdatepicker" id="date_from" placeholder="Start Date">
                                        </div>
                                        <div class="form-group col-md-2">
                                            <label for="date_to" class="text-navy">End Date :</label>
                                            <input type="text" value="" name="date_to" class="form-control form-control-sm text-gray customdatepicker" id="date_to" placeholder="End Date">
                                        </div>
                                        <div class="form-group col-sm-5">
                                            <label class="control-label d-block" style="visibility: hidden;">Search</label>
                                            <button type="submit" class="btn btn-success btn-sm" name="type" value="search" style="box-shadow:rgba(40, 167, 69, 0.30) 0px 8px 18px 4px;"><i class="fas fa-search mr-1"></i>Search</button>
                                            <button type="submit" class="btn btn-sm btn-primary mr-1" name="type" value="pdf" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px"><i class="fas fa-file-pdf mr-1"></i>Download as PDF</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th>Requisition No.</th>
                                        <th>Requested Section</th>
                                        <th>Requested Department</th>
                                        <th>Status</th>
                                        <th id="requisition_date">Date</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="requistionProductsTable">
                                    {{-- @foreach ($distributeRequisitions as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->section->name ?? 'N/A' }}</td>
                                            <td>{{ @$list->section->department->name ?? 'N/A' }}</td>
                                            <td class="text-center">{!! requisitionStatus($list->status) !!}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success btn-info view-products" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id="{{ $list->id }}" data-modal-id="productDetailsModal">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.requisition.report', $list->id) }}" target="_blank"><i class="fas fa-file-pdf mr-1"></i> পিডিএফ</a>
                                                @if ($list->status === 3)
                                                    @if (sorpermission('admin.distribute.edit'))
                                                        <a class="btn btn-sm btn-success" href="{{ route('admin.distribute.edit', $list->id) }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach --}}
                                </tbody>
                            </table>
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
                    <h6 class="modal-title" id="productDetailsModalLabel" style="font-weight: 600;color: #2a527b;text-transform: uppercase;">Product Detail - Requisition No. (<span class="requisitionInfo"></span>)</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Current Stock</th>
                                <th>Demand Quantity</th>
                                <th>Recommended Quantity</th>
                                <th>Verify Quantity</th>
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
            $(document).on('click', '.view-products', function() {
                var requistionID = $(this).data('requisition-id');
                var modalID = $(this).data('modal-id');
                console.log(requistionID);

                document.getElementById('loading-spinner').style.display = 'block';
                $.ajax({
                    url: "{{ route('admin.get.requistion.details.by.id') }}",
                    type: "GET",
                    data: {
                        requisition_id: requistionID
                    },
                    success: function(products) {
                        // Clear any existing content in the modal table
                        $('#' + modalID + ' #productDetailsTable').html('');

                        var requisitionNo;

                        // Loop through the products and add them to the table
                        for (var i = 0; i < products.length; i++) {
                            var product = products[i];

                            var productName = product.product || "";
                            var unitName = product.unit || "";
                            var currentStock = product.current_stock || "";
                            var demandQuantity = product.demand_quantity || "";
                            var recommendedQuantity = product.recommended_quantity || "";
                            var verifyQuantity = product.verify_quantity || "";
                            var finalApproveQuantity = product.final_approve_quantity || "";
                            var remarks = product.remarks || "";

                            // Append the product details to the table
                            $('#' + modalID + ' #productDetailsTable').append(`
                                <tr>
                                    <td>${productName} (${unitName})</td>
                                    <td class="text-right">${currentStock}</td>
                                    <td class="text-right">${demandQuantity}</td>
                                    <td class="text-right">${recommendedQuantity}</td>
                                    <td class="text-right">${verifyQuantity}</td>
                                    <td class="text-right">${finalApproveQuantity}</td>
                                    <td>${remarks}</td>
                                </tr>
                            `);

                            requisitionNo = product.requisition_no;
                        }

                        // Update the content
                        $('#' + modalID + ' .requisitionInfo').text(requisitionNo || "");

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

    <script>
        $(document).ready(function() {
            // Calculate the current date and previous 180 days
            var currentDate = new Date();
            var previousDate = new Date();
            previousDate.setDate(currentDate.getDate() - 180);

            // Format the dates as strings in the desired format (assuming 'DD-MM-YYYY' format)
            var currentDateFormatted = formatDate(currentDate);
            var previousDateFormatted = formatDate(previousDate);

            // Set default values for date_from and date_to
            $('#date_from').val(previousDateFormatted);
            $('#date_to').val(currentDateFormatted);

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
        $(document).ready(function() {
            var dTable = $('#data-table').DataTable({
                language: {
                    // url: '//cdn.datatables.net/plug-ins/2.0.2/i18n/bn.json',
                },
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('admin.get.distributed.requisition.list.datatable') }}',
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.requisition_status = $('select[name=requisition_status]').val();
                        d.from_date = $('input[name=date_from]').val();
                        d.to_date = $('input[name=date_to]').val();
                    }
                },
                lengthMenu: [25, 50, 100, 150], // Set the default entries and available options
                pageLength: 25, // Set the default page length
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id',
                        orderable: false
                    },
                    {
                        data: 'requisition_no',
                        name: 'requisition_no'
                    },
                    {
                        data: 'section',
                        name: 'section'
                    },
                    {
                        data: 'department',
                        name: 'department'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action_column',
                        name: 'action_column'
                    }
                ],
                createdRow: function(row, data, dataIndex) {
                    // Add a class to the 'action_column' cell in each row
                    $('td:eq(6)', row).addClass('text-center');
                }
            });

            $('#filterForm').on('submit', function(e) {
                //dTable.draw();
                e.preventDefault();

                var selectedValue = $('#requisition_status').val();

                // Get the TH element containing the date column header
                var dateColumnHeader = $('#requisition_date');

                // Check the selected value and update the header text accordingly
                if (selectedValue == 3) {
                    dateColumnHeader.text('Approved Date');
                } else {
                    dateColumnHeader.text('Distributed Date');
                }

                // Check which button is clicked
                var buttonType = $(document.activeElement).val();

                if (buttonType === 'search') {
                    // Perform search action
                    dTable.draw();
                } else if (buttonType === 'pdf') {
                    // Submit the form with POST method
                    $(this).attr('method', 'post');
                    $(this).attr('action', '{{ route('admin.get.requisition.list.in.pdf') }}');
                    $(this).attr('target', '_blank');
                    this.submit();
                    
                }

            });

        });
    </script>
@endsection
