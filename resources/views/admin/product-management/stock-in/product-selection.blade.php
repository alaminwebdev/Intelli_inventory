@extends('admin.layouts.app')
@section('content')
    <style>

    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form id="productSelectionForm" action="{{ route('admin.stock.in.product.selection.process') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                        @csrf
                        <div class="card shadow-sm">
                            <div class="card-header text-right">
                                <h4 class="card-title">{{ @$title }}</h4>
                                <button type="submit" class="btn btn-success btn-sm">সামনে এগিয়ে যান</button>
                            </div>
                            <div class="card-body">
                                <div class="row px-3 pb-4 border rounded shadow-sm mb-4">
                                    <div class="col-md-5 pt-4">
                                        <label class="control-label">ক্রয় অর্ডার নং. : <span class="text-red">*</span></label>
                                        <input type="number" class="form-control form-control-sm " id="po_no" name="po_no" value="">
                                    </div>
                                    <div class="col-md-4 pt-4">
                                        <label class="control-label">ক্রয় অর্ডারের তারিখ : <span class="text-red">*</span></label>
                                        <input type="text" class="form-control form-control-sm singledatepicker" id="po_date" name="po_date" value="">
                                    </div>
                                    <div class="col-md-3 pt-4">
                                        <label class="control-label" style="visibility: hidden;">Check</label>
                                        <button class="btn btn-primary btn-sm btn-block" id="checkPoBtn">ক্রয় অর্ডার আছে কিনা যাচাই করুন</button>
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
                                                            <th>পন্য</th>
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
                                            <button type="submit" class="btn btn-success btn-sm">সামনে এগিয়ে যান</button>
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.section.requisition.list') }}">পিছনে যান</a>
                                            </button>
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
            $("#checkPoBtn").on("click", function(e) {
                e.preventDefault();

                var poNoInput = document.getElementById('po_no');
                var poNo = poNoInput.value;
                console.log(poNo);

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
                            Swal.fire({
                                toast: true,
                                customClass: {
                                    popup: 'colored-toast'
                                },
                                iconColor: 'white',
                                icon: "success",
                                title: "PO number exists !",
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                            $('#loading-spinner').hide();

                        } else {
                            Swal.fire({
                                toast: true,
                                customClass: {
                                    popup: 'colored-toast'
                                },
                                iconColor: 'white',
                                icon: "info",
                                title: "PO number doesn't exist !",
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            });
                            $('#productTypesTable').html(response.products);
                            $('#loading-spinner').hide();
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
