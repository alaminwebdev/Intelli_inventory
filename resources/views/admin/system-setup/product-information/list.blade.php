@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.product.information.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Product</a>
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered" id="product-data-table">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th>Product </th>
                                        <th>Product Type</th>
                                        <th>Status</th>
                                        <th width="15%" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($products->groupBy('product_type_id')->sortKeys() as $productType => $productList)
                                        <tr style="background: #f8f9fa;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="font-weight-bold">{{ @$productList[0]->product_type }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @foreach ($productList as $list)
                                            <tr>
                                                <td>{{ $loop->parent->iteration . '.' . sprintf('%02d', $loop->iteration) }}</td>
                                                <td>
                                                    @if ($list->code)
                                                        {{ @$list->code }} - {{ @$list->name }}({{ @$list->unit }})
                                                    @else
                                                        {{ @$list->name }}({{ @$list->unit }})
                                                    @endif
                                                </td>
                                                <td>{{ @$list->product_type }}</td>

                                                <td>{!! activeStatus($list->status) !!}</td>
                                                <td class="text-center">
                                                    @if (sorpermission('admin.product.information.edit'))
                                                        <a class="btn btn-sm btn-success" href="{{ route('admin.product.information.edit', $list->id) }}">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    @if (sorpermission('admin.product.information.delete'))
                                                        <a class="btn btn-sm btn-danger destroy" data-id="{{ $list->id }}" data-route="{{ route('admin.product.information.delete') }}">
                                                            <i class="fa fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
