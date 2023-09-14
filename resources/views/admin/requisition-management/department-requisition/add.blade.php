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
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.department.requisition.update', $editData->id) : route('admin.department.requisition.store') }} " method="post" enctype="multipart/form-data" autocomplete="off" onsubmit="return validateForm(event)">
                                @csrf
                                <input type="hidden" name="requisition_no" value="{{ $uniqueRequisitionNo }}">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="border-bottom mb-3 pb-3 ">
                                            <p class="font-weight-bold m-0 text-gray">BP No : </p>
                                            <p class="font-weight-bold m-0 text-gray">Requisition No : {{ $uniqueRequisitionNo }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="accordion">
                                            @foreach ($product_types as $item)
                                                <div class="card" style="box-shadow: none;">
                                                    <div class="card-header p-0" data-toggle="collapse" data-target="#collapse-{{ $item->id }}" aria-expanded="true" aria-controls="collapse-{{ $item->id }}" style="cursor: pointer;">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link px-0" type="button" >{{ $item->name }}</button>
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
                                                                                <input type="number" class="form-control form-control-sm @error('current_stock') is-invalid @enderror" id="current_stock" name="current_stock[{{ $product->id }}]">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm @error('demand_quantity') is-invalid @enderror" id="demand_quantity" name="demand_quantity[{{ $product->id }}]">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm @error('remarks') is-invalid @enderror" id="remarks" name="remarks[{{ $product->id }}]">
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
