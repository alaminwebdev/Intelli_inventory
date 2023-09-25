@extends('admin.layouts.pdf')

@section('pdf-title')
    ক্রয় অর্ডার - {{ $stock_info->po_no }}
@endsection


@section('pdf-header')
    <p style="font-size: 11px;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</p>
    <p style="font-size: 11px;">বাংলাদেশ পুলিশ</p>
    <p style="font-size: 11px;">স্পেশাল ব্রাঞ্চ - পুলিশ হেডকোয়ার্টার্স, ঢাকা।</p>
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

    <div>
        <p style="font-size: 12px; margin: 0; margin: 10px 0;">ক্রয় অর্ডার নাম্বার :  {{ $stock_info->po_no }}</p>
    </div>

    @if (@$stock_details && count(@$stock_details) > 0)
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-left" width="10%">ক্রমিক নং.</th>
                    <th class="text-center">পন্য</th>
                    <th class="text-center">অর্ডার পরিমাণ</th>
                    <th class="text-center">পূর্ববর্তী রিসিভ পরিমাণ</th>
                    <th class="text-center">রিসিভ পরিমাণ</th>
                    <th class="text-center">বাকি</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($stock_details as $product)
                    <tr>
                        <td>{{ en2bn($loop->iteration) }}</td>
                        <td>{{ $product->product }}</td>
                        <td class="text-right">{{ en2bn($product->po_qty) }}</td>
                        <td class="text-right">{{ en2bn($product->prev_receive_qty) }}</td>
                        <td class="text-right">{{ en2bn($product->receive_qty) }}</td>
                        <td class="text-right">{{ en2bn($product->reject_qty) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection
