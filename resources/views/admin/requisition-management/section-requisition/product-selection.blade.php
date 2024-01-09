@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <form id="sectionRequisitionForm" action="{{ route('admin.section.requisition.add') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                        <div class="card shadow-sm">
                            <div class="card-header text-right">
                                <h4 class="card-title">{{ @$title }}</h4>
                                <div>
                                    <button type="submit" class="btn btn-success btn-sm">সামনে এগিয়ে যান</button>
                                    <a class="btn btn-default btn-sm ion-android-arrow-back" href="{{ route('admin.section.requisition.list') }}">পিছনে যান</a>
                                </div>
                            </div>
                            <div class="card-body">
                                @csrf
                                <div class="table-responsive mb-3">
                                    <table class="table ">
                                        <thead>
                                            <tr>
                                                <th colspan="2">পন্য বাছাই</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($product_types as $product_type)
                                                <tr class="group-header collapsed " data-toggle="collapse" data-target="#{{ 'group_' . $product_type['id'] }}"  aria-expanded="true" aria-controls="{{ 'group_' . $product_type['id'] }}"style="cursor: pointer; background: #f8f9fa;">
                                                    <td class="text-center" style="width: 4%">
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
                                                                @foreach ($product_type['products'] as $key => $product)
                                                                    @if ($key % 2 === 0)
                                                                        <tr>
                                                                    @endif
                                                                    <td style="width: 50%;">
                                                                        <div class="custom-control custom-checkbox">
                                                                            <input class="custom-control-input" type="checkbox" id="selected_products_{{ $product['id'] }}" name="selected_products[]" value="{{ $product['id'] }}" style="cursor: pointer">
                                                                            <label for="selected_products_{{ $product['id'] }}" class="custom-control-label" style="cursor: pointer">{{ $product['name'] }} ({{ $product['unit'] }})</label>
                                                                        </div>
                                                                    </td>
                                                                    @if ($key % 2 === 1 || $loop->last) </tr> @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
            $(".group-header").on("click", function() {
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
