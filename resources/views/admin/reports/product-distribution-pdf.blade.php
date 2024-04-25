@extends('admin.layouts.pdf')

@section('pdf-title')
    Product Distribution Report - {{ $date_in_english }}
@endsection

@section('pdf-header')
    <p style="font-size: 12px;">Intelli Inventory</p>
    <p style="font-size: 12px;">Product Distribution Report</p>
    <p style="font-size: 12px;">Dhaka, Bangladesh</p>
@endsection

@section('pdf-header-partner')
    {{-- @php
        $img = getPartnerImage(@$cur_warehouse->partner_agency);
    @endphp
    @if (@$img->partner_img != null && file_exists(public_path('uploads') . '/' . @$img->partner_img))
        <div class="right">
            <img src="{{ asset('public/uploads/') . '/' . @$img->partner_img }}" alt="partner_img" width="80%">
        </div>
    @endif --}}
@endsection

@section('pdf-content')
    <div style="margin-top: 10px; font-size: 12px;">
        <div style="width:100%">
            <p style="margin: 0; width:50%; float:left;">Department : {{ $department ? $department->name : 'All' }} - Section : {{ @$section ? $section->name : 'All' }} </p>
            <p style="margin: 0; width:50%; float:right; text-align:right">Date : {{ $date_from }} - {{ $date_to }}</p>
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" width="5%">Sl.</th>
                <th class="text-center">Product</th>
                <th class="text-center">Unit</th>
                <th class="text-center">Section</th>
                <th class="text-center">PO No.</th>
                <th class="text-center">Date</th>
                <th class="text-center">Distribute Quantity</th>
                <th class="text-center">Total</th>
            </tr>
        </thead>
        <tbody>
            @isset($distributed_products)
                @foreach ($distributed_products as $product_id => $product_info)
                    @php
                        $total_distribute_qty = array_sum(array_column($product_info, 'distribute_quantity'));
                    @endphp
                    @foreach ($product_info as $products)
                        <tr>
                            @if ($loop->first)
                                <td rowspan="{{ count($product_info) }}">{{ $loop->parent->iteration }}</td>
                                <td rowspan="{{ count($product_info) }}">{{ $products['product'] }}</td>
                                <td rowspan="{{ count($product_info) }}">{{ $products['unit_name'] }}</td>
                            @endif
                            <td>{{ $products['section'] }}</td>
                            <td>{{ $products['po_no'] }}</td>
                            <td>{{ date('d-M-Y', strtotime($products['date'])) }}</td>
                            <td class="text-right">{{ number_format($products['distribute_quantity'], 2, '.', ',') }}</td>
                            @if ($loop->first)
                                <td rowspan="{{ count($product_info) }}" class="text-right" style="font-weight: 600;">{{ number_format($total_distribute_qty, 2, '.', ',') }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            @endisset
        </tbody>
    </table>
@endsection
