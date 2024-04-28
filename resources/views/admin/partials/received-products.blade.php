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

                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th>Requisition No.</th>
                                        <th>Section</th>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Demand Quantity</th>
                                        <th>Recommended Quantity</th>
                                        <th>Approved Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectionRequisitionProducts as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->section ?? 'N/A' }}</td>
                                            <td>{{ @$list->product }} ({{ @$list->unit }})</td>
                                            <td class="text-right">{{ @$list->current_stock ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list->demand_quantity ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list->recommended_quantity ?? 'N/A' }}</td>
                                            <td class="text-right">{{ @$list->final_approve_quantity ?? 'N/A' }}</td>
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
