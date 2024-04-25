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
                                                <input type="number" class="form-control form-control-sm challan_no @error('challan_no') is-invalid @enderror" id="challan_no" name="challan_no">
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
                                                        <option value="{{ $item->id }}" {{ @$stock_in_infos->supplier_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">PO No. <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm " id="po_no" name="po_no" value="{{ $selected_po_no }}" readonly>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">PO Date <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm singledatepicker" id="" name="" @if ($selected_po_date) value="{{ $selected_po_date }}" @endif disabled>
                                                <input type="hidden" name="po_date" value="{{ $selected_po_date }}">
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <table id="" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:20%;">Product</th>
                                                        <th>PO Quantity</th>
                                                        <th>Previous Receive Quantity</th>
                                                        <th>Receive Quantity</th>
                                                        <th>Remaining Quantity</th>
                                                        <th>Date of manufacture</th>
                                                        <th>Expiry Date</th>
                                                        <th>Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($selected_products as $product)
                                                        <tr data-product-id="{{ $product->product_id }}">
                                                            <td class="product-name">{{ $product->product }}({{ $product->unit }})</td>
                                                            <td>
                                                                <input type="number" class="form-control form-control-sm po_qty" id="po_qty_{{ $product->product_id }}" name="po_qty[{{ $product->product_id }}]" data-product-id="{{ $product->product_id }}" value="{{ $product->po_qty }}" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control form-control-sm prev_receive_qty " id="prev_receive_qty_{{ $product->product_id }}" name="prev_receive_qty[{{ $product->product_id }}]" data-product-id="{{ $product->product_id }}" value="{{ $product->receive_qty }}" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control form-control-sm receive_qty " id="receive_qty_{{ $product->product_id }}" name="receive_qty[{{ $product->product_id }}]" data-product-id="{{ $product->product_id }}" data-default-value="{{ $product->reject_qty }}">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control form-control-sm reject_qty" id="reject_qty_{{ $product->product_id }}" name="reject_qty[{{ $product->product_id }}]" data-product-id="{{ $product->product_id }}" value="{{ $product->reject_qty }}" readonly>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm @error('mfg_date') is-invalid @enderror singledatepicker" id="mfg_date_{{ $product->product_id }}" name="mfg_date[{{ $product->product_id }}]" data-product-id="{{ $product->product_id }}">
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control form-control-sm @error('expire_date') is-invalid @enderror singledatefromtoday" id="expire_date_{{ $product->product_id }}" name="expire_date[{{ $product->product_id }}]" data-product-id="{{ $product->product_id }}">
                                                            </td>
                                                            <td>
                                                                <textarea class="form-control form-control-sm @error('remarks') is-invalid @enderror" id="remarks_{{ $product->product_id }}" name="remarks[{{ $product->product_id }}]" data-product-id="{{ $product->product_id }}" rows="1"></textarea>
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
                                                <button type="submit" class="btn btn-success btn-sm">Save</button>
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
        const receiveQtyInputs = document.querySelectorAll(".receive_qty");
        const rejectQtyInputs = document.querySelectorAll(".reject_qty");

        // Add event listeners to detect changes for each receive_qty input
        receiveQtyInputs.forEach((receiveQtyInput, index) => {
            receiveQtyInput.addEventListener("input", function() {
                const parentRow = receiveQtyInput.closest("tr");
                const poQtyInput = parentRow.querySelector(".po_qty");
                const rejectQtyInput = rejectQtyInputs[index]; // Get the corresponding reject_qty input

                const invoiceQty = parseFloat(poQtyInput.value) || 0;
                const receiveQty = parseFloat(receiveQtyInput.value) || 0;
                const defaultRejectQty = parseFloat(rejectQtyInput.getAttribute("data-default-value")) || 0;

                // Calculate reject_qty based on your logic
                let rejectQty = defaultRejectQty - receiveQty;
                console.log(rejectQty);

                // // Ensure reject_qty is not negative
                // if (rejectQty < 0) {
                //     rejectQty = 0; // Set to zero if negative
                // }

                // Update the reject_qty input field
                rejectQtyInput.value = rejectQty;

                // Validate that receive_qty is less than or equal to reject_qty
                if (receiveQty > defaultRejectQty) {
                    receiveQtyInput.setCustomValidity("Receive quantity cannot be greater than Reject quantity.");
                } else {
                    receiveQtyInput.setCustomValidity(""); // Clear any validation message
                }
            });
        });

        // Store the default reject_qty value in data attributes
        rejectQtyInputs.forEach((rejectQtyInput) => {
            rejectQtyInput.setAttribute("data-default-value", rejectQtyInput.value);
        });

        // Handle the case when receive_qty inputs are empty
        receiveQtyInputs.forEach((receiveQtyInput) => {
            receiveQtyInput.addEventListener("input", function() {
                const parentRow = receiveQtyInput.closest("tr");
                const rejectQtyInput = parentRow.querySelector(".reject_qty");
                const defaultRejectQty = parseFloat(rejectQtyInput.getAttribute("data-default-value")) || 0;

                if (receiveQtyInput.value === "") {
                    // Set the reject_qty input to the default value
                    rejectQtyInput.value = defaultRejectQty;
                }
            });
        });
    </script>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stockInForm = document.getElementById('stockInForm');
            const receiveQtyInputs = document.querySelectorAll('.receive_qty');
            console.log(receiveQtyInputs);

            stockInForm.addEventListener('submit', function(e) {
                e.preventDefault();

                // Reset previous validation errors
                clearValidationErrors();

                // Validate product-specific fields
                let isValid = true;

                // Validate common fields
                const entryDate = document.getElementById('entry_date').value.trim();
                const challanNo = document.getElementById('challan_no').value.trim();
                const supplierId = document.getElementById('supplier_id').value;

                if (!entryDate) {
                    markInvalidField('entry_date');
                    isValid = false;
                }

                if (!challanNo) {
                    markInvalidField('challan_no');
                    isValid = false;
                }

                if (!supplierId) {
                    markInvalidField('supplier_id');
                    isValid = false;
                }



                receiveQtyInputs.forEach(function(receiveQtyInput) {

                    const parentRow = receiveQtyInput.closest('tr');
                    const rejectQtyInput = parentRow.querySelector('.reject_qty');
                    const receiveQty = parseFloat(receiveQtyInput.value) || 0;
                    const rejectQty = parseFloat(rejectQtyInput.value) || 0;
                    const defaultRejectQty = parseFloat(rejectQtyInput.getAttribute('data-default-value')) || 0;

                    // Check if receiveQty is empty
                    if (receiveQty === 0) {
                        markInvalidField(receiveQtyInput.id);
                        receiveQtyInput.setCustomValidity('Receive quantity is required.');
                        isValid = false;
                    } else if (receiveQty > defaultRejectQty) {
                        // Additional validation logic
                        markInvalidField(receiveQtyInput.id);
                        markInvalidField(rejectQtyInput.id);
                        receiveQtyInput.setCustomValidity('Receive quantity cannot be greater than Reject quantity.');
                        isValid = false;
                    }

                    if (isNaN(receiveQty) || receiveQty < 0) {
                        console.log('Event listener attached'); // Add this line
                        isValid = false;
                        markInvalidField(receiveQtyInput.id);
                        receiveQtyInput.setCustomValidity('Receive quantity must be a valid positive number.');
                    }

                });

                if (isValid) {
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

            function markInvalidField(fieldId) {
                const field = document.getElementById(fieldId);
                field.classList.add('is-invalid');
            }

            function clearValidationErrors() {
                const invalidFields = document.querySelectorAll('.is-invalid');
                invalidFields.forEach(function(field) {
                    field.classList.remove('is-invalid');
                });
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
        });
    </script>
@endsection
