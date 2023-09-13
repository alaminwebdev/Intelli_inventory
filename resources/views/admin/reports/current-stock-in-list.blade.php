@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            {{-- <a href="{{ route('admin.stock.in.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Stock</a> --}}
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">SL.</th>
                                        <th>Product Code</th>
                                        <th>Product Information</th>
                                        <th>Available Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($current_stock as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->product_code ?? 'N/A' }}</td>
                                            <td>{{ @$list->product_name }}({{@$list->unit_name }})</td>
                                            <td class="text-right">{{ @$list->available_qty ?? 'N/A' }}</td>
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
