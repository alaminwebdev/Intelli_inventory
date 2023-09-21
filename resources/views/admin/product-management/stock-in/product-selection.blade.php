@extends('admin.layouts.app')
@section('content')
    <style>
        .expand-icon {
            /* background-color: #007bff;
        color: #fff;
        padding: 5px 10px;
        border-radius: 50%;
        display: inline-block;
        cursor: pointer;
        transition: background-color 0.3s ease-in-out;  */
        }

        .expand-icon:hover {
            /* background-color: #0056b3; */
        }
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
                                    <div class="col-md-6 pt-4">
                                        <label class="control-label">ক্রয় অর্ডার নং. : <span class="text-red">*</span></label>
                                        <input type="number" class="form-control form-control-sm " id="po_no" name="po_no" value="">
                                    </div>
                                    <div class="col-md-6 pt-4">
                                        <label class="control-label">ক্রয় অর্ডারের তারিখ : <span class="text-red">*</span></label>
                                        <input type="text" class="form-control form-control-sm singledatepicker" id="po_date" name="po_date" value="">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 px-0">
                                        <div class="table-responsive mb-3">
                                            <div id="productTypesTable">
                                                <table class="table border table-bordered">
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
                                                            <tr id="{{ 'group_' . $product_type['id'] }}" class="collapse" >
                                                                <td colspan="2"  class="p-2">
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
                                                </table>
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
        $(document).ready(function () {

            $(".group-header").on("click", function () {
                var span = $(this).find(".expand-icon");
                var icon = span.find("i");
                
                if ($(this).hasClass("collapsed")) {
                    icon.removeClass("fa-plus").addClass("fa-minus");
                    span.removeClass("badge-success").addClass("badge-danger");
                } else {
                    icon.removeClass("fa-minus").addClass("fa-plus");
                    span.removeClass("badge-danger").addClass("badge-success");
                }
            });
        });
    </script>
    
@endsection
