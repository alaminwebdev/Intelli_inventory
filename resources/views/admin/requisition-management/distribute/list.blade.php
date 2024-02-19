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
                            {{-- <div class="row text-left mb-3">
                                <div class="col-md-12">
                                    <a class="btn btn-info btn-sm distributeListBtn" data-requistition-status="3">
                                        <i class="fa fa-check-circle"></i>
                                        বিতরণের অপেক্ষায় চাহিদাপত্রের তালিকা
                                    </a>
                                    <a class="btn btn-primary btn-sm distributeListBtn" data-requistition-status="4">
                                        <i class="fa "></i>
                                        বিতরণ করা চাহিদাপত্রের তালিকা
                                    </a>
                                </div>
                            </div> --}}
                            <form method="get" action="" id="filterForm">
                                <div class="form-row border-bottom mb-3">
                                    <div class="form-group col-sm-3">
                                        <label class="control-label" style="color:#2a527b;">চাহিদাপত্রের ধরন</label>
                                        <select class="form-select form-select-sm select2" name="requisition_status" id="requisition_status">
                                            <option value="3">বিতরণের অপেক্ষায় চাহিদাপত্রের তালিকা</option>
                                            <option value="4">বিতরণ করা চাহিদাপত্রের তালিকা</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <label class="control-label" style="visibility: hidden;">Search</label>
                                        <button type="submit" class="btn btn-success btn-sm btn-block" style="font-weight:600">খুঁজুন</button>
                                    </div>
                                </div>
                            </form>
                            <table id="data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং.</th>
                                        <th>চাহিদাপত্র নাম্বার</th>
                                        <th>অনুরোধকৃত শাখা</th>
                                        <th>অনুরোধকৃত দপ্তর</th>
                                        <th>বর্তমান অবস্থা</th>
                                        <th>তারিখ</th>
                                        <th>অ্যাকশন</th>
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

    <script>
        $(document).ready(function() {
            var dTable = $('#data-table').DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                ajax: {
                    url: '{{ route('admin.get.distributed.requisition.list.datatable') }}',
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.requisition_status = $('select[name=requisition_status]').val();
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'id'
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
                dTable.draw();
                e.preventDefault();
            });

        });
    </script>

    {{-- <script>
        $(document).ready(function() {
            $('.distributeListBtn').on('click', function() {
                var $clickedButton = $(this); 
                var requistitionStatus = $(this).data('requistition-status');
                document.getElementById('loading-spinner').style.display = 'block';
                $.ajax({
                    url: "{{ route('admin.get.distribute.requistion.by.status') }}",
                    type: "GET",
                    data: {
                        requistition_status: requistitionStatus
                    },
                    success: function(response) {

                        // Clear existing table rows
                        $("#requistionProductsTable").empty();
                        $("#requistionProductsTable").html(response);
                        
                        // Remove the class from all buttons
                        $('.distributeListBtn i').removeClass('fa-check-circle');

                        // Add the class to the checkbox icon of the clicked button
                        $clickedButton.find('i').addClass('fa-check-circle');

                        document.getElementById('loading-spinner').style.display = 'none';
                    },
                    error: function(error) {
                        document.getElementById('loading-spinner').style.display = 'none';
                        console.error("Error:", error);

                    }
                });
            });

        });
    </script> --}}

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
                        <thead>
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
                            $('#' + modalID + ' #productDetailsTable').append(`
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
