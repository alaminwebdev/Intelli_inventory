@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.stock.in.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>স্টক তালিকা</a>
                        </div>
                        <div class="card-body">
                            <form id="stockInForm" method="post" action="{{ route('admin.stock.in.store') }}" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row border-bottom">
                                            <div class="form-group col-md-4">
                                                <label class="control-label">জি. আর. এন. নং. <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm grn_no @error('grn_no') is-invalid @enderror" id="grn_no" name="grn_no" value="{{ $uniqueGRNNo }}" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">এন্ট্রি তারিখ <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm entry_date @error('entry_date') is-invalid @enderror singledatepicker" id="entry_date" name="entry_date">
                                                @error('entry_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">চালান নং <span class="text-red">*</span></label>
                                                <input type="number" class="form-control form-control-sm challan_no @error('challan_no') is-invalid @enderror" id="challan_no" name="challan_no">
                                                @error('challan_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">সরবরাহকারী <span class="text-red">*</span></label>
                                                <select name="supplier_id" id="supplier_id" class="form-control select2">
                                                    <option value="">Please Select</option>
                                                    @foreach ($suppliers as $item)
                                                        <option value="{{ $item->id }}" {{ @$stock_in_infos->supplier_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">ক্রয় অর্ডার নং. : <span class="text-red">*</span></label>
                                                <input type="number" class="form-control form-control-sm " id="po_no" name="po_no" value="{{ $selected_po_no }}" readonly>
                                            </div>
                                            <div class="form-group col-md-4 ">
                                                <label class="control-label">ক্রয় অর্ডারের তারিখ : <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm singledatepicker" id="" name="" @if ($selected_po_date) value="{{ $selected_po_date }}" @endif disabled>
                                                <input type="hidden" name="po_date" value="{{ $selected_po_date }}">
                                            </div>
                                        </div>
                                        <div class="my-3">
                                            <table id="" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="width:20%;">পন্য</th>
                                                        <th>অর্ডার পরিমাণ</th>
                                                        <th>পূর্ববর্তী রিসিভ পরিমাণ</th>
                                                        <th>রিসিভ পরিমাণ</th>
                                                        <th>বাকি</th>
                                                        <th>উৎপাদন তারিখ</th>
                                                        <th>মেয়াদ উত্তীর্ণের তারিখ</th>
                                                        <th>মন্তব্য</th>
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
                                                                <input type="text" class="form-control form-control-sm @error('expire_date') is-invalid @enderror singledatepicker" id="expire_date_{{ $product->product_id }}" name="expire_date[{{ $product->product_id }}]" data-product-id="{{ $product->product_id }}">
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
                                                <button type="submit" class="btn btn-success btn-sm">হালনাগাদ করুন</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.stock.in.product.selection') }}">পিছনে যান</a>
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


                if (receiveQty === '') {
                    $('#receive_qty_' + productId).addClass('is-invalid');
                    isValid = false;
                }

            });

            return isValid;
        }
    </script>

    <script>
        $(function() {
            // Submit Stock-In Data
            let stockInForm = document.getElementById('stockInForm');

            stockInForm.addEventListener('submit', (e) => {
                e.preventDefault();

                // Validate receive_qty fields
                let isValid = true;
                const receiveQtyInputs = document.querySelectorAll(".receive_qty");

                receiveQtyInputs.forEach((receiveQtyInput) => {
                    const parentRow = receiveQtyInput.closest("tr");
                    const rejectQtyInput = parentRow.querySelector(".reject_qty");
                    const receiveQty = parseFloat(receiveQtyInput.value) || 0;
                    const rejectQty = parseFloat(rejectQtyInput.value) || 0;
                    const defaultRejectQty = parseFloat(rejectQtyInput.getAttribute("data-default-value")) || 0;

                    if (receiveQty > defaultRejectQty) {
                        isValid = false;
                        receiveQtyInput.setCustomValidity("Receive quantity cannot be greater than Reject quantity.");
                    } else {
                        receiveQtyInput.setCustomValidity(""); // Clear any validation message
                    }

                    // Check if receive_qty is empty or not a number
                    if (isNaN(receiveQty) || receiveQty === 0) {
                        isValid = false;
                        receiveQtyInput.setCustomValidity("Receive quantity must be a non-empty number.");
                    }
                });

                if (!isValid) {
                    // Show an alert if there are validation errors
                    alert("Please ensure Receive Qty is a valid number and not greater than Reject Qty in any row.");
                    return;
                }


                $('#loading-spinner').show(); // Show the spinner

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                // Serialize the form data
                var formData = $(stockInForm).serialize();

                $.post("{{ route('admin.stock.in.store') }}", formData, function(response) {

                    $('#loading-spinner').hide();
                    console.log(response);
                    var result = response.original;

                    if (result.success && result.success.trim() !== "") {

                        console.log("Success message:", result.success);
                        Swal.fire({
                            toast: true,
                            customClass: {
                                popup: 'colored-toast'
                            },
                            iconColor: 'white',
                            icon: "success",
                            title: result.success,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });

                        setTimeout(function() {
                            location.href = "{{ route('admin.stock.in.list') }}";
                        }, 1000);

                    } else if (result.error) {

                        console.log("Error message:", result.error);
                        Swal.fire({
                            toast: true,
                            customClass: {
                                popup: 'colored-toast'
                            },
                            iconColor: 'white',
                            icon: "error",
                            title: result.error,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                            timerProgressBar: true
                        });

                    } else {
                        console.log("Unexpected response:", result);
                    }
                });
            });


        });
    </script>
@endsection
