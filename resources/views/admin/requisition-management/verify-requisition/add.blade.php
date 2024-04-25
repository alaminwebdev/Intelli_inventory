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
                            <a href="{{ route('admin.verified.requisition.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Verified Requisitions</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.verified.requisition.update', $editData->id) : '' }} " method="post" enctype="multipart/form-data" autocomplete="off">
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
                                                                        <th>Distributable Quantity</th>
                                                                        <th>Verify Quantity</th>
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
                                                                                <input type="text" class="form-control form-control-sm available_quantity" id="available_quantity_{{ $product['product_id'] }}" value="{{ $product['available_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm verify_quantity" id="verify_quantity_{{ $product['product_id'] }}" name="verify_quantity[{{ $product['product_id'] }}]" value="{{ $product['verify_quantity'] ?? $product['recommended_quantity'] }}" {{ $editData->status == 6 ? 'readonly' : '' }}>
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
                                                <button type="submit" class="btn btn-success btn-sm" {{ $editData->status == 6 ? 'disabled' : '' }}>Verify</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                                <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.verified.requisition.list') }}">Back</a>
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
            $(document).on('keyup', '.verify_quantity', function() {
                var verifyQuantity = parseInt($(this).val());

                var availableQuantity = parseInt($(this).parents('.approved_table').find(
                    '.available_quantity').val());

                if (verifyQuantity > availableQuantity) {
                    $(this).val(availableQuantity);

                    Swal.fire({
                        icon: "warning",
                        title: "The verification quantity cannot exceed the distribution quantity.",
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

            const verifyQtyInputs = document.querySelectorAll('.verify_quantity');

            // Flag to track whether validation passes
            var isValid = true;

            // Remove .is-invalid class from all inputs
            verifyQtyInputs.forEach(function(verifyQtyInput) {
                verifyQtyInput.classList.remove('is-invalid');
            });

            // Handle the case when receive_qty inputs are empty
            verifyQtyInputs.forEach(function(verifyQtyInput) {

                const parentRow = verifyQtyInput.closest('tr');
                const availableQtyInput = parentRow.querySelector('.available_quantity');

                const availableQty = parseFloat(availableQtyInput.value) || 0;
                const verifyQty = parseFloat(verifyQtyInput.value) || 0;

                if (verifyQty > availableQty) {
                    showAlert('error', 'Fill all required fields.');
                    verifyQtyInput.classList.add('is-invalid');
                    isValid = false;
                } else {
                    verifyQtyInput.classList.remove('is-invalid');
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
