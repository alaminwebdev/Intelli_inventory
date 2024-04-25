@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.stock.in.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Stock List</a>
                        </div>
                        <div class="card-body">
                            <form id="stockInForm" method="post" action="{{ route('admin.stock.in.store') }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row border-bottom">
                                            <div class="form-group col-md-4">
                                                <label class="control-label">G.R.N. <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm grn_no @error('grn_no') is-invalid @enderror" id="grn_no" name="grn_no" value="{{ $uniqueGRNNo }}" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Entry Date <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm entry_date @error('entry_date') is-invalid @enderror singledatefromtoday" id="entry_date" name="entry_date">
                                                @error('entry_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Challan No. <span class="text-red">*</span></label>
                                                <input type="number" class="form-control form-control-sm challan_no @error('challan_no') is-invalid @enderror" id="challan_no" name="challan_no" value="{{ @$editData->challan_no }}">
                                                @error('challan_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Supplier <span class="text-red">*</span></label>
                                                <select name="supplier_id" id="supplier_id" class="form-control form-control-sm">
                                                    <option value="">Please Select</option>
                                                    @foreach ($suppliers as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->supplier_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">PO No. <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm " id="po_no" name="po_no" value="{{ $selected_po_no }}" readonly>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">PO Date <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm singledatepicker" id="" name="" @if ($selected_po_date) value="{{ date('d-m-Y', strtotime($selected_po_date)) }}" @endif disabled>
                                                <input type="hidden" name="po_date" value="{{ $selected_po_date }}">
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <table id="" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:20%;">Product</th>
                                                        <th>PO Quantity</th>
                                                        <th>Receive Quantity</th>
                                                        <th>Remaining Quantity</th>
                                                        <th>Date of manufacture</th>
                                                        <th>Expiry Date</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($selected_products as $product)
                                                        <tr data-product-id="{{ $product->id }}">
                                                            <td class="product-name">{{ $product->name }}({{ $product->unit->name }})</td>
                                                            <td>
                                                                <input type="number" class="form-control form-control-sm po_qty @error('po_qty') is-invalid @enderror" id="po_qty_{{ $product->id }}" name="po_qty[{{ $product->id }}]" data-product-id="{{ $product->id }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control form-control-sm receive_qty @error('receive_qty') is-invalid @enderror " id="receive_qty_{{ $product->id }}" name="receive_qty[{{ $product->id }}]" data-product-id="{{ $product->id }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control form-control-sm reject_qty @error('reject_qty') is-invalid @enderror" id="reject_qty_{{ $product->id }}" name="reject_qty[{{ $product->id }}]" data-product-id="{{ $product->id }}" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm @error('mfg_date') is-invalid @enderror singledatepicker" id="mfg_date_{{ $product->id }}" name="mfg_date[{{ $product->id }}]" data-product-id="{{ $product->id }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm @error('expire_date') is-invalid @enderror singledatefromtoday" id="expire_date_{{ $product->id }}" name="expire_date[{{ $product->id }}]" data-product-id="{{ $product->id }}">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control form-control-sm @error('remarks') is-invalid @enderror" id="remarks_{{ $product->id }}" name="remarks[{{ $product->id }}]" data-product-id="{{ $product->id }}" rows="1"></textarea>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="text-right">
                                            @if (@$editData->id)
                                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.stock.in.product.selection') }}">Back</a>
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
        // Get references to the input fields
        const poQtyInputs = document.querySelectorAll(".po_qty");
        const receiveQtyInputs = document.querySelectorAll(".receive_qty");
        const rejectQtyInputs = document.querySelectorAll(".reject_qty");

        // Add event listeners to detect changes for each set of inputs
        for (let i = 0; i < poQtyInputs.length; i++) {
            poQtyInputs[i].addEventListener("input", updateRejectQty);
            receiveQtyInputs[i].addEventListener("input", updateRejectQty);
        }

        // Function to update the reject_qty fields based on input values
        function updateRejectQty() {
            for (let i = 0; i < poQtyInputs.length; i++) {
                const invoiceQtyInput = poQtyInputs[i];
                const receiveQtyInput = receiveQtyInputs[i];
                const rejectQtyInput = rejectQtyInputs[i];

                const invoiceQty = parseFloat(invoiceQtyInput.value) || 0;
                const receiveQty = parseFloat(receiveQtyInput.value) || 0;

                // Validate that receive_qty is not greater than invoice_qty
                if (receiveQty > invoiceQty) {
                    receiveQtyInput.setCustomValidity("Receive quantity cannot be greater than PO quantity.");
                } else {
                    receiveQtyInput.setCustomValidity(""); // Clear any validation message
                }

                // Calculate reject_qty based on your logic
                let rejectQty = invoiceQty - receiveQty;

                // Ensure reject_qty is not negative
                if (rejectQty < 0) {
                    rejectQty = 0; // Set to zero if negative
                }

                // Update the reject_qty input field
                rejectQtyInput.value = rejectQty;
            }
        }
    </script>

    <script>
        function validateForm() {
            // Reset any previous validation error messages
            $('.is-invalid').removeClass('is-invalid');

            // Flag to track whether validation passes
            var isValid = true;

            // Validate common fields
            var entryDate = $('#entry_date').val().trim();
            var challanNo = $('#challan_no').val().trim();
            var supplierId = $('#supplier_id').val();

            if (entryDate === '') {
                $('#entry_date').addClass('is-invalid');
                isValid = false;
            }

            if (challanNo === '') {
                $('#challan_no').addClass('is-invalid');
                isValid = false;
            }

            if (supplierId === '') {
                $('#supplier_id').addClass('is-invalid');
                isValid = false;
            }

            // Validate product-specific fields
            $('.po_qty').each(function() {
                var productId = $(this).data('product-id');
                var poQty = $(this).val().trim();
                var receiveQty = $('#receive_qty_' + productId).val().trim();

                if (poQty === '') {
                    $(this).addClass('is-invalid');
                    isValid = false;
                }

                if (receiveQty === '') {
                    $('#receive_qty_' + productId).addClass('is-invalid');
                    isValid = false;
                }

                // You can add more specific validation rules for mfg_date, expire_date, and remarks here

            });

            return isValid;
        }
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stockInForm = document.getElementById('stockInForm');
            const receiveQtyInputs = document.querySelectorAll('.receive_qty');


            stockInForm.addEventListener('submit', function(e) {
                e.preventDefault();

                if (validateForm()) {
                    // Serialize form data
                    const formData = new FormData(stockInForm);
                    document.getElementById('loading-spinner').style.display = 'block';

                    // Perform AJAX form submission
                    $.ajax({
                        type: 'POST',
                        url: "{{ route('admin.stock.in.store') }}",
                        data: formData,
                        processData: false,
                        contentType: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);
                            var result = response.original;
                            document.getElementById('loading-spinner').style.display = 'none';

                            if (result.success && result.success.trim() !== "") {
                                console.log("Success message:", result.success);
                                showAlert('success', result.success);
                                setTimeout(function() {
                                    location.href = "{{ route('admin.stock.in.list') }}";
                                }, 1000);
                            } else if (result.error) {
                                console.log("Error message:", result.error);
                                showAlert('error', result.error);
                            } else {
                                console.log("Unexpected response:", result);
                            }
                        },
                        error: function(error) {
                            document.getElementById('loading-spinner').style.display = 'none';
                            // Parse the JSON error response
                            let errorResponse = JSON.parse(error.responseText);
                            console.error("Error:", errorResponse);

                            if (errorResponse && errorResponse.errors) {
                                const validationErrors = errorResponse.errors;
                                const errorFields = Object.keys(validationErrors);
                                let index = 0;
                                function displayNextError() {
                                    if (index < errorFields.length) {
                                        const field = errorFields[index];
                                        const errorMessage = validationErrors[field][0];
                                        showAlert('error', errorMessage);
                                        index++;
                                        // Delay before displaying the next error (e.g., 1000 milliseconds)
                                        setTimeout(displayNextError, 1000);
                                    }
                                }
                                // Start displaying errors one by one
                                displayNextError();

                            } else {
                                showAlert('error', 'An unexpected error occurred.');
                            }
                        }
                    });
                } else {
                    // Show a SweetAlert error for validation errors
                    showAlert('error', 'Please check the form for validation errors.');
                }
            });

            // Handle the case when receive_qty inputs are empty
            receiveQtyInputs.forEach(function(receiveQtyInput) {
                receiveQtyInput.addEventListener('input', function() {
                    const parentRow = receiveQtyInput.closest('tr');
                    const rejectQtyInput = parentRow.querySelector('.reject_qty');
                    const defaultRejectQty = parseFloat(rejectQtyInput.getAttribute('data-default-value')) || 0;

                    if (receiveQtyInput.value === "") {
                        // Set the reject_qty input to the default value
                        rejectQtyInput.value = defaultRejectQty;
                    }
                });
            });

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
        });
    </script>
@endsection
