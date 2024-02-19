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
                                <div class="form-row border-bottom mb-3">
                                    <div class="form-group col-sm-3">
                                        <label class="control-label" style="color:#2a527b;">চাহিদাপত্রের ধরন</label>
                                        <select class="form-select form-select-sm select2" name="requisition_status" id="requisition_status">
                                            <option value="1">যাচাইয়ের অপেক্ষায় চাহিদাপত্রের তালিকা</option>
                                            <option value="3,4,6">যাচাইকৃত চাহিদাপত্রের তালিকা</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-1">
                                        <label class="control-label" style="visibility: hidden;">Search</label>
                                        <button type="submit" class="btn btn-success btn-sm btn-block" style="font-weight:600">খুঁজুন</button>
                                    </div>
                                </div>
                            </form>
                            <table id="data-table" class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং.</th>
                                        <th>চাহিদাপত্র নাম্বার</th>
                                        <th>অনুরোধকৃত শাখা</th>
                                        <th>অনুরোধকৃত দপ্তর</th>
                                        <th>বর্তমান অবস্থা</th>
                                        <th>চাহিদাপত্রের তারিখ</th>
                                        <th>অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody id="requistionProductsTable">

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
                    url: '{{ route('admin.get.verified.requisition.list.datatable') }}',
                    data: function(d) {
                        d._token = "{{ csrf_token() }}";
                        d.requisition_status = $('select[name=requisition_status]').val();
                    }
                },
                lengthMenu: [25, 50, 100, 150], // Set the default entries and available options
                pageLength: 25, // Set the default page length
                columns: [
                    {
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
                dTable.draw();
                e.preventDefault();
            });

        });
    </script>

    <!-- Modal for Product Details -->
    <div class="modal" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title" id="productDetailsModalLabel" style="font-weight: 600;color: #2a527b;text-transform: uppercase;">পন্যের বিবরনী - চাহিদাপত্র নাম্বার (<span class="requisitionInfo"></span>)</h6>
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
                    <div class="d-flex justify-content-end">
                        <a href="#" target="_blank" class="edit-link btn btn-sm btn-warning mr-1"><i class="fas fa-edit"></i> পরিবর্তন করে যাচাই করুন</a>
                        <a class="btn btn-sm btn-success requisition-verify" data-id="" data-route=""> <i class="fas fa-check-double"></i> পরিবর্তন ছাড়াই যাচাই করুন</a>
                    </div>
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

                document.getElementById('loading-spinner').style.display = 'block';

                
                // Update Edit link and requisition verify with dynamically generated routes
                var editRoute = "{{ route('admin.verified.requisition.edit', ['id' => ':requisitionID']) }}".replace(':requisitionID', requistionID);
                var editLink = $('#' + modalID + ' .edit-link');
                editLink.attr('href', editRoute);

                var requisitionVerifyLink = $('#' + modalID + ' .requisition-verify');
                requisitionVerifyLink.attr('data-id', requistionID);
                requisitionVerifyLink.attr('data-route', "{{ route('admin.verified.requisition.confirm') }}");


                $.ajax({
                    url: "{{ route('admin.get.requistion.details.by.id') }}",
                    type: "GET",
                    data: {
                        requisition_id: requistionID
                    },
                    success: function(products) {
                        // Clear any existing content in the modal table
                        $('#' + modalID + ' #productDetailsTable').html('');

                        var productStatus;
                        var requisitionNo;

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

                            productStatus = product.status;
                            requisitionNo = product.requisition_no;
                        }

                        if (productStatus == 1) {
                            editLink.show();
                            requisitionVerifyLink.show();
                        } else {
                            editLink.hide();
                            requisitionVerifyLink.hide();
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
        $(document).on('click', '.requisition-verify', function() {
            var thisBtn = $(this);
            var url = $(thisBtn).data('route');
            var id = $(thisBtn).data('id');

            Swal.fire({
                icon: 'info',
                iconHtml: '<i class="fas fa-check p-3"></i>',
                title: 'পরিবর্তন ছাড়াই যাচাই করুন',
                showCancelButton: true,
                confirmButtonText: `<i class="fa fa-thumbs-up"></i> হ্যাঁ !`,
                cancelButtonText: `<i class="fa fa-thumbs-down"></i> না, বাতিল করুন!`,
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    return $.ajax({
                            'url': url,
                            'type': 'POST',
                            'data': {
                                _token: $('[name=csrf-token]').attr('content'),
                                id: id
                            },
                        }).then(response => {
                            console.log(response);
                            if (response.status != 'success') {
                                throw new Error(response.message)
                            }
                            return response;
                        })
                        .catch(error => {
                            Swal.showValidationMessage(error.message ? error.message : error.responseJSON.message)
                        })
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                console.log(result);
                if (result.isConfirmed) {
                    Swal.fire({
                        icon: "success",
                        title: 'সফলভাবে যাচাই করা হয়েছে',
                    }).then(() => {
                        // Reload the page
                        location.reload();
                    });
                    // $(thisBtn).parents('tr').hide('');

                }
            });
        });
    </script>
@endsection
