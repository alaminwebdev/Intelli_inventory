@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                        </div>
                        <div class="card-body">
                            <form id="sectionRequisitionForm" action="{{ route('admin.section.requisition.product.selection.process') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                {{-- <div class="row px-3 pb-4 border rounded shadow-sm mb-3">
                                    @foreach ($product_types as $product_type)
                                        @php
                                            $products = App\Models\ProductInformation::where('product_type_id', $product_type->id)
                                                ->where('status', 1)
                                                ->latest()
                                                ->get();
                                        @endphp
                                        <div class="col-md-6 pt-4">
                                            <label class="control-label">{{ $product_type->name }} : <span class="text-red"></span></label>
                                            <select name="selected_products[]" class="form-control form-control-sm select2" id="selected_product_type_{{ $product_type->id }}" multiple="multiple">
                                                <option value="" disabled>Select Products</option>
                                                @foreach ($products as $product)
                                                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endforeach
                                </div> --}}
                                <div class="table-responsive mb-3">
                                    <table class="table border table-bordered" id="sb-data-table">
                                        <thead>
                                            <tr>
                                                <th style="width:5%;">বাছাই</th>
                                                <th>পন্য</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product_types as $product_type)
                                                @php
                                                    $products = App\Models\ProductInformation::where('product_type_id', $product_type->id)
                                                        ->where('status', 1)
                                                        ->latest()
                                                        ->get();
                                                @endphp
                                                <tr style="background: #f8f9fa;">
                                                    <td colspan="2" class="text-gray">
                                                        <strong>{{ $product_type->name }}</strong>
                                                    </td>
                                                </tr>
                                                @foreach ($products as $product)
                                                    <tr>
                                                        <td class="text-center">
                                                            <div class="custom-control custom-checkbox">
                                                                <input class="custom-control-input" type="checkbox" id="selected_products_{{ $product->id }}" name="selected_products[]" value="{{ $product->id }}" style="cursor: pointer">
                                                                <label for="selected_products_{{ $product->id }}" class="custom-control-label" style="cursor: pointer"></label>
                                                            </div>
                                                        </td>
                                                        <td>{{ $product->name }}</td>
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="text-right">
                                            <button type="submit" class="btn btn-success btn-sm">সামনে যান</button>
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.section.requisition.list') }}">পিছনে যান</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
