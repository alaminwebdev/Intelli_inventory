@extends('admin.layouts.pdf')

@section('pdf-title')
    Product Statistics - {{ $date_in_english }}
@endsection

@section('pdf-header')
    <p style="font-size: 12px;">Intelli Inventory</p>
    <p style="font-size: 12px;">Product Statistics Report</p>
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
            <p style="margin: 0; width:50%; float:left;">Department : {{ $department ? $department->name : 'All'  }}  - Section : {{ @$section ? $section->name : 'All'  }} </p>
            <p style="margin: 0; width:50%; float:right; text-align:right">Date : {{ $date_from }} - {{ $date_to }}</p>
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" width="10%">Sl.</th>
                <th class="text-center" width="20%">Product</th>
                <th class="text-center" width="10%">Unit</th>
                <th class="text-center" width="15%">Demand Quantity</th>
                <th class="text-center" width="15%">Distribute Quantity</th>
                <th class="text-center" width="15%">Temporary Stock</th>
                <th class="text-center" width="15%">Current Stock</th>
            </tr>
        </thead>
        <tbody>
            @if (@$productStatistics && count(@$productStatistics) > 0)
                @foreach ($productStatistics as $list)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ @$list['product'] ?? 'N/A' }}</td>
                        <td>{{ @$list['unit'] ?? 'N/A' }}</td>
                        <td class="text-right">{{ @$list['demand_quantity'] ?? 'N/A' }}</td>
                        <td class="text-right">{{ @$list['distribute_quantity'] ?? 'N/A' }}</td>
                        <td class="text-right">{{ @$list['temporary_stock'] ?? 'N/A' }}</td>
                        <td class="text-right">{{ @$list['current_stock'] ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
