@extends('admin.layouts.pdf')

@section('pdf-title')
    চাহিদাপত্র নাম্বার - {{ en2bn($requestedRequisitionInfo->requisition_no) }}
@endsection

@php
    if ($requestedRequisitionInfo->status == 0) {
        $status = 'অপেক্ষারত';
    } elseif ($requestedRequisitionInfo->status == 1) {
        $status = 'সুপারিশ সম্পন্ন';
    } elseif ($requestedRequisitionInfo->status == 2) {
        $status = 'প্রত্যাখ্যাত';
    } elseif ($requestedRequisitionInfo->status == 3) {
        $status = 'অনুমোদিত';
    }elseif ($requestedRequisitionInfo->status == 4) {
        $status = 'বিতরন করা হয়েছে';
    }else{
        $status = '';
    }
@endphp


@section('pdf-header')
    <p style="font-size: 18px;">চাহিদাপত্র নাম্বার - {{ en2bn($requestedRequisitionInfo->requisition_no) }}</p>

    <p style="font-size: 11px;">অনুরোধকৃত ডিপার্টমেন্ট : {{ $requestedRequisitionInfo->section->name }}</p>
    <p style="font-size: 11px;">বর্তমান অবস্থা : {{ $status }}</p>
    <p style="font-size: 11px;">তারিখ : {{ $date_in_bengali }}</p>
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

    @if (@$requisitionProducts && count(@$requisitionProducts) > 0)
        @foreach ($requisitionProducts as $list)
            <div>
                <p style="font-size: 12px; margin: 0; margin-top: 25px;">প্রোডাক্ট ক্যাটাগরি : {{ $list['name'] }}</p>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="text-left" width="10%">ক্রমিক নং:</th>
                        <th class="text-center">পন্যের তথ্য</th>
                        <th class="text-center">বর্তমান মজূদ</th>
                        <th class="text-center">চাহিদার পরিমান</th>
                        <th class="text-center">সুপারিশ পরিমান</th>
                        <th class="text-center">অনুমোদিত পরিমান</th>
                        <th class="text-center">বিতরন পরিমান</th>
                        <th class="text-center">যৌক্তিকতা</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($list['products'] as $product)
                        <tr>
                            <td>{{ en2bn($loop->iteration) }}</td>
                            <td>{{ $product['product_name'] }}</td>
                            <td class="text-right">{{ en2bn($product['current_stock']) }}</td>
                            <td class="text-right">{{ en2bn($product['demand_quantity']) }}</td>
                            <td class="text-right">{{ en2bn($product['recommended_quantity']) }}</td>
                            <td class="text-right">{{ en2bn($product['final_approve_quantity']) }}</td>
                            <td class="text-right">{{ en2bn($product['total_distribute_quantity']) }}</td>
                            <td>{{ $product['approve_remarks'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        @endforeach
    @endif
@endsection
