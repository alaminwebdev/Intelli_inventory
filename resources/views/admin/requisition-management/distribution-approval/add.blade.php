@extends('admin.layouts.app')
@section('content')
    <style>
        table,
        thead,
        th,
        tr {
            color: #2a527b !important;
        }

        .swal2-icon {
            width: 4em;
            height: 4em;
            margin: 0.5em auto .5em;
        }

        .swal2-styled.swal2-confirm {
            background: linear-gradient(90deg, #5b86e5b5 0%, #36D1DC 100%) !important
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.distribution.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Approved Requisition List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.distribution.update', $editData->id) : route('admin.distribution.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row px-3 py-4 border rounded shadow-sm mb-3">
                                            <div class="col-md-2">
                                                <input type="hidden" value="{{ $editData->id }}" name="section_requisition_id">
                                                <label class="control-label">Requisition No. :</label>
                                                <input type="text" class="form-control form-control-sm" id="remarks" name="requisition_no" value="{{ $editData->requisition_no }}" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label">Department : <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="department_id" name="department_id" value="{{ $editData->section->department->name }}" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label">Section : <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="section_id" name="section_id" value="{{ $editData->section->name }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="accordion">
                                            @foreach ($requisition_product_types as $type)
                                                <div class="card" style="box-shadow: none;">
                                                    <div class="card-header rounded shadow-sm border-0" data-toggle="collapse" data-target="#collapse-{{ $type['id'] }}" aria-expanded="true" aria-controls="collapse-{{ $type['id'] }}" style="cursor: pointer;padding: 2px 10px; background: linear-gradient(90deg, #5b86e5b5 0%, #36D1DC 100%) !important;">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link px-0 text-white" type="button">{{ $type['name'] }}</button>
                                                        </h5>
                                                        <i class="fas fa-chevron-down text-white"></i>
                                                    </div>

                                                    <div id="collapse-{{ $type['id'] }}" class="collapse show">
                                                        <div class="card-body ">
                                                            <table id="" class="table table-bordered">
                                                                <thead style="background: #fff4f4 !important;">
                                                                    <tr>
                                                                        <th>Product</th>
                                                                        <th>Previous Distribute Qty.</th>
                                                                        <th>Section Current Stock</th>
                                                                        <th>Demand Quantity</th>
                                                                        <th>Recommended Quantity</th>
                                                                        <th>Verify Quantity</th>
                                                                        <th>Distributable Quantity</th>
                                                                        <th>Approve Quantity</th>
                                                                        <th>Remark</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($type['products'] as $product)
                                                                        <tr data-product-id="{{ $product['product_id'] }}" class="approved_table">
                                                                            <td class="product-name">{{ $product['product_name'] }}</td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="previous_stock_{{ $product['product_id'] }}" value="{{ $product['last_distribute_qty'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="current_stock_{{ $product['product_id'] }}" name="current_stock[{{ $product['product_id'] }}]" value="{{ $product['current_stock'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="demand_quantity_{{ $product['product_id'] }}" name="demand_quantity[{{ $product['product_id'] }}]" value="{{ $product['demand_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm recommended_quantity" id="recommended_quantity_{{ $product['product_id'] }}" name="recommended_quantity[{{ $product['product_id'] }}]" value="{{ $product['recommended_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm verify_quantity" id="verify_quantity_{{ $product['product_id'] }}" name="verify_quantity[{{ $product['product_id'] }}]" value="{{ $product['verify_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm available_quantity" id="available_quantity_{{ $product['product_id'] }}" value="{{ $product['available_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm approve_quantity" id="approve_quantity_{{ $product['product_id'] }}" name="approve_quantity[{{ $product['product_id'] }}]" value="{{ $product['final_approve_quantity'] ?? $product['verify_quantity'] }}" {{ $editData->status == 3 ? 'readonly' : '' }}>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm" id="remarks_{{ $product['product_id'] }}" name="remarks[{{ $product['product_id'] }}]" value="{{ $product['final_approve_remarks'] }}" {{ $product['final_approve_remarks'] ? 'readonly' : '' }}>
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="text-right">
                                            @if (@$editData->id)
                                                <button type="submit" class="btn btn-success btn-sm" {{ $editData->status == 3 ? 'disabled' : '' }}>Approve</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                                <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.distribution.list') }}">Back</a>
                                            </button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(function() {
            $(document).on('keyup', '.approve_quantity', function() {
                var approvedQuantity = parseInt($(this).val());

                var availableQuantity = parseInt($(this).parents('.approved_table').find(
                    '.available_quantity').val());

                if (approvedQuantity > availableQuantity) {
                    $(this).val(availableQuantity);

                    //alert('Approved quantity cannot exceed the Recommended quantity.');
                    Swal.fire({
                        icon: "warning",
                        // customClass: {
                        //     popup: 'colored-toast'
                        // },
                        // iconColor: 'white',
                        title: "The Approved quantity cannot exceed the disbursement amount.",
                        toast: false,
                        // position: 'top-end',
                        showConfirmButton: true,
                        // timer: 3000,
                        timerProgressBar: false
                    });
                }
            });
        })
    </script>

    <script>
        function validateForm() {

            const approveQtyInputs = document.querySelectorAll('.approve_quantity');

            // Flag to track whether validation passes
            var isValid = true;

            // Remove .is-invalid class from all inputs
            approveQtyInputs.forEach(function(approveQtyInput) {
                approveQtyInput.classList.remove('is-invalid');
            });

            // Handle the case when receive_qty inputs are empty
            approveQtyInputs.forEach(function(approveQtyInput) {

                const parentRow = approveQtyInput.closest('tr');
                const availableQtyInput = parentRow.querySelector('.available_quantity');

                const availableQty = parseFloat(availableQtyInput.value) || 0;
                const approveQty = parseFloat(approveQtyInput.value) || 0;

                // Validate that receive_qty is not greater than invoice_qty
                if (approveQty > availableQty) {
                    showAlert('error', 'Fill all required fields.');
                    approveQtyInput.classList.add('is-invalid');
                    //approveQtyInput.setCustomValidity("অনুমোদিত পরিমাণ বিতরনের পরিমাণের বেশি হতে পারবে না।");
                    isValid = false;
                } else {
                    //approveQtyInput.setCustomValidity("");
                    approveQtyInput.classList.remove('is-invalid');
                }
            });

            return isValid;
        }

        function showAlert(type, message) {
            Swal.fire({
                toast: true,
                customClass: {
                    popup: 'colored-toast'
                },
                iconColor: 'white',
                icon: type,
                title: message,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const submitForm = document.getElementById('submitForm');

            submitForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (validateForm()) {
                    // If form validation passes, submit the form
                    submitForm.submit();
                }
            });
        });
    </script>
@endsection
