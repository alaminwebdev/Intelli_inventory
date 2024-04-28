@extends('admin.layouts.app')
@section('content')
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
                            <table id="" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th>Product</th>
                                        <th>Stock Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($mostStockProducts as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list['product'] ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list['quantity'] ?? 'N/A' }}</td>
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
@endsection
