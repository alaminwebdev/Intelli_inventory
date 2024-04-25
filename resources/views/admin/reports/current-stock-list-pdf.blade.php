@extends('admin.layouts.pdf')

@section('pdf-title')
    Current Stock - {{ $date_in_english }}
@endsection

@section('pdf-header')
    <p style="font-size: 12px;">Intelli Inventory</p>
    <p style="font-size: 12px;">Current Stock Report as of {{ date('d-M-Y h:i a') }}</p>
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
    {{-- <div style="margin-top: 10px; font-size: 12px;">
        <div style="width:100%">
            <p style="margin: 0; width:50%; float:left;">Current Stock Report</p>
            <p style="margin: 0; width:50%; float:right; text-align:right">তারিখ : {{ $date_in_english }}</p>
        </div>
    </div> --}}

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" width="10%">Sl.</th>
                <th class="text-center" width="70%">Product</th>
                <th class="text-center" width="20%">Current Stock</th>
            </tr>
        </thead>
        <tbody>
            @if (@$current_stock && count(@$current_stock) > 0)
                @foreach ($current_stock as $list)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ @$list->product_name }}({{ @$list->unit_name }})</td>
                        <td class="text-right">{{ @$list->available_qty ? @$list->available_qty : 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
