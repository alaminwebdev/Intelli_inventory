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
                            <a href="{{ route('admin.distribute.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Distributed Requisition List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ route('admin.distribute.store') }} " method="post">
                                @csrf
                                <input type="hidden" name="employee_id" id="employee_id" value="">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row px-3 pt-3 border rounded shadow-sm mb-3">
                                            <div class="col-md-12">
                                                <p class="border-bottom" style="font-size: 14px; font-weight:600; color:#2a527b;">Requisition Maker Information</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <input type="hidden" value="{{ $editData->id }}" name="section_requisition_id">
                                                <label class="control-label">Requisition No. :</label>
                                                <input type="text" class="form-control form-control-sm" id="remarks" name="requisition_no" value="{{ $editData->requisition_no }}" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="control-label">Department : <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="department_id" name="department_id" value="{{ @$editData->section->department->name }}" readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="control-label">Section : <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="section_id" name="section_id" value="{{ @$editData->section->name }}" readonly>
                                            </div>

                                            {{-- <div class="col-md-2 mb-3">
                                                <label class="control-label">বি. পি. Sl. : <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm  @error('bp_no') is-invalid @enderror" id="bp_no" name="bp_no">
                                                @error('bp_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> --}}

                                            <div class="col-sm-3 mb-3">
                                                <label class="control-label">Employee Name <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm" value="{{ @$editData->requisition_owner->name}}"  readonly>
                                            </div>

                                            {{-- <div class="col-md-4 mb-3">
                                                <label class="control-label">পদবী <span class="text-red">*</span></label>
                                                <select name="designation_id" id="designation_id" class="form-control form-control-sm @error('designation_id') is-invalid @enderror ">
                                                    <option value="">Please Select</option>
                                                    @foreach ($designations as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->designation_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('designation_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div> --}}

                                            <div class="col-md-3 mb-3">
                                                <label class="control-label">Email</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ @$editData->requisition_owner->email}}"  readonly>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="control-label">Phone</label>
                                                <input type="text" class="form-control form-control-sm" value="{{ @$editData->requisition_owner->mobile_no}}"  readonly>
                                            </div>

                                            <div class="col-md-12">
                                                <p class="border-bottom" style="font-size: 14px; font-weight:600; color:#2a527b;">Receiver Information</p>
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="control-label">Name <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm name @error('name') is-invalid @enderror" id="name" name="name" placeholder="Name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="control-label">Designation <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm designation @error('designation') is-invalid @enderror" id="designation" name="designation" placeholder="Designation">
                                                @error('designation')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="control-label">Phone <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm phone @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Phone">
                                                @error('phone')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-3 mb-3">
                                                <label class="control-label">Email</label>
                                                <input type="text" class="form-control form-control-sm email @error('email') is-invalid @enderror" id="email" name="email" placeholder="Email">
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
                                                                        <th>Product</th>
                                                                        <th>Previous Distribute Qty.</th>
                                                                        <th>Section Current Stock</th>
                                                                        <th>Demand Quantity</th>
                                                                        <th>Recommended Quantity</th>
                                                                        <th>Verify Quantity</th>
                                                                        <th>Approve Quantity</th>
                                                                        <th>Distributable Quantity</th>
                                                                        <th>Distribute Quantity</th>
                                                                        <th>Remark</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($type['products'] as $product)
                                                                        <tr data-product-id="{{ $product['product_id'] }}">
                                                                            <td class="product-name">{{ $product['product_name'] }}</td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="previous_stock_{{ $product['product_id'] }}" value="{{ $product['last_distribute_qty'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="current_stock_{{ $product['product_id'] }}" value="{{ $product['current_stock'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="demand_quantity_{{ $product['product_id'] }}" name="demand_quantity[{{ $product['product_id'] }}]" value="{{ $product['demand_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="recommended_quantity_{{ $product['product_id'] }}" name="recommended_quantity[{{ $product['product_id'] }}]" value="{{ $product['recommended_quantity'] }}" readonly>
                                                                            </td>
                                                                            
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="verify_quantity_{{ $product['product_id'] }}" name="verify_quantity[{{ $product['product_id'] }}]" value="{{ $product['verify_quantity'] }}" readonly>
                                                                            </td>

                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="approve_quantity_{{ $product['product_id'] }}" name="approve_quantity[{{ $product['product_id'] }}]" value="{{ $product['final_approve_quantity'] }}" readonly>
                                                                            </td>

                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm" id="available_quantity_{{ $product['product_id'] }}" value="{{ $product['available_quantity'] }}" readonly>
                                                                            </td>

                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm" id="distribute_quantity_{{ $product['product_id'] }}" name="distribute_quantity[{{ $product['product_id'] }}]" value="{{ $product['final_approve_quantity'] }}" readonly>
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm" id="remarks_{{ $product['product_id'] }}" name="remarks[{{ $product['product_id'] }}]" value="{{ $product['final_approve_remarks'] }}" readonly>
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
                                            <button type="submit" class="btn btn-success btn-sm" {{ $editData->status === 3 ? '' : 'disabled' }}>Distribute</button>
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.distribute.list') }}">Back</a>
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
        $(document).ready(function() {

            // $('#bp_no').on('blur', function() {
            //     var bpNo = $(this).val();
            //     console.log(bpNo);
            //     if (bpNo !== '') {
            //         document.getElementById('loading-spinner').style.display = 'block';
            //         $.ajax({
            //             type: 'GET',
            //             url: "{{ route('admin.check.bp-no') }}",
            //             data: {
            //                 bp_no: bpNo
            //             },
            //             success: function(response) {
            //                 console.log(response)
            //                 if (Object.keys(response).length > 0) {
            //                     $('#name').val(response.name).prop('readonly', true);
            //                     $('#email').val(response.email).prop('readonly', true);

            //                     // Select the option with the matching value in designation_id
            //                     $('#designation_id').val(response.designation_id).prop('disabled', true);
            //                     document.getElementById('employee_id').value = response.id;

            //                     document.getElementById('loading-spinner').style.display = 'none';
            //                 } else {
            //                     console.log('no bp no');
            //                     // If bp_no doesn't exist, reset fields and enable them
            //                     $('#name').val('').prop('readonly', false);
            //                     $('#email').val('').prop('readonly', false);

            //                     // Reset the value of designation_id and enable the field
            //                     $('#designation_id').val('').prop('disabled', false);
            //                     document.getElementById('employee_id').value = '';

            //                     document.getElementById('loading-spinner').style.display = 'none';
            //                 }
            //             },
            //             error: function(error) {
            //                 document.getElementById('loading-spinner').style.display = 'none';
            //                 console.error("Error:", error);

            //             }
            //         });
            //     } else {
            //         // If bp_no is empty, reset fields and enable them
            //         $('#name').val('').prop('disabled', false);
            //         $('#email').val('').prop('disabled', false);

            //         // Reset the value of designation_id and enable the field
            //         $('#designation_id').val('').prop('disabled', false);
            //     }
            // });

            //Form submission validation
            $('#submitForm').on('submit', function(event) {
                // var bpNo = $('#bp_no').val();
                // var designationId = $('#designation_id').val();
                // var email = $('#email').val();
                var name = $('#name').val();
                var designation = $('#designation').val();
                var phone = $('#phone').val();

                if (!name || !designation || !phone) {
                    Swal.fire({
                        toast: true,
                        customClass: {
                            popup: 'colored-toast'
                        },
                        iconColor: 'white',
                        icon: 'error',
                        title: 'Fill all required fields.',
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        timerProgressBar: true
                    });
                    event.preventDefault(); // Prevent form submission
                    return;
                }

                // Check available_quantity and distribute_quantity for each product
                var productRows = $('tr[data-product-id]');
                for (var i = 0; i < productRows.length; i++) {
                    var productRow = $(productRows[i]);
                    var productId = productRow.data('product-id');
                    var productName = productRow.find('.product-name').text();
                    var availableQuantity = parseFloat($('#available_quantity_' + productId).val());
                    var distributeQuantity = parseFloat($('#distribute_quantity_' + productId).val());

                    if (distributeQuantity > availableQuantity) {
                        Swal.fire({
                            icon: 'error',
                            title: productName + ' - This Product distribute quantity must be equal to or less than the stock quantity',
                        });
                        event.preventDefault(); // Prevent form submission
                        return;
                    }
                }
            });

        });
    </script>
@endsection
