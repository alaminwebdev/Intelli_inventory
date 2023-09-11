@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.product.receive.information.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Product Receive Information List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.product.receive.information.update', $editData->id) : route('admin.product.receive.information.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row border-bottom">
                                            <div class="form-group col-md-4">
                                                <label class="control-label">GRN No. <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm grn_no @error('grn_no') is-invalid @enderror" id="grn_no" name="grn_no" value="{{ @$editData ? @$editData->grn_no : rand(10000, 99999) }}" readonly>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Entry Date <span class="text-red">*</span></label>
                                                <input type="date" class="form-control form-control-sm entry_date @error('entry_date') is-invalid @enderror" id="entry_date" name="entry_date" value="{{ @$editData->entry_date }}">
                                                @error('entry_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Challan Number <span class="text-red">*</span></label>
                                                <input type="number" class="form-control form-control-sm challan_no @error('challan_no') is-invalid @enderror" id="challan_no" name="challan_no" value="{{ @$editData->challan_no }}">
                                                @error('challan_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">PO No. <span class="text-red">*</span></label>
                                                <input type="number" class="form-control form-control-sm po_no @error('po_no') is-invalid @enderror" id="po_no" name="po_no" value="{{ @$editData->po_no }}">
                                                @error('po_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">PO Date <span class="text-red">*</span></label>
                                                <input type="date" class="form-control form-control-sm po_date @error('po_date') is-invalid @enderror" id="po_date" name="po_date" value="{{ @$editData->po_date }}">
                                                @error('po_date')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label class="control-label">Supplier <span class="text-red">*</span></label>
                                                <select name="supplier_id" id="supplier_id" class="form-control select2 ">
                                                    <option value="">Please Select</option>
                                                    @foreach ($suppliers as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->supplier_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-row mt-3">
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
                                                    @foreach ($product_types as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->product_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
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
                                                <a href="{{ route('admin.product.receive.information.list') }}">Back</a>
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
            let productInformation = document.getElementById('product_information_id');
            $(document).on('change', '#product_type_id', function() {
                let product_type_id = $(this).val();
                console.log(product_type_id);
                $.ajax({
                    url: "{{ route('admin.get.product.by.type') }}",
                    type: "GET",
                    data: {
                        product_type_id: product_type_id
                    },
                    success: function(data) {
                        // Handle the data here
                        productInformation.innerHTML = '<option value="">Select Product</option>';
                        data.forEach(item => {
                            productInformation.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;
                        });

                        // var html = '<option value="">Select Storage Name</option>';
                        // $.each(data, function(key, v) {
                        //     console.log(data);
                        //     if (storage_type == 1) {
                        //         html += '<option value="' + v.id + '">' + v
                        //             .storage_name + '</option>';
                        //     }
                        // });
                        // $('#storage_name').html(html);
                    }
                });
            });
        });
    </script>

@endsection
