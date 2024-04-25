@extends('admin.layouts.app')
@section('content')
    <style>

    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form id="productSelectionForm" action="{{ route('admin.stock.in.add') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <input type="hidden" name="is_po_product" id="is_po_product" value="0">
                        <input type="hidden" name="old_po_date" id="old_po_date" value="">
                        <div class="card shadow-sm">
                            <div class="card-header text-right">
                                <h4 class="card-title">{{ @$title }}</h4>
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm">Move forward</button>
                                    <a class="btn btn-default btn-sm ion-android-arrow-back" href="{{ route('admin.stock.in.list') }}">Back</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row px-3 pb-4 border rounded shadow-sm mb-4">
                                    <div class="col-md-5 pt-4">
                                        <label class="control-label">PO No. : <span class="text-red">*</span></label>
                                        <input type="text" class="form-control form-control-sm " id="po_no" name="po_no" value="">
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <label class="control-label">PO Date :</label>
                                        <input type="text" class="form-control form-control-sm singledatefromtoday" id="po_date" name="po_date" value="">
                                    </div>
                                    <div class="col-md-3 pt-4">
                                        <label class="control-label" style="visibility: hidden;">Check</label>
                                        <button class="btn btn-primary btn-sm btn-block" id="checkPoBtn">Select Product</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 px-0">
                                        <div class="table-responsive mb-3">
                                            <div id="productTypesTable">
                                                {{-- <table class="table border table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:4%;text-align:center;">বাছাই</th>
                                                            <th>Product</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($product_types as $product_type)
                                                            <tr class="group-header collapsed " data-toggle="collapse" data-target="#{{ 'group_' . $product_type['id'] }}" style="cursor: pointer; background: #f8f9fa;">
                                                                <td class="text-center">
                                                                    <span class="expand-icon badge badge-success" style="transition: all .2s linear"><i class="fas fa-plus" style="transition: all .2s linear"></i></span>
                                                                </td>
                                                                <td>
                                                                    <strong class="text-gray">{{ $product_type['name'] }}</strong>
                                                                </td>
                                                            </tr>
                                                            <tr id="{{ 'group_' . $product_type['id'] }}" class="collapse">
                                                                <td colspan="2" class="p-2">
                                                                    <table class="table table-bordered sub-table">
                                                                        <tbody>
                                                                            @foreach ($product_type['products'] as $product)
                                                                                <tr>
                                                                                    <td class="text-center" style="width:5%;">
                                                                                        <div class="custom-control custom-checkbox" style="padding-left: 2rem;">
                                                                                            <input class="custom-control-input" type="checkbox" id="selected_products_{{ $product['id'] }}" name="selected_products[]" value="{{ $product['id'] }}" style="cursor: pointer">
                                                                                            <label for="selected_products_{{ $product['id'] }}" class="custom-control-label" style="cursor: pointer"></label>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>{{ $product['name'] }}({{ $product['unit'] }})</td>
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table> --}}
                                            </div>
                                            <div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success btn-sm">Move forward</button>
                                            <a class="btn btn-default btn-sm ion-android-arrow-back" href="{{ route('admin.stock.in.list') }}">Back</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <script>
        $(document).ready(function() {

            $("#productSelectionForm").on("submit", function(e) {

                var poDateInput = document.getElementById('po_date');
                var poDate = poDateInput.value;

                if (poDate === '') {
                    alert("Please select a PO Date.");
                    poDateInput.focus();
                    return false;
                }
                // Check if there are any checkboxes with the name "selected_products[]" that are checked
                const checkedCheckboxes = document.querySelectorAll('input[name="selected_products[]"]:checked');

                if (checkedCheckboxes.length === 0) {
                    // No checkboxes are checked, so prevent form submission
                    alert("Please select at least one product.");
                    e.preventDefault(); // Prevent form submission
                }

            });

            $("#checkPoBtn").on("click", function(e) {
                e.preventDefault();

                var poNoInput = document.getElementById('po_no');
                var poNo = poNoInput.value;

                var poDateInput = document.getElementById('po_date');
                var poDate = poDateInput.value;

                if (poNo === '') {
                    alert("Please select a PO Number.");
                    poNoInput.focus();
                    return false;
                }


                $('#loading-spinner').show();

                // Send an AJAX request to check if PO number exists
                $.ajax({
                    url: "{{ route('admin.stock.in.check.po') }}",
                    method: "POST",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "po_no": poNo
                    },
                    dataType: "json",
                    success: function(response) {
                        console.log(response);

                        if (response.exists) {

                            if (response.po_date) {

                                // Set the formatted date as the value of the po_dateInput field
                                poDateInput.value = response.po_date;

                                document.getElementById('old_po_date').value = response.po_date;

                                // Disable the po_date input field
                                poDateInput.disabled = true;
                            }


                            $('#productTypesTable').html(response.products);
                            $('#loading-spinner').hide();
                            document.getElementById('is_po_product').value = '1';

                            Swal.fire({
                                toast: true,
                                customClass: {
                                    popup: 'colored-toast'
                                },
                                iconColor: 'white',
                                icon: "success",
                                title: "You have a purchase order.",
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });

                        } else {

                            // Set the formatted date as the value of the po_dateInput field
                            poDateInput.value = poDate;

                            document.getElementById('old_po_date').value = '';

                            // Disable the po_date input field
                            poDateInput.disabled = false;
                            
                            $('#productTypesTable').html(response.products);
                            $('#loading-spinner').hide();
                            document.getElementById('is_po_product').value = '0';
                        }
                    },
                    error: function() {
                        // Handle any AJAX errors here
                        alert("An error occurred while checking the PO number.");
                    }
                });
            });
        });
    </script>
@endsection
