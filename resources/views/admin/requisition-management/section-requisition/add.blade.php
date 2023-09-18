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
                            <a href="{{ route('admin.section.requisition.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>চাহিদাপত্রের তালিকা - সেকশন</a>
                        </div>
                        <div class="card-body">

                            <form id="sectionRequisitionForm" action="{{ isset($editData) ? route('admin.section.requisition.update', $editData->id) : route('admin.section.requisition.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <input type="hidden" name="requisition_no" value="{{ $uniqueRequisitionNo }}">

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row px-3 py-4 border rounded shadow-sm mb-3">
                                            <div class="col-md-3">
                                                <label class="control-label">বি পি নাম্বার :</label>
                                                <input type="text" class="form-control form-control-sm" id="bp_number" name="bp_number" value="{{ $employee ? $employee->bp_no : '' }}" readonly>
                                            </div>
                                            <div class="col-md-3">
                                                <label class="control-label">চাহিদাপত্র নাম্বার :</label>
                                                <input type="text" class="form-control form-control-sm" id="requisition_number" value="{{ $uniqueRequisitionNo }}" readonly>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="control-label">সেকশন <span class="text-red">*</span></label>
                                                <select name="section_id" class="form-control form-control-sm select2" id="section_id" {{ $employee && $employee->section_id ? 'disabled' : '' }}>
                                                    {{-- @if (!$employee)
                                                        <option value="">Select Section</option>
                                                    @endif --}}
                                                    <option value="">Select Section</option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}" {{ ($employee && $employee->section_id == $section->id) || (!$employee && old('section_id') == $section->id) ? 'selected' : '' }}>
                                                            {{ $section->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @if ($employee && $employee->section_id)
                                                    <!-- Hidden input field to store the department_id value -->
                                                    <input type="hidden" name="section_id" value="{{ $employee->section_id }}">
                                                @endif
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
                                                                        <th>প্রোডাক্ট</th>
                                                                        <th>বর্তমান স্টক</th>
                                                                        <th>চাহিদার পরিমাণ</th>
                                                                        <th>সংযুক্তি</th>
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
                                                                                <input type="number" class="form-control form-control-sm @error('current_stock') is-invalid @enderror" id="current_stock_{{ $product->id }}" name="current_stock" data-product-id="{{ $product->id }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm @error('demand_quantity') is-invalid @enderror" id="demand_quantity_{{ $product->id }}" name="demand_quantity" data-product-id="{{ $product->id }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm @error('remarks') is-invalid @enderror" id="remarks_{{ $product->id }}" name="remarks" data-product-id="{{ $product->id }}">
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
                                                <button type="submit" class="btn btn-success btn-sm">হালনাগাদ</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">সংরক্ষণ</button>
                                                <button type="reset" class="btn btn-danger btn-sm">মুছুন</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.section.requisition.list') }}">পিছনে যান</a>
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
            // Initialize an object to store user-modified data
            const userModifiedData = {};
            // Initialize the product data array within userModifiedData
            userModifiedData.productData = {};

            // Function to update userModifiedData object with common data
            function updateCommonData() {
                userModifiedData.bpNumber = $("#bp_number").val();
                userModifiedData.requisitionNumber = $("#requisition_number").val();
                userModifiedData.sectionId = $("#section_id").val();
            }

            // Update common data when the page loads
            updateCommonData();

            // Add event listeners to common data fields for updates
            $("#bp_number, #requisition_number, #section_id").on("input", function() {
                updateCommonData();
            });

            document.addEventListener('input', function(event) {
                const element = event.target;
                const productId = element.closest('tr').getAttribute('data-product-id');
                const inputName = element.getAttribute('name');
                const inputValue = element.value;

                if (productId) {
                    // Initialize an object for this product if it doesn't exist
                    if (!userModifiedData.productData[productId]) {
                        userModifiedData.productData[productId] = {};
                    }

                    // Store the input value in the object based on the input name
                    userModifiedData.productData[productId][inputName] = inputValue;
                    console.log(userModifiedData);
                }
            });

            // Submit Stock-In Data
            let sectionRequisitionForm = document.getElementById('sectionRequisitionForm');

            sectionRequisitionForm.addEventListener('submit', (e) => {
                e.preventDefault();

                // Validate the "Section" select input
                var sectionSelect = document.getElementById('section_id');
                var selectedSection = sectionSelect.value;

                if (selectedSection === '') {
                    alert("Please select a section.");
                    sectionSelect.focus();
                    return false;
                }


                // Get all elements with the name attribute "demand_quantity[]"
                // var demandQuantityInputs = document.querySelectorAll('[id^="demand_quantity_"]');
                // console.log(demandQuantityInputs);
                // var hasUserInput = false; // Flag to track if at least one product has user input

                // for (var i = 0; i < demandQuantityInputs.length; i++) {
                //     var demandQuantityInput = demandQuantityInputs[i];

                //     // Retrieve the parent <tr> element
                //     var parentTr = demandQuantityInput.closest('tr');

                //     // Retrieve the data-product-id attribute from the parent <tr>
                //     var productId = parentTr.dataset.productId;

                //     // Retrieve the product name associated with this product
                //     var productName = parentTr.querySelector('td:first-child').innerText;

                //     var currentStockInput = document.getElementById('current_stock_' + productId);

                //     // Check if demand_quantity field is non-empty
                //     if (demandQuantityInput.value.trim() !== '') {
                //         var demandQuantityValue = parseFloat(demandQuantityInput.value);
                //         var currentStockValue = parseFloat(currentStockInput.value);

                //         // Check if demand_quantity is not empty and is a positive number
                //         if (isNaN(demandQuantityValue) || demandQuantityValue <= 0) {
                //             alert("Demand Quantity for product '" + productName + "' must be a positive number.");
                //             demandQuantityInput.focus();
                //             demandQuantityInput.classList.add('is-invalid'); // Add is-invalid class
                //             return false;
                //         }

                //         // Check if current_stock is not empty and is a positive number
                //         if (isNaN(currentStockValue) || currentStockValue <= 0) {
                //             alert("Current Stock for product '" + productName + "' must be required and have a positive number.");
                //             currentStockInput.focus();
                //             currentStockInput.classList.add('is-invalid'); // Add is-invalid class
                //             return false;
                //         }

                //         // If both fields are valid, remove the is-invalid class
                //         demandQuantityInput.classList.remove('is-invalid');
                //         currentStockInput.classList.remove('is-invalid');

                //         // Set the flag to true since at least one product has user input
                //         hasUserInput = true;
                //     } else {
                //         // If demand_quantity is empty, add the is-invalid class
                //         // demandQuantityInput.classList.add('is-invalid');
                //         demandQuantityInput.focus();
                //     }
                // }

                // // Check if at least one product has user input
                // if (!hasUserInput) {
                //     alert("At least one product must have user input for the requisition.");
                //     return false;
                // }

                var demandQuantityInputs = document.querySelectorAll('[id^="demand_quantity_"]');
                var hasUserInput = false;

                for (var i = 0; i < demandQuantityInputs.length; i++) {
                    var demandQuantityInput = demandQuantityInputs[i];
                    var demandQuantityValue = demandQuantityInput.value.trim();

                    // Find the associated current_stock input
                    var productId = demandQuantityInput.closest('tr').dataset.productId;
                    var currentStockInput = document.getElementById('current_stock_' + productId);
                    var currentStockValue = currentStockInput.value.trim();

                    if (demandQuantityValue !== '') {
                        hasUserInput = true;
                        if (currentStockValue === '') {
                            alert("When Demand Quantity is filled, Current Stock must also have a value.");
                            demandQuantityInput.focus();
                            return false;
                        } else {
                            // At least one field meets the condition, so stop the loop
                            break;
                        }
                    }
                }

                if (!hasUserInput) {
                    alert("At least one product must have user input for the requisition.");
                    return false;
                }



                $('#loading-spinner').show(); // Show the spinner

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.post("{{ route('admin.section.requisition.store') }}", {
                    data: userModifiedData
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
                            location.href = "{{ route('admin.section.requisition.list') }}";
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
