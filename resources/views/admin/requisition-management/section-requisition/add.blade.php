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
                            <a href="{{ route('admin.section.requisition.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>Section Requisition List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.section.update', $editData->id) : route('admin.section.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
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
                                                    <div class="card-header p-0">
                                                        <h5 class="mb-0">
                                                            <button class="btn btn-link px-0" type="button" data-toggle="collapse" data-target="#collapse-{{ $item->id }}" aria-expanded="true" aria-controls="collapse-{{ $item->id }}">{{ $item->name }}</button>
                                                        </h5>
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
                                                                            <td>{{ $product->name }}</td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm @error('current_stock') is-invalid @enderror" id="current_stock" name="current_stock" value="{{ @$editData->current_stock }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="number" class="form-control form-control-sm @error('current_stock') is-invalid @enderror" id="current_stock" name="current_stock" value="{{ @$editData->current_stock }}">
                                                                            </td>
                                                                            <td>
                                                                                <input type="text" class="form-control form-control-sm @error('remarks') is-invalid @enderror" id="remarks" name="remarks" value="{{ @$editData->remarks }}">
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
@endsection
