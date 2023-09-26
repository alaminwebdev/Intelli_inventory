@extends('admin.layouts.pdf')

@section('pdf-title')
    বর্তমান মজুদ - {{ $date_in_bengali }}
@endsection

@section('pdf-header')
    <p style="font-size: 12px;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>
    <p style="font-size: 12px;">বাংলাদেশ পুলিশ</p>
    <p style="font-size: 12px;">স্পেশাল ব্রাঞ্চ , ঢাকা।</p>
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
            <p style="margin: 0; width:50%; float:left;">বর্তমান মজুদ রিপোর্ট</p>
            <p style="margin: 0; width:50%; float:right; text-align:right">তারিখ : {{ $date_in_bengali }}</p>
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" width="10%">ক্রমিক নং:</th>
                <th class="text-center" width="70%">পন্য</th>
                <th class="text-center" width="20%">বর্তমান মজুদ</th>
            </tr>
        </thead>
        <tbody>
            @if (@$current_stock && count(@$current_stock) > 0)
                @foreach ($current_stock as $list)
                    <tr>
                        <td>{{ en2bn($loop->iteration) }}</td>
                        <td>{{ @$list->product_name }}({{ @$list->unit_name }})</td>
                        <td class="text-right">{{ @$list->available_qty ? en2bn(@$list->available_qty) : 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
