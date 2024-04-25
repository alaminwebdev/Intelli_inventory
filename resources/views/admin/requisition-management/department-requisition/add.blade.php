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
                            <a href="{{ route('admin.department.requisition.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>চাহিদাপত্রের তালিকা - ডিপার্টমেন্ট</a>
                        </div>
                        <div class="card-body">
                            <form id="departmentRequisitionForm" action="{{ isset($editData) ? route('admin.department.requisition.update', $editData->id) : route('admin.department.requisition.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row px-3 py-4 border rounded shadow-sm mb-3">
                                            <div class="col-md-2">
                                                <label class="control-label">Requisition No. :</label>
                                                <input type="text" class="form-control form-control-sm" id="requisition_no" name="requisition_no" value="{{ $uniqueRequisitionNo }}" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label">ডিপার্টমেন্ট : <span class="text-red">*</span></label>
                                                <select name="department_id" class="form-control form-control-sm select2" id="department_id" {{ $employee ? 'disabled' : '' }}>
                                                    @if (!$employee)
                                                        <option value="">Select Department</option>
                                                    @endif
                                                    @foreach ($departments as $department)
                                                        <option value="{{ $department->id }}" {{ ($employee && $employee->department_id == $department->id) || (!$employee && old('department_id') == $department->id) ? 'selected' : '' }}>
                                                            {{ $department->name }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                @if ($employee)
                                                    <!-- Hidden input field to store the department_id value -->
                                                    <input type="hidden" name="department_id" value="{{ $employee->department_id }}">
                                                @endif
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label">SECTION Requisition No. : <span class="text-red"></span></label>
                                                <select name="section_requisition_id[]" class="form-control form-control-sm select2" id="section_requisition_id" multiple="multiple">
                                                    <option value="" disabled>Select Section Requisition</option>
                                                    @foreach ($section_requisitions as $section_requisition)
                                                        <option value="{{ $section_requisition->id }}">{{ $section_requisition->requisition_no }}</option>
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
                                                                        <th>প্রোডাক্ট</th>
                                                                        <th>বর্তমান স্টক(SECTION)</th>
                                                                        <th>Demand Quantity(SECTION)</th>
                                                                        <th>বর্তমান স্টক(ডিপার্টমেন্ট)</th>
                                                                        <th>Demand Quantity(ডিপার্টমেন্ট)</th>
                                                                        <th>মন্তব্য / Remark</th>
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
                                                                                <input type="number" class="form-control form-control-sm" id="section_current_stock_{{ $product->id }}" name="section_current_stock" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="section_demand_quantity_{{ $product->id }}" name="section_demand_quantity" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="department_current_stock_{{ $product->id }}" name="department_current_stock">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="department_demand_quantity_{{ $product->id }}" name="department_demand_quantity">
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
                                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                                <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.department.requisition.list') }}">Back</a>
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

            $(document).on('change', '#department_id', function() {
                let department_id = $(this).val();
                console.log(department_id);
                $.ajax({
                    url: "{{ route('admin.get.sections.requisitions.by.department') }}",
                    type: "GET",
                    data: {
                        department_id: department_id
                    },
                    success: function(data) {
                        console.log(data);
                        // Handle the data here
                        let section_requisition_select = $('#section_requisition_id');

                        // Clear all selected options
                        section_requisition_select.val([]);

                        // Clear the select's existing options
                        section_requisition_select.empty();

                        // Add a default option
                        section_requisition_select.append($('<option>', {
                            value: '',
                            text: 'Select Section Requisition',
                            disabled: true
                        }));

                        // Add new options based on the data
                        data.forEach(item => {
                            section_requisition_select.append($('<option>', {
                                value: item.id,
                                text: item.requisition_no
                            }));
                        });

                        // Trigger the onchange event of section_requisition_id
                        section_requisition_select.trigger('change');
                    }
                });
            });
        });
    </script>

    {{-- <script>
        $(function() {
            $('#section_requisition_id').on('change', function() {
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

                            // Clear form fields
                            $('input[name^="section_current_stock"]').val('');
                            $('input[name^="section_demand_quantity"]').val('');

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
    </script> --}}

    <script>
        $(function() {
            // Initialize an object to store user-modified data
            const userModifiedData = {
                productData: {}
            };

            // Function to update userModifiedData object with common data
            function updateCommonData() {
                userModifiedData.requisitionNo = $("input[name='requisition_no']").val();
                userModifiedData.departmentId = $("select[name='department_id']").val();
                userModifiedData.sectionRequisitionIds = $("#section_requisition_id").val() || [];
            }

            // Function to update product data for a given productId
            function updateProductData(productId) {
                // Store the product data for the given productId
                userModifiedData.productData[productId] = {
                    section_current_stock: $(`#section_current_stock_${productId}`).val(),
                    section_demand_quantity: $(`#section_demand_quantity_${productId}`).val(),
                    department_current_stock: $(`#department_current_stock_${productId}`).val(),
                    department_demand_quantity: $(`#department_demand_quantity_${productId}`).val(),
                    remarks: $(`#remarks_${productId}`).val(),
                };

            }

            // Update common data when the page loads
            updateCommonData();

            // Add event listeners to common data fields for updates
            $("input[name='requisition_no'], select[name='department_id'], #section_requisition_id").on("input", function() {
                updateCommonData();
            });

            // Add event listener for input field changes
            $("input[name^='section_demand_quantity'], input[name^='section_current_stock'], input[name^='department_current_stock'], input[name^='department_demand_quantity'], input[name^='remarks']").on("input", function() {
                const productId = $(this).closest("tr").data("product-id");

                if (productId) {
                    updateProductData(productId);
                }
            });

            $('#section_requisition_id').on('change', function() {
                let selectedRequisitionIds = $(this).val();

                // Clear form fields if no option is selected
                if (!selectedRequisitionIds || selectedRequisitionIds.length === 0) {
                    $('input[name^="section_current_stock"]').val('');
                    $('input[name^="section_demand_quantity"]').val('');

                    // Remove corresponding values from userModifiedData
                    $('input[name^="section_current_stock"], input[name^="section_demand_quantity"]').each(function() {
                        const productId = $(this).closest('tr').data('product-id');
                        if (productId && userModifiedData.productData[productId]) {
                            userModifiedData.productData[productId].section_current_stock = '';
                            userModifiedData.productData[productId].section_demand_quantity = '';
                        }
                    });

                    console.log(userModifiedData);
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

                            // Loop through the received data
                            response.forEach(function(data) {
                                var productId = data.product_id;
                                var totalCurrentStock = data.total_current_stock;
                                var totalDemandQuantity = data.total_demand_quantity;

                                // Update the section_current_stock and section_demand_quantity fields
                                $('#section_current_stock_' + productId).val(totalCurrentStock);
                                $('#section_demand_quantity_' + productId).val(totalDemandQuantity);

                                // Update the userModifiedData object
                                updateProductData(productId);
                                console.log(userModifiedData);
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });
                }
            });

            // Submit Stock-In Data
            let departmentRequisitionForm = document.getElementById('departmentRequisitionForm');

            departmentRequisitionForm.addEventListener('submit', (e) => {
                e.preventDefault();

                // Validate the "Department" select input
                var departmentSelect = document.getElementById('department_id');
                var selectedDepartment = departmentSelect.value;

                if (selectedDepartment === '') {
                    alert("Please select a department.");
                    departmentSelect.focus();
                    return false;
                }

                // Get all elements with the name attribute "demand_quantity[]"
                var departmentDemandQuantityInputs = document.querySelectorAll('[id^="department_demand_quantity_"]');
                var hasUserInput = false; // Flag to track if at least one product has user input

                for (var i = 0; i < departmentDemandQuantityInputs.length; i++) {
                    var departmentDemandQuantityInput = departmentDemandQuantityInputs[i];


                    // Retrieve the parent <tr> element
                    var parentTr = departmentDemandQuantityInput.closest('tr');

                    // Retrieve the data-product-id attribute from the parent <tr>
                    var productId = parentTr.dataset.productId;

                    // Retrieve the product name associated with this product
                    var productName = parentTr.querySelector('td:first-child').innerText;

                    // var departmentCurrentStockInput = document.querySelector('[name="department_current_stock[' + productId + ']"]');
                    var departmentCurrentStockInput = document.getElementById('department_current_stock_' + productId);
                    
                    // var sectionDemandQuantityInput = document.querySelector('[name="section_demand_quantity[' + productId + ']"]');
                    var sectionDemandQuantityInput = document.getElementById('section_demand_quantity_' + productId);


                    // Check if Department demand_quantity field is non-empty
                    if (departmentDemandQuantityInput.value.trim() !== '') {
                        var sectionDemandQuantityValue = parseFloat(sectionDemandQuantityInput.value);
                        var departmentDemandQuantityValue = parseFloat(departmentDemandQuantityInput.value);
                        var departmentCurrentStockValue = parseFloat(departmentCurrentStockInput.value);


                        // Check if demand_quantity is not empty and is a positive number
                        if (isNaN(departmentDemandQuantityValue) || departmentDemandQuantityValue <= 0) {
                            alert("Department Demand Quantity for product '" + productName + "' must be a positive number.");
                            departmentDemandQuantityInput.focus();
                            departmentDemandQuantityInput.classList.add('is-invalid'); // Add is-invalid class
                            return false;
                        }

                        // Check if current_stock is not empty and is a positive number
                        if (isNaN(departmentCurrentStockValue) || departmentCurrentStockValue <= 0) {
                            alert("Department Current Stock for product '" + productName + "' must be required and have a positive number.");
                            departmentCurrentStockInput.focus();
                            departmentCurrentStockInput.classList.add('is-invalid'); // Add is-invalid class
                            return false;
                        }



                        // If both fields are valid, remove the is-invalid class
                        departmentDemandQuantityInput.classList.remove('is-invalid');
                        departmentCurrentStockInput.classList.remove('is-invalid');

                        // Set the flag to true since at least one product has user input
                        hasUserInput = true;
                        break;
                    }
                }

                // Check if at least one product has user input
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

                $.post("{{ route('admin.department.requisition.store') }}", {
                    data: userModifiedData
                }, function(response) {

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
                            location.href = "{{ route('admin.department.requisition.list') }}";
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
