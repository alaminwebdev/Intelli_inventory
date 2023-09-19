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
                            <div class="row text-left mb-3">
                                <div class="col-md-12">
                                    <a href="{{ route('admin.pending.distribute.list') }}" class="btn btn-warning btn-sm" style="color: white">
                                        @if (request()->routeIs('admin.pending.distribute.list'))
                                            <i class="fa fa-check-circle"></i>
                                        @endif
                                        Pending Distribution List
                                    </a>
                                    <a href="{{ route('admin.approve.distribute.list') }}" class="btn btn-primary btn-sm" style="color: white">
                                        @if (request()->routeIs('admin.approve.distribute.list'))
                                            <i class="fa fa-check-circle"></i>
                                        @endif
                                        Distributed List
                                    </a>
                                </div>
                            </div>
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">ক্রমিক নং.</th>
                                        <th>চাহিদাপত্র নাম্বার</th>
                                        <th>অনুরোধকৃত ডিপার্টমেন্ট</th>
                                        <th>প্রোডাক্ট দেখুন</th>
                                        <th>বর্তমান অবস্থা</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($approveDistributes as $list)
                                        @php
                                            $DepartmentRequisitionDetails = \App\Models\DepartmentRequisitionDetails::join('product_information', 'product_information.id', 'department_requisition_details.product_id')
                                                ->where('department_requisition_id', $list->id)
                                                ->select('department_requisition_details.final_approve_quantity as demand_quantity', 'department_requisition_details.final_approve_remarks as remarks', 'product_information.name as product')
                                                ->get();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->department->name ?? 'N/A' }}</td>
                                            <td class="text-center">
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.requisition.report', $list->id) }}" target="_blank"><i class="fas fa-file-pdf mr-1"></i> ডাউনলোড পিডিএফ</a>
                                                <button class="btn btn-sm btn-success view-products" data-toggle="modal" data-target="#productDetailsModal" data-products="{{ json_encode($DepartmentRequisitionDetails) }}">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                            </td>
                                            <td class="text-center">{!! activeRequisition($list->status) !!}</td>
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
    <div class="modal fade" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="productDetailsModalLabel" style="font-weight: 600;color: #2a527b;text-transform: uppercase;">Product Details</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>প্রোডাক্ট</th>
                                {{-- <th>বর্তমান স্টক</th> --}}
                                <th>চাহিদার পরিমাণ</th>
                                <th>সংযুক্তি</th>
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
                var products = $(this).data('products');

                // Clear any existing content in the modal table
                $('#productDetailsTable').html('');

                // Loop through the products and add them to the table
                for (var i = 0; i < products.length; i++) {
                    var product = products[i];

                    var productName = product.product;
                    var currentStock = product.current_stock;
                    var demandQuantity = product.demand_quantity;
                    var remarks = product.remarks;

                    // Append the product details to the table
                    $('#productDetailsTable').append(`
                            <tr>
                                <td>${productName}</td>
                                <td class="text-right">${demandQuantity}</td>
                                <td >${remarks}</td>
                            </tr>
                        `);
                }
            });
        });
    </script>
@endsection
