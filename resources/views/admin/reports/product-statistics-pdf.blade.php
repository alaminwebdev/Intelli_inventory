@extends('admin.layouts.pdf')

@section('pdf-title')
    পন্যের পরিসংখ্যান - {{ $date_in_bengali }}
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
            <p style="margin: 0; width:50%; float:left;">দপ্তর : {{ $department ? $department->name : 'সবগুলি'  }}  - শাখা : {{ @$section ? $section->name : 'সবগুলি'  }} </p>
            <p style="margin: 0; width:50%; float:right; text-align:right">তারিখ : {{ $date_from }} - {{ $date_to }}</p>
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" width="10%">নং:</th>
                <th class="text-center" width="50%">পন্য</th>
                <th class="text-center" width="10%">ইউনিট</th>
                <th class="text-center" width="15%">চাহিদার পরিমান</th>
                <th class="text-center" width="15%">বিতরনের পরিমান</th>
            </tr>
        </thead>
        <tbody>
            @if (@$productStatistics && count(@$productStatistics) > 0)
                @foreach ($productStatistics as $list)
                    <tr>
                        <td>{{ en2bn($loop->iteration) }}</td>
                        <td>{{ @$list['product'] ?? 'N/A' }}</td>
                        <td>{{ @$list['unit'] ?? 'N/A' }}</td>
                        <td class="text-right">{{ en2bn(@$list['demand_quantity']) ?? 'N/A' }}</td>
                        <td class="text-right">{{ en2bn(@$list['distribute_quantity']) ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
