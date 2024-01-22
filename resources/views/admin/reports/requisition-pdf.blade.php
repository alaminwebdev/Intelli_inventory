@extends('admin.layouts.pdf')

@section('pdf-title')
    চাহিদাপত্র নাম্বার - {{ en2bn($requestedRequisitionInfo->requisition_no) }}
@endsection

@php
    if ($requestedRequisitionInfo->status == 0) {
        $status = 'সুপারিশের জন্য প্রেরন করা হয়েছে';
    } elseif ($requestedRequisitionInfo->status == 1) {
        $status = 'সুপারিশ করা হয়েছে';
    } elseif ($requestedRequisitionInfo->status == 2) {
        $status = 'প্রত্যাখ্যান করা হয়েছে';
    } elseif ($requestedRequisitionInfo->status == 3) {
        $status = 'অনুমোদন করা হয়েছে';
    } elseif ($requestedRequisitionInfo->status == 4) {
        $status = 'বিতরণ করা হয়েছে';
    }elseif ($requestedRequisitionInfo->status == 5) {
        $status = 'গ্রহন করা হয়েছে';
    } else {
        $status = '';
    }
@endphp


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
            <p style="margin: 0; width:50%; float:left;">চাহিদাপত্র নাম্বার : {{ en2bn($requestedRequisitionInfo->requisition_no) }}</p>
            <p style="margin: 0; width:50%; float:right; text-align:right">তারিখ : {{ $date_in_bengali }}</p>
        </div>
        <p style="margin: 0;">অনুরোধকৃত দপ্তর : {{ @$requestedRequisitionInfo->section->department->name }}</p>
        <p style="margin: 0;">অনুরোধকৃত শাখা : {{ @$requestedRequisitionInfo->section->name }}</p>
        <p style="margin: 0;">বর্তমান অবস্থা : {{ $status }}</p>
    </div>
    @if (@$requisitionProducts && count(@$requisitionProducts) > 0)
        <table class="table table-bordered" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th class="text-left" width="10%">ক্রমিক নং:</th>
                    <th class="text-center" width="30%">পন্য</th>
                    <th class="text-center">বর্তমান মজূদ</th>
                    <th class="text-center">চাহিদার পরিমান</th>
                    <th class="text-center">সুপারিশ পরিমান</th>
                    <th class="text-center">অনুমোদিত পরিমান</th>
                    <th class="text-center">বিতরন পরিমান</th>
                    <th class="text-center">যৌক্তিকতা</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 0;
                @endphp

                @foreach ($requisitionProducts as $list)
                    @foreach ($list['products'] as $product)
                        <tr>
                            <td>{{ en2bn(++$counter) }}</td>
                            <td>{{ $product['product_name'] }}</td>
                            <td class="text-right">{{ en2bn($product['current_stock']) }}</td>
                            <td class="text-right">{{ en2bn($product['demand_quantity']) }}</td>
                            <td class="text-right">{{ en2bn($product['recommended_quantity']) }}</td>
                            <td class="text-right">{{ en2bn($product['final_approve_quantity']) }}</td>
                            <td class="text-right">{{ en2bn($product['total_distribute_quantity']) }}</td>
                            <td>
                                @php
                                    if ($requestedRequisitionInfo->status == 0) {
                                        echo $product['remarks'];
                                    } elseif ($requestedRequisitionInfo->status == 1 || $requestedRequisitionInfo->status == 2) {
                                        echo $product['recommended_remarks'];
                                    } elseif ($requestedRequisitionInfo->status == 3) {
                                        echo $product['final_approve_remarks'];
                                    } elseif ($requestedRequisitionInfo->status == 4) {
                                        echo $product['final_approve_remarks'];
                                    } else {
                                        echo '';
                                    }
                                @endphp
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>

        <div style="width: 100%; margin-top: 80px; font-size: 12px;">
            @if ($requestedRequisitionInfo->status == 0 || $requestedRequisitionInfo->status == 1 || $requestedRequisitionInfo->status == 3)
                <div style="width: 30%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->requisition_owner->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->requisition_owner->name ?? 'Not available' }}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">চাহিদাকারী</p>
                </div>
                <div style="width: 40%; float: left; text-align: center;">
                    <p style="margin: 0; {{ @$requestedRequisitionInfo->recommended_user->name ? '' : 'visibility: hidden;'  }}" >{{ @$requestedRequisitionInfo->recommended_user->name ?? 'Not available'}}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 80px; padding: 5px; border-top: 1px dotted black;">সুপারিশকারী</p>
                </div>
                <div style="width: 30%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->approve_user->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->approve_user->name ?? 'Not available' }}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">মঞ্জুরকারী</p>
                </div>
            @elseif ($requestedRequisitionInfo->status == 4 || $requestedRequisitionInfo->status == 5)
                <div style="width: 30%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->requisition_owner->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->requisition_owner->name ?? 'Not available' }}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">চাহিদাকারী</p>
                </div>
                <div style="width: 40%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->distribute_user->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->distribute_user->name ?? 'Not available' }}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 80px; padding: 5px; border-top: 1px dotted black;">বিতরনকারী</p>
                </div>
                <div style="width: 30%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->name ?? 'Not available' }}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">গ্রহনকারী</p>
                </div>
            @endif
        </div>

    @endif
@endsection
