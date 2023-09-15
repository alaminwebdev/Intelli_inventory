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
                            <a href="{{ route('admin.requisition.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Requisition List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ route('admin.requisition.update', $editData->id) }} " method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateForm(event)">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row px-3 py-4 border rounded shadow-sm mb-3">
                                            <div class="col-md-4">
                                                <label class="control-label">Department :</label>
                                                <input type="text" class="form-control form-control-sm" id="remarks" name="requisition_no" value="{{ $editData->requisition_no }}" readonly>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="control-label">Requisition No :</label>
                                                <input type="text" class="form-control form-control-sm" id="remarks" name="requisition_no" value="{{ $editData->requisition_no }}" readonly>
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
                                                                        <th>Current Stock</th>
                                                                        <th>Demand Quantity</th>
                                                                        <th>Approve Quantity</th>
                                                                        <th>Remarks</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @php
                                                                        $productIds = \App\Models\ProductInformation::where('product_type_id', $item->id)
                                                                            ->latest()
                                                                            ->pluck('id');

                                                                        $requisitionProducts = \App\Models\DepartmentRequisitionDetails::where('department_requisition_id', $editData->id)
                                                                            ->whereIn('product_id', $productIds)
                                                                            ->get();
                                                                        
                                                                    @endphp
                                                                    @foreach ($requisitionProducts as $product)
                                                                        <tr data-product-id="{{ $product->product_id }}">
                                                                            <td class="product-name">{{ $product->product_id }}</td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="department_current_stock_{{ $product->product_id }}" name="department_current_stock[{{ $product->product_id }}]" value="{{ $product->current_stock }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="department_demand_quantity_{{ $product->product_id }}" name="department_demand_quantity[{{ $product->product_id }}]" value="{{ $product->demand_quantity }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="approve_quantity_{{ $product->product_id }}" name="approve_quantity_[{{ $product->product_id }}]">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm" id="remarks_{{ $product->product_id }}" name="remarks[{{ $product->product_id }}]">
                                                                            </td>
                                                                        </tr>
                                                                        <input type="hidden" name="product_type[{{ $product->product_id }}]" value="{{ $item->id }}">
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
                                                <a href="{{ route('admin.requisition.list') }}">Back</a>
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
        // Function to validate the form before submission
        // function validateForm(event) {
        //     event.preventDefault(); // Prevent the default form submission

        //     // Get all elements with the name attribute "demand_quantity[]"
        //     var departmentDemandQuantityInputs = document.querySelectorAll('[name^="department_demand_quantity["]');
        //     var hasUserInput = false; // Flag to track if at least one product has user input

        //     for (var i = 0; i < departmentDemandQuantityInputs.length; i++) {
        //         var departmentDemandQuantityInput = departmentDemandQuantityInputs[i];


        //         // Retrieve the parent <tr> element
        //         var parentTr = departmentDemandQuantityInput.closest('tr');

        //         // Retrieve the data-product-id attribute from the parent <tr>
        //         var productId = parentTr.dataset.productId;

        //         // Retrieve the product name associated with this product
        //         var productName = parentTr.querySelector('td:first-child').innerText;

        //         var departmentCurrentStockInput = document.querySelector('[name="department_current_stock[' + productId + ']"]');

        //         var sectionDemandQuantityInput = document.querySelector('[name="section_demand_quantity[' + productId + ']"]');


        //         // Check if Department demand_quantity field is non-empty
        //         if (departmentDemandQuantityInput.value.trim() !== '') {
        //             var sectionDemandQuantityValue = parseFloat(sectionDemandQuantityInput.value);
        //             var departmentDemandQuantityValue = parseFloat(departmentDemandQuantityInput.value);
        //             var departmentCurrentStockValue = parseFloat(departmentCurrentStockInput.value);


        //             // Check if demand_quantity is not empty and is a positive number
        //             if (isNaN(departmentDemandQuantityValue) || departmentDemandQuantityValue <= 0) {
        //                 alert("Department Demand Quantity for product '" + productName + "' must be a positive number.");
        //                 departmentDemandQuantityInput.focus();
        //                 departmentDemandQuantityInput.classList.add('is-invalid'); // Add is-invalid class
        //                 return false;
        //             }

        //             // Check if current_stock is not empty and is a positive number
        //             if (isNaN(departmentCurrentStockValue) || departmentCurrentStockValue <= 0) {
        //                 alert("Department Current Stock for product '" + productName + "' must be required and have a positive number.");
        //                 departmentCurrentStockInput.focus();
        //                 departmentCurrentStockInput.classList.add('is-invalid'); // Add is-invalid class
        //                 return false;
        //             }

        //             // If both fields are valid, remove the is-invalid class
        //             departmentDemandQuantityInput.classList.remove('is-invalid');
        //             departmentCurrentStockInput.classList.remove('is-invalid');

        //             // Set the flag to true since at least one product has user input
        //             hasUserInput = true;
        //         }
        //     }

        //     // Check if at least one product has user input
        //     if (!hasUserInput) {
        //         alert("At least one product must have user input for the requisition.");
        //         return false;
        //     }

        //     // If all validation checks pass and at least one product has user input, you can submit the form
        //     event.target.submit(); // Manually trigger the form submission
        // }
    </script>
@endsection
