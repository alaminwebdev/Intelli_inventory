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
                                                <label class="control-label">দপ্তর : <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="department_id" name="department_id" value="{{ $editData->section->department->name }}" readonly>
                                            </div>
                                            <div class="col-md-5">
                                                <label class="control-label">শাখা : <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm" id="section_id" name="section_id" value="{{ $editData->section->name }}" readonly>
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
                                                                        <th>শাখায় বর্তমান মজূদ</th>
                                                                        <th>চাহিদার পরিমান</th>
                                                                        <th>সুপারিশ পরিমান</th>
                                                                        <th>বিতরনযোগ্য মজূদ</th>
                                                                        <th>অনুমোদন পরিমান</th>
                                                                        <th>যৌক্তিকতা</th>
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
                                                                                <input type="number" class="form-control form-control-sm" id="approve_quantity_{{ $product['product_id'] }}" name="approve_quantity[{{ $product['product_id'] }}]" value="{{ $product['final_approve_quantity'] ?? $product['recommended_quantity'] }}" {{ $editData->status == 3 ? 'readonly' : '' }}>
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
@endsection
