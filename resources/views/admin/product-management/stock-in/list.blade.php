@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.stock.in.product.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Stock</a>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">SL.</th>
                                        <th>GRN No</th>
                                        <th>Entry Date</th>
                                        <th>Challan No</th>
                                        <th>Supplier</th>
                                        <th>Status</th>
                                        {{-- <th width="15%" class="text-center">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($stock_in_data as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->grn_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->entry_date ? date('d-M-Y', strtotime($list->entry_date)) : 'N/A' }}</td>
                                            <td>{{ @$list->challan_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->supplier ?? 'N/A' }}</td>

                                            <td>{!! activeStock($list->status) !!}</td>
                                            {{-- <td class="text-center">

												@if (sorpermission('admin.product.receive.information.edit'))
												<a class="btn btn-sm btn-success" href="{{route('admin.product.receive.information.edit',$list->id)}}">
													<i class="fa fa-edit"></i>
												</a>
												@endif
												@if (sorpermission('admin.supplier.delete'))
												<a class="btn btn-sm btn-danger destroy" data-id="{{$list->id}}" data-route="{{route('admin.supplier.delete')}}">
													<i class="fa fa-trash"></i>
												</a>
												@endif
											</td> --}}
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
    <script></script>
@endsection
