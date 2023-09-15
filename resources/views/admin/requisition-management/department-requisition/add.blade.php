@extends('admin.layouts.app')
@section('content')
    <style>


    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.department.requisition.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Department Requisition List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.department.requisition.update', $editData->id) : route('admin.department.requisition.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row px-3 py-4 border rounded shadow-sm mb-3">
                                            <div class="col-md-6">
                                                <label class="control-label">Requisition No :</label>
                                                <input type="text" class="form-control form-control-sm" id="remarks" name="requisition_no" value="{{ $uniqueRequisitionNo }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">Section Requisition Number <span class="text-red">(Select a section requisition to merge into one requisition)</span></label>
                                                <select name="section_requisition_no[]" class="form-control form-control-sm select2" id="section_requisition_no" multiple="multiple">
                                                    <option value="" disabled>Select Section Requisition</option>
                                                    @foreach ($section_requisitions as $section_requisition)
                                                        <option value="{{ $section_requisition->id }}">Requisition No. {{ $section_requisition->requisition_no }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="accordion">
                                            @foreach ($product_types as $item)
                                                <div class="card" style="box-shadow: none;">
                                                    <div class="card-header p-0" data-toggle="collapse" data-target="#collapse-{{ $item->id }}" aria-expanded="true" aria-controls="collapse-{{ $item->id }}" style="cursor: pointer;">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link px-0" type="button">{{ $item->name }}</button>
                                                        </h5>
                                                        <i class="fas fa-chevron-down"></i>
                                                    </div>

                                                    <div id="collapse-{{ $item->id }}" class="collapse show">
                                                        <div class="card-body ">
                                                            <table id="" class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Product Name</th>
                                                                        <th>Current Stock(Section)</th>
                                                                        <th>Demand Quantity(Section)</th>
                                                                        <th>Current Stock(Department)</th>
                                                                        <th>Demand Quantity(Department)</th>
                                                                        <th>Remarks</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $products = App\Models\ProductInformation::where('product_type_id', $item->id)
                                                                            ->where('status', 1)
                                                                            ->latest()
                                                                            ->get();
                                                                    @endphp
                                                                    @foreach ($products as $product)
                                                                        <tr data-product-id="{{ $product->id }}">
                                                                            <td class="product-name">{{ $product->name }}</td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="section_current_stock_{{ $product->id }}" name="section_current_stock[{{ $product->id }}]" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="section_demand_quantity_{{ $product->id }}" name="section_demand_quantity[{{ $product->id }}]" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="department_current_stock_{{ $product->id }}" name="department_current_stock[{{ $product->id }}]">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="department_demand_quantity_{{ $product->id }}" name="department_demand_quantity[{{ $product->id }}]">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm" id="remarks_{{ $product->id }}" name="remarks[{{ $product->id }}]">
                                                                            </td>
                                                                        </tr>
                                                                        <input type="hidden" name="product_type[{{ $product->id }}]" value="{{ $item->id }}">
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
                                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">Save</button>
                                                <button type="reset" class="btn btn-danger btn-sm">Clear</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.section.list') }}">Back</a>
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
            $('#section_requisition_no').on('change', function() {
                let selectedRequisitionIds = $(this).val();

                // Clear form fields if no option is selected
                if (!selectedRequisitionIds || selectedRequisitionIds.length === 0) {
                    $('input[name^="section_current_stock"]').val('');
                    $('input[name^="section_demand_quantity"]').val('');
                    return; // Exit the function early
                }
                console.log(selectedRequisitionIds);
                if (selectedRequisitionIds && selectedRequisitionIds.length > 0) {
                    // Send AJAX request to fetch product data
                    $.ajax({
                        url: "{{ route('admin.get.products.by.section.requisition') }}",
                        type: 'GET',
                        data: {
                            selectedRequisitionIds: selectedRequisitionIds
                        },
                        dataType: 'json',
                        success: function(response) {
                            console.log(response);
                            //Update form fields with received data
                            // Loop through the received data
                            response.forEach(function(data) {
                                var productId = data.product_id;
                                var totalCurrentStock = data.total_current_stock;
                                var totalDemandQuantity = data.total_demand_quantity;

                                // Update the section_current_stock and section_demand_quantity fields
                                $('#section_current_stock_' + productId).val(totalCurrentStock);
                                $('#section_demand_quantity_' + productId).val(totalDemandQuantity);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });

        });
    </script>

    <script>
        // Function to validate the form before submission
        function validateForm(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get all elements with the name attribute "demand_quantity[]"
            var demandQuantityInputs = document.querySelectorAll('[name^="demand_quantity["]');
            var hasUserInput = false; // Flag to track if at least one product has user input

            for (var i = 0; i < demandQuantityInputs.length; i++) {
                var demandQuantityInput = demandQuantityInputs[i];

                // Retrieve the parent <tr> element
                var parentTr = demandQuantityInput.closest('tr');

                // Retrieve the data-product-id attribute from the parent <tr>
                var productId = parentTr.dataset.productId;

                // Retrieve the product name associated with this product
                var productName = parentTr.querySelector('td:first-child').innerText;

                var currentStockInput = document.querySelector('[name="current_stock[' + productId + ']"]');

                // Check if demand_quantity field is non-empty
                if (demandQuantityInput.value.trim() !== '') {
                    var demandQuantityValue = parseFloat(demandQuantityInput.value);
                    var currentStockValue = parseFloat(currentStockInput.value);

                    // Check if demand_quantity is not empty and is a positive number
                    if (isNaN(demandQuantityValue) || demandQuantityValue <= 0) {
                        alert("Demand Quantity for product '" + productName + "' must be a positive number.");
                        demandQuantityInput.focus();
                        demandQuantityInput.classList.add('is-invalid'); // Add is-invalid class
                        return false;
                    }

                    // Check if current_stock is not empty and is a positive number
                    if (isNaN(currentStockValue) || currentStockValue <= 0) {
                        alert("Current Stock for product '" + productName + "' must be required and have a positive number.");
                        currentStockInput.focus();
                        currentStockInput.classList.add('is-invalid'); // Add is-invalid class
                        return false;
                    }

                    // If both fields are valid, remove the is-invalid class
                    demandQuantityInput.classList.remove('is-invalid');
                    currentStockInput.classList.remove('is-invalid');

                    // Set the flag to true since at least one product has user input
                    hasUserInput = true;
                } else {
                    // If demand_quantity is empty, add the is-invalid class
                    // demandQuantityInput.classList.add('is-invalid');
                    demandQuantityInput.focus();
                }
            }

            // Check if at least one product has user input
            if (!hasUserInput) {
                alert("At least one product must have user input for the requisition.");
                return false;
            }

            // If all validation checks pass and at least one product has user input, you can submit the form
            event.target.submit(); // Manually trigger the form submission
        }
    </script>
@endsection
