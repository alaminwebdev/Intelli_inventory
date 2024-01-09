@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            {{-- <a href="{{ route('admin.department.requisition.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Department Requisition</a> --}}
                        </div>
                        <div class="card-body">
                            <div class="row text-left mb-3">
                                <div class="col-md-12">
                                    <a class="btn btn-info btn-sm reqListBtn" data-requistition-status="0">
                                        <i class="fa fa-check-circle"></i>
                                        সুপারিশের অপেক্ষায় চাহিদাপত্রের তালিকা
                                    </a>
                                    <a class="btn btn-primary btn-sm reqListBtn" data-requistition-status="1,2,3,4,5">
                                        <i class="fa "></i>
                                        সুপারিশ করা চাহিদাপত্রের তালিকা
                                    </a>
                                </div>
                            </div>
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং.</th>
                                        <th>চাহিদাপত্র নাম্বার</th>
                                        <th>অনুরোধকৃত শাখা</th>
                                        <th>অনুরোধকৃত দপ্তর</th>
                                        <th>বর্তমান অবস্থা</th>
                                        <th width="20%">অ্যাকশন</th>
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
                                                <button class="btn btn-sm btn-info view-products" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id="{{ $list->id }}" data-modal-id="productDetailsModal">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.requisition.report', $list->id) }}" target="_blank"><i class="fas fa-file-pdf mr-1"></i>পিডিএফ</a>
                                                @if (sorpermission('admin.recommended.requisition.edit'))
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.recommended.requisition.edit', $list->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                {{-- @if (sorpermission('admin.requisition.delete'))
                                                <a class="btn btn-sm btn-danger destroy" data-id="{{$list->id}}" data-route="{{route('admin.requisition.delete')}}">
                                                    <i class="fa fa-trash"></i>
                                                </a>
                                                @endif --}}
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

    <script>
        $(document).ready(function() {
            $('.reqListBtn').on('click', function() {
                var $clickedButton = $(this); // Store a reference to the clicked button
                var requistitionStatus = $clickedButton.data('requistition-status');

                if (Array.isArray(requistitionStatus)) {
                    // It's already an array, no need to do anything
                } else if (typeof requistitionStatus === 'string' && requistitionStatus.includes(',')) {
                    requistitionStatus = requistitionStatus.split(',').map(Number);
                } else {
                    requistitionStatus = [Number(requistitionStatus)];
                }

                console.log(requistitionStatus);
                document.getElementById('loading-spinner').style.display = 'block';
                $.ajax({
                    url: "{{ route('admin.get.requistion.by.status.for.recommender') }}",
                    type: "GET",
                    data: {
                        requistition_status: requistitionStatus
                    },
                    success: function(response) {

                        // Clear existing table rows
                        $("#requistionProductsTable").empty();
                        $("#requistionProductsTable").html(response);
                        document.getElementById('loading-spinner').style.display = 'none';

                        // Remove the class from all buttons
                        $('.reqListBtn i').removeClass('fa-check-circle');

                        // Add the class to the checkbox icon of the clicked button
                        $clickedButton.find('i').addClass('fa-check-circle');
                    },
                    error: function(error) {
                        document.getElementById('loading-spinner').style.display = 'none';
                        console.error("Error:", error);

                    }
                });
            });

        });
    </script>

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
