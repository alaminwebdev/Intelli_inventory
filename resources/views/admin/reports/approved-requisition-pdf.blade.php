@extends('admin.layouts.pdf')

@section('pdf-title')
    বর্তমান স্টক - {{ $date_in_bengali }}
@endsection

@section('pdf-header')
    <p style="font-size: 18px;">বর্তমান স্টক রিপোর্ট</p>
    <p style="font-size: 11px;">
        তারিখ : {{ $date_in_bengali }}
    </p>
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

    <table class="table table-bordered">
        <thead>
            <tr>
                <th class="text-left" width="10%">ক্রমিক নং:</th>
                <th class="text-center">প্রোডাক্টের তথ্য</th>
                <th class="text-center">বর্তমান স্টক</th>
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
