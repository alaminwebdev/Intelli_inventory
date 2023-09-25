@extends('admin.layouts.app')
@section('content')
    <style>
        table,
        thead,
        th,
        tr {
            color: #2a527b !important;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.distribution.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>পন্য বিতরনের তালিকা</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.distribution.update', $editData->id) : route('admin.distribution.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf

                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row px-3 py-4 border rounded shadow-sm mb-3">
                                            <div class="col-md-2">
                                                <input type="hidden" value="{{ $editData->id }}" name="section_requisition_id">
                                                <label class="control-label">চাহিদাপত্র নাম্বার :</label>
                                                <input type="text" class="form-control form-control-sm" id="remarks" name="requisition_no" value="{{ $editData->requisition_no }}" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label">সেকশন : <span class="text-red">*</span></label>
                                                <select name="section_id" class="form-control form-control-sm select2" id="section_id" disabled>
                                                    <option value="">Select Department</option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}" {{ $editData->section_id == $section->id ? 'selected' : '' }}>
                                                            {{ $section->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="accordion">
                                            @foreach ($requisition_product_types as $type)
                                                <div class="card" style="box-shadow: none;">
                                                    <div class="card-header rounded shadow-sm border-0" data-toggle="collapse" data-target="#collapse-{{ $type['id'] }}" aria-expanded="true" aria-controls="collapse-{{ $type['id'] }}" style="cursor: pointer;padding: 2px 10px; background: linear-gradient(90deg, #5b86e5b5 0%, #36D1DC 100%) !important;">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link px-0 text-white" type="button">{{ $type['name'] }}</button>
                                                        </h5>
                                                        <i class="fas fa-chevron-down text-white"></i>
                                                    </div>

                                                    <div id="collapse-{{ $type['id'] }}" class="collapse show">
                                                        <div class="card-body ">
                                                            <table id="" class="table table-bordered">
                                                                <thead style="background: #fff4f4 !important;">
                                                                    <tr>
                                                                        <th>পন্য</th>
                                                                        <th>পূর্ববর্তী বিতরনের পরিমান</th>
                                                                        <th>বর্তমান মজূদ</th>
                                                                        <th>চাহিদার পরিমান</th>
                                                                        <th>সুপারিশ পরিমান</th>
                                                                        <th>বিতরনযোগ্য মজূদ</th>
                                                                        <th>অনুমোদন পরিমান</th>
                                                                        <th>যৌক্তিকতা</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    
                                                                    @foreach ($type['products'] as $product)
                                                                        @php
                                                                            // $lastDistribute = \App\Models\RequisitionApproval::where('requisition_approval_details.department_id', $editData->department_id)
                                                                            //                 ->select('requisition_approval_details.*', 'requisition_approvals.status as distribute_status')
                                                                            //                 ->join('requisition_approval_details', 'requisition_approval_details.distribute_id', '=','requisition_approvals.id' )
                                                                            //                 ->where('requisition_approval_details.product_id', $product->product_id)
                                                                            //                 ->where('requisition_approvals.status', 2)
                                                                            //                 ->orderBy('requisition_approval_details.id', 'desc')
                                                                            //                 ->first();
                                                                        @endphp

                                                                        <tr data-product-id="{{ $product['product_id'] }}">
                                                                            <td class="product-name">{{ $product['product_name'] }}</td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="previous_stock_{{ $product['product_id'] }}" value="{{ $lastDistribute->distribute_quantity ?? 0 }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="current_stock_{{ $product['product_id'] }}" name="current_stock[{{ $product['product_id'] }}]" value="{{ $product['current_stock'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="demand_quantity_{{ $product['product_id'] }}" name="demand_quantity[{{ $product['product_id'] }}]" value="{{ $product['demand_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="recommended_quantity_{{ $product['product_id'] }}" name="recommended_quantity[{{ $product['product_id'] }}]" value="{{ $product['recommended_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm" id="available_quantity_{{ $product['product_id'] }}" value="{{ $product['available_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="approve_quantity_{{ $product['product_id'] }}" name="approve_quantity[{{ $product['product_id'] }}]" value="{{ $product['final_approve_quantity'] ?? $product['recommended_quantity'] }}" {{ $editData->status == 3 ? 'readonly' : '' }} >
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm" id="remarks_{{ $product['product_id'] }}" name="remarks[{{ $product['product_id'] }}]" value="{{ $product['final_approve_remarks'] }}" {{ $product['final_approve_remarks'] ? 'readonly' : '' }}>
                                                                            </td>
                                                                        </tr>
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
                                                <button type="submit" class="btn btn-success btn-sm" {{ $editData->status == 3 ? 'disabled' : '' }}>অনুমোদন করুন</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">সংরক্ষণ</button>
                                                <button type="reset" class="btn btn-danger btn-sm">মুছুন</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.distribution.list') }}">পিছনে যান</a>
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

    <script>
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
    </script>

    <script>
        // Function to validate the form before submission
        function validateForm(event) {
            event.preventDefault(); // Prevent the default form submission

            // Validate the "Department" select input
            var departmentSelect = document.getElementById('department_id');
            var selectedDepartment = departmentSelect.value;

            if (selectedDepartment === '') {
                alert("Please select a department.");
                departmentSelect.focus();
                return false;
            }

            // Get all elements with the name attribute "demand_quantity[]"
            var departmentDemandQuantityInputs = document.querySelectorAll('[name^="department_demand_quantity["]');
            var hasUserInput = false; // Flag to track if at least one product has user input

            for (var i = 0; i < departmentDemandQuantityInputs.length; i++) {
                var departmentDemandQuantityInput = departmentDemandQuantityInputs[i];


                // Retrieve the parent <tr> element
                var parentTr = departmentDemandQuantityInput.closest('tr');

                // Retrieve the data-product-id attribute from the parent <tr>
                var productId = parentTr.dataset.productId;

                // Retrieve the product name associated with this product
                var productName = parentTr.querySelector('td:first-child').innerText;

                var departmentCurrentStockInput = document.querySelector('[name="department_current_stock[' + productId + ']"]');

                var sectionDemandQuantityInput = document.querySelector('[name="section_demand_quantity[' + productId + ']"]');


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
