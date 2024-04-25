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
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th>Requisition No.</th>
                                        <th>Requested Section</th>
                                        <th>Requested Department</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="requistionProductsTable">
                                    @foreach ($sectionRequisitions as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->section->name ?? 'N/A' }}</td>
                                            <td>{{ @$list->section->department->name ?? 'N/A' }}</td>
                                            <td class="text-center">{!! requisitionStatus($list->status) !!}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success view-products" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id="{{ $list->id }}" data-modal-id="productDetailsModal">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.requisition.report', $list->id) }}" target="_blank"><i class="fas fa-file-pdf mr-1"></i> পিডিএফ</a>
                                                @if ($list->status === 4)
                                                    @if (sorpermission('admin.section.requisition.receive.edit'))
                                                        <a class="btn btn-sm btn-success" href="{{ route('admin.section.requisition.receive.edit', $list->id) }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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
                    <h6 class="modal-title" id="productDetailsModalLabel" style="font-weight: 600;color: #2a527b;text-transform: uppercase;">Product Detail</h6>
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
