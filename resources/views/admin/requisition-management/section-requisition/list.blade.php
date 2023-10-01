@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            {{-- <a href="{{ route('admin.section.requisition.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> চাহিদাপত্র যুক্ত করুন</a> --}}
                            <a href="{{ route('admin.section.requisition.product.selection') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> চাহিদাপত্র যুক্ত করুন</a>
                        </div>
                        <div class="card-body">

                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং.</th>
                                        <th>চাহিদাপত্র নাম্বার</th>
                                        <th>অনুরোধকৃত শাখা</th>
                                        <th>অনুরোধকৃত দপ্তর</th>
                                        <th>বর্তমান অবস্থা</th>
                                        <th>অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectionRequisitions as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->section->name ?? 'N/A' }}</td>
                                            <td>{{ @$list->section->department->name ?? 'N/A' }}</td>
                                            <td class="text-center">{!! requisitionStatus($list->status) !!}</td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-success view-products" data-toggle="modal" data-target="#productDetailsModal" data-requisition-id="{{ $list->id }}">
                                                    <i class="far fa-eye"></i>
                                                </button>
                                                <a class="btn btn-sm btn-primary" href="{{ route('admin.requisition.report', $list->id) }}" target="_blank"><i class="fas fa-file-pdf mr-1"></i> পিডিএফ</a>
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
@endsection
