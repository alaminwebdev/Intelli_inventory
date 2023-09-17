@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.stock.in.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Stock</a>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">SL.</th>
                                        <th>GRN No</th>
                                        <th>Entry Date</th>
                                        <th>Challan No</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        {{-- <th width="15%" class="text-center">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_in_data as $list)
                                        @php
                                            $stockInProducts = \App\Models\StockInDetail::join('product_information', 'product_information.id', 'stock_in_details.product_information_id')
                                                ->where('stock_in_id', $list->id)
                                                ->select('stock_in_details.receive_qty as receive_qty', 'stock_in_details.available_qty as available_qty', 'stock_in_details.reject_qty as reject_qty', 'product_information.name as product')
                                                ->get();
                                            
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->grn_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->entry_date ? date('d-M-Y', strtotime($list->entry_date)) : 'N/A' }}</td>
                                            <td>{{ @$list->challan_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->supplier ?? 'N/A' }}</td>
                                            <td>{!! activeStock($list->status) !!}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success view-products" data-toggle="modal" data-target="#productDetailsModal" data-products="{{ json_encode($stockInProducts) }}">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                                @if ($list->status == 0)
                                                    <a class="btn btn-sm btn-success " href="{{ route('admin.stock.in.active', $list->id) }}">
                                                       <i class="fa fa-check"></i> Approve
                                                    </a>
                                                @endif
                                            </td>
                                            {{-- <td class="text-center">

												@if (sorpermission('admin.product.receive.information.edit'))
												<a class="btn btn-sm btn-success" href="{{route('admin.product.receive.information.edit',$list->id)}}">
													<i class="fa fa-edit"></i>
												</a>
												@endif
												@if (sorpermission('admin.supplier.delete'))
												<a class="btn btn-sm btn-danger destroy" data-id="{{$list->id}}" data-route="{{route('admin.supplier.delete')}}">
													<i class="fa fa-trash"></i>
												</a>
												@endif
											</td> --}}
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
                                <th>Product</th>
                                <th>Receive Qty</th>
                                <th>Available Qty</th>
                                <th>Reject Qty</th>
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
                    var receiveQuantity = product.receive_qty;
                    var availableQuantity = product.available_qty;
                    var rejectQuantity = product.reject_qty;

                    // Append the product details to the table
                    $('#productDetailsTable').append(`
                            <tr>
                                <td>${productName}</td>
                                <td class="text-right">${receiveQuantity}</td>
                                <td class="text-right">${availableQuantity}</td>
                                <td>${rejectQuantity}</td>
                            </tr>
                        `);
                }
            });
        });
    </script>
@endsection
