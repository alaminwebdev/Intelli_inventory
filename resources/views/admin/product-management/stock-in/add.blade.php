@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.stock.in.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Stock-In List</a>
                        </div>
                        <div class="card-body">
                            <form id="stockInForm" method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row border-bottom">
                                            <div class="form-group col-md-3">
                                                <label class="control-label">GRN No. <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm grn_no @error('grn_no') is-invalid @enderror" id="grn_no" name="grn_no" value="{{ @$editData ? @$editData->grn_no : $uniqueGRNNo }}" readonly>
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">Entry Date <span class="text-red">*</span></label>
                                                <input type="date" class="form-control form-control-sm entry_date @error('entry_date') is-invalid @enderror" id="entry_date" name="entry_date" value="{{ @$editData->entry_date }}">
                                                @error('entry_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">Challan Number <span class="text-red">*</span></label>
                                                <input type="number" class="form-control form-control-sm challan_no @error('challan_no') is-invalid @enderror" id="challan_no" name="challan_no" value="{{ @$editData->challan_no }}">
                                                @error('challan_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-3">
                                                <label class="control-label">Supplier <span class="text-red">*</span></label>
                                                <select name="supplier_id" id="supplier_id" class="form-control select2 ">
                                                    <option value="">Please Select</option>
                                                    @foreach ($suppliers as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->supplier_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="row my-3 border rounded p-3" id="stockInData">
                                            <div class="col-md-11 px-0">
                                                <div class="form-row">
                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">Product Category <span class="text-red">*</span></label>
                                                        <select name="product_type_id" id="product_type_id" class="form-control select2">
                                                            <option value="">Please Select</option>
                                                            @foreach ($product_types as $item)
                                                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-4">
                                                        <label class="control-label">Product <span class="text-red">*</span></label>
                                                        <select name="product_information_id" id="product_information_id" class="form-control select2 ">
                                                            <option value="">Please Select</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">PO No. <span class="text-red">*</span></label>
                                                        <input type="number" class="form-control form-control-sm @error('po_no') is-invalid @enderror" id="po_no" name="po_no" value="{{ @$editData->po_no }}">
                                                        @error('po_no')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">PO Date <span class="text-red">*</span></label>
                                                        <input type="date" class="form-control form-control-sm @error('po_date') is-invalid @enderror" id="po_date" name="po_date" value="{{ @$editData->po_date }}">
                                                        @error('po_date')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Mfg Date</label>
                                                        <input type="date" class="form-control form-control-sm @error('mfg_date') is-invalid @enderror" id="mfg_date" name="mfg_date" value="{{ @$editData->mfg_date }}">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Expire Date</label>
                                                        <input type="date" class="form-control form-control-sm @error('expire_date') is-invalid @enderror" id="expire_date" name="expire_date" value="{{ @$editData->expire_date }}">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Invoice Qty</label>
                                                        <input type="number" class="form-control form-control-sm @error('invoice_qty') is-invalid @enderror" id="invoice_qty" name="invoice_qty" value="{{ @$editData->invoice_qty }}">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Receive Qty</label>
                                                        <input type="number" class="form-control form-control-sm @error('receive_qty') is-invalid @enderror" id="receive_qty" name="receive_qty" value="{{ @$editData->receive_qty }}">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Reject Qty</label>
                                                        <input type="number" class="form-control form-control-sm @error('reject_qty') is-invalid @enderror" id="reject_qty" name="reject_qty" value="{{ @$editData->reject_qty }}" readonly>
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label class="control-label">Remarks</label>
                                                        <input type="text" class="form-control form-control-sm @error('remarks') is-invalid @enderror" id="remarks" name="remarks" value="{{ @$editData->remarks }}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-1 pr-0 text-center">
                                                <button type="button" class="h-100 w-100 btn btn-info" id="product_data_add">Add</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <table width="100%" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Po No.</th>
                                                        <th>Po Date</th>
                                                        <th>Invoice Qty</th>
                                                        <th>Receive Qty</th>
                                                        <th>Reject Qty</th>
                                                        <th>Mfg Date</th>
                                                        <th>Expire Date</th>
                                                        <th style="width: 10%">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="product_table">

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
                                                <button type="reset" class="btn btn-danger btn-sm">Clear</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.stock.in.list') }}">Back</a>
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
        const invoiceQtyInput = document.getElementById("invoice_qty");
        const receiveQtyInput = document.getElementById("receive_qty");
        const rejectQtyInput = document.getElementById("reject_qty");

        // Add event listeners to detect changes
        invoiceQtyInput.addEventListener("input", updateRejectQty);
        receiveQtyInput.addEventListener("input", updateRejectQty);

        // Function to update the reject_qty field based on input values
        function updateRejectQty() {
            const invoiceQty = parseFloat(invoiceQtyInput.value) || 0;
            const receiveQty = parseFloat(receiveQtyInput.value) || 0;

            // Validate that receive_qty is less than or equal to invoice_qty
            if (receiveQty > invoiceQty) {
                receiveQtyInput.setCustomValidity("Receive quantity cannot be greater than invoice quantity.");
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
    </script>
    <script>
        $(function() {

            $(document).on('change', '#product_type_id', function() {
                let product_type_id = $(this).val();
                console.log(product_type_id);
                $.ajax({
                    url: "{{ route('admin.get.products.by.type') }}",
                    type: "GET",
                    data: {
                        product_type_id: product_type_id
                    },
                    success: function(data) {
                        console.log(data);
                        // Handle the data here
                        let productInformation = document.getElementById('product_information_id');
                        productInformation.innerHTML = '<option value="">Select Product</option>';
                        data.forEach(item => {
                            productInformation.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;
                        });
                    }
                });
            });
        });
    </script>

    <script>
        function generateUniqueIdentifier() {
            // Generate a timestamp in milliseconds and concatenate a random number
            return Date.now() + Math.floor(Math.random() * 1000);
        }
        $(function() {
            var rowData = []; // Array to store the data for all rows

            $("#product_data_add").click(function() {
                // Generate a unique identifier for the row
                var uniqueIdentifier = generateUniqueIdentifier();

                // Get values from dynamic form fields
                var productTypeId = $("#product_type_id").val();
                var productInformationId = $("#product_information_id").val();
                var poNo = $("#po_no").val();
                var poDate = $("#po_date").val();
                var mfgDate = $("#mfg_date").val();
                var expireDate = $("#expire_date").val();
                var invoiceQty = $("#invoice_qty").val();
                var receiveQty = $("#receive_qty").val();
                var rejectQty = $("#reject_qty").val();
                var remarks = $("#remarks").val();

                // Create a new row for the table
                var newRow = $("<tr>");
                newRow.append("<td class='po_no' >" + poNo + "</td>");
                newRow.append("<td class='po_date'>" + poDate + "</td>");
                newRow.append("<td class='invoice_qty' style='text-align:right'>" + invoiceQty + "</td>");
                newRow.append("<td class='receive_qty' style='text-align:right'>" + receiveQty + "</td>");
                newRow.append("<td class='reject_qty' style='text-align:right'>" + rejectQty + "</td>");
                newRow.append("<td class='mfg_date'>" + mfgDate + "</td>");
                newRow.append("<td class='expire_date'>" + expireDate + "</td>");
                newRow.append("<td><a class='edit_po btn btn-sm btn-primary' style='cursor:pointer'><i class='fa fa-edit'></i></a> <a class='delete_po btn btn-sm btn-danger' style='cursor:pointer'><i class='fa fa-trash'></i></a></td>");

                // Store additional data as attributes when adding a new row
                newRow.attr("data-remarks", remarks);
                newRow.attr("data-id", uniqueIdentifier);

                // Append the new row to the table
                $("#product_table").append(newRow);


                // Store the data in the array
                rowData.push({
                    uniqueIdentifier: uniqueIdentifier,
                    productTypeId: productTypeId,
                    productInformationId: productInformationId,
                    poNo: poNo,
                    poDate: poDate,
                    mfgDate: mfgDate,
                    expireDate: expireDate,
                    invoiceQty: invoiceQty,
                    receiveQty: receiveQty,
                    rejectQty: rejectQty,
                    remarks: remarks
                });

                // Clear the dynamic form fields
                $("#product_information_id, #po_no, #po_date, #mfg_date, #expire_date, #invoice_qty, #receive_qty, #reject_qty, #remarks").val("");
                $("#product_type_id").val("").trigger("change");

                console.log(rowData);
            });

            // Handle edit and delete actions for dynamically added rows
            $("#product_table").on("click", ".edit_po", function() {
                // Get the clicked row
                var row = $(this).closest("tr");

                // Retrieve the data from the row using classes
                var poNo = row.find(".po_no").text();
                var poDate = row.find(".po_date").text();
                var invoiceQty = row.find(".invoice_qty").text();
                var receiveQty = row.find(".receive_qty").text();
                var rejectQty = row.find(".reject_qty").text();
                var mfgDate = row.find(".mfg_date").text();
                var expireDate = row.find(".mfg_date").text();
                var remarksData = row.attr("data-remarks");

                var uniqueIdentifier = row.attr("data-id");

                // Remove the clicked row
                row.remove();

                // Determine the index of the row you want to remove
                var rowIndex = rowData.findIndex(function(item) {
                    return item.uniqueIdentifier == uniqueIdentifier;
                });

                if (rowIndex !== -1) {
                    // Remove the corresponding data from the rowData array
                    rowData.splice(rowIndex, 1);
                }

                // Populate the edit form with the data
                $("#po_no").val(poNo);
                $("#po_date").val(poDate);
                $("#mfg_date").val(mfgDate);
                $("#expire_date").val(expireDate);
                $("#invoice_qty").val(invoiceQty);
                $("#receive_qty").val(receiveQty);
                $("#reject_qty").val(rejectQty);
                $("#remarks").val(remarksData);

                console.log(rowData);
            });


            $("#product_table").on("click", ".delete_po", function() {
                // Get the clicked row
                var row = $(this).closest("tr");

                var uniqueIdentifier = row.attr("data-id");

                // Remove the clicked row
                row.remove();

                // Determine the index of the row you want to remove
                var rowIndex = rowData.findIndex(function(item) {
                    return item.uniqueIdentifier == uniqueIdentifier;
                });

                if (rowIndex !== -1) {
                    // Remove the corresponding data from the rowData array
                    rowData.splice(rowIndex, 1);
                }

                console.log(rowData);
            });


            // Submit Stock-In Data
            let stockInForm = document.getElementById('stockInForm');

            stockInForm.addEventListener('submit', (e) => {
                e.preventDefault();
                
                // Check if rowData array is empty
                if (rowData.length === 0) {
                    alert("Please add at least one product row.");
                    return; // Prevent form submission if rowData is empty
                }
                // Create an object to hold all the data
                let submitData = {};

                // Add the common data from the form fields
                submitData.grn_no = $("#grn_no").val();
                submitData.entry_date = $("#entry_date").val();
                submitData.challan_no = $("#challan_no").val();
                submitData.supplier_id = $("#supplier_id").val();

                // Add the rowData array
                submitData.stockInDetail = rowData;
                console.log(submitData);

                $('#loading-spinner').show(); // Show the spinner

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.post("{{ route('admin.stock.in.store') }}", {
                    data: submitData
                }, function(response) {

                    $('#loading-spinner').hide();
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
            })
        });
    </script>
@endsection
