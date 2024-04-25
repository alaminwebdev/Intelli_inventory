@extends('admin.layouts.app')
@section('content')
    <style>
        .select2-container--default .select2-results__option--highlighted[aria-selected],
        .select2-container--default .select2-results__option--highlighted[aria-selected]:hover {
            background-color: #0072bc;
        }

        .select2-container--default .select2-results__option--selected {
            background-color: #f8f9fa;
        }

        table,
        thead,
        th,
        tr {
            color: #2a527b !important;
        }

        table tr {
            font-size: 14px !important;
        }

        table.table-bordered.dataTable th,
        table.table-bordered.dataTable td {
            border-left-width: 1px !important;
        }
    </style>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-info"><i class="fas fa-tachometer-alt mr-1"></i>Dashboard</a>
                        </div>
                        <div class="card-body">
                            <form method="post" action="{{ route('admin.product.expiring.soon') }}" id="filterForm" autocomplete="off">
                                @csrf
                                <div class="gradient-border px-3 pt-4 pb-3 mb-4">
                                    <div class="form-row">
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Select Days <span class="text-red">*</span></label>
                                            <select name="days" id="days" class="form-control select2 " required>
                                                <option value=""> Please Select </option>
                                                <option value="7" {{ request()->days == 7 ? 'selected' : '' }}> 7 Days </option>
                                                <option value="15" {{ request()->days == 15 ? 'selected' : '' }}> 15 Days </option>
                                                <option value="30" {{ request()->days == 30 ? 'selected' : '' }}> 30 Days </option>
                                                <option value="60" {{ request()->days == 60 || !request()->has('days') ? 'selected' : '' }}> 60 Days </option>
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Product Type</label>
                                            <select name="product_type_id" id="product_type_id" class="form-control select2">
                                                <option value="0">All</option>
                                                @foreach ($product_types as $item)
                                                    <option value="{{ $item->id }}" {{ request()->product_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label">Product</label>
                                            <select name="product_information_id" id="product_information_id" class="form-control select2 ">
                                                <option value="0">All</option>
                                                @if (request()->product_information_id)
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->id }}" {{ request()->product_information_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group col-md-3">
                                            <label class="control-label d-block" style="visibility: hidden;">Search</label>
                                            <button type="submit" name="type" value="search" style="box-shadow:rgba(40, 167, 69, 0.30) 0px 8px 18px 4px" class="btn btn-success btn-sm"><i class="fas fa-search mr-1"></i>Search</button>
                                            @if (isset($expiringSoonProducts) && count($expiringSoonProducts) > 0)
                                                <button type="submit" class="btn btn-sm btn-primary" name="type" value="pdf" style="box-shadow:rgba(13, 109, 253, 0.25) 0px 8px 18px 4px"><i class="fas fa-file-pdf mr-1"></i> PDF</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <table id="" class="table table-bordered">
                                <thead style="background: #fff4f4 !important;">
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th width="10%">PO No.</th>
                                        <th width="60%">Product</th>
                                        <th>Expire Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($expiringSoonProducts as $product)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $product->po_no }}</td>
                                            <td>{{ $product->product }}({{ $product->unit }})</td>
                                            <td>
                                                @if ($product->expire_date)
                                                    @php
                                                        $expireDate = \Carbon\Carbon::parse($product->expire_date);
                                                        $daysUntilExpiration = $expireDate->diffInDays(\Carbon\Carbon::now());
                                                    @endphp
                                                    {{-- {{ en2bn($daysUntilExpiration) . ' দিনের মধ্যে মেয়াদ শেষ হবে' }} --}}
                                                    Expire in {{ $daysUntilExpiration }} day{{ $daysUntilExpiration != 1 ? 's' : '' }}
                                                @else
                                                    N/A
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script>
        $(function() {
            $(document).on('click', '[name=type]', function(e) {
                var type = $(this).attr('value');
                if (type == 'pdf') {
                    $('#filterForm').attr('target', '_blank');
                } else {
                    $('#filterForm').removeAttr('target');
                }
            });
        })
    </script>
    <script>
        $(function() {

            $(document).on('change', '#product_type_id', function() {
                let product_type_id = $(this).val();
                console.log(product_type_id);
                $.ajax({
                    url: "{{ route('admin.get.products.by.type') }}",
                    type: "GET",
                    data: {
                        product_type_id: product_type_id
                    },
                    success: function(data) {
                        console.log(data);
                        // Handle the data here
                        let productInformation = document.getElementById('product_information_id');
                        productInformation.innerHTML = '<option value="0">All</option>';
                        data.forEach(item => {
                            productInformation.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;
                        });
                    }
                });
            });
        });
    </script>
@endsection
