@extends('admin.layouts.pdf')

@section('pdf-title')
    মেয়াদ উত্তীর্ণ হওয়া পণ্য- {{ $date_in_bengali }}
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
            <p style="margin: 0; width:50%; float:left;">শীঘ্রই মেয়াদ উত্তীর্ণ হওয়া পণ্য</p>
            <p style="margin: 0; width:50%; float:right; text-align:right">তারিখ : {{ $date_in_bengali }}</p>
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" width="5%">নং:</th>
                <th class="text-center" width="15%">ক্রয় অর্ডার Sl.</th>
                <th class="text-center" width="60%">Product</th>
                <th class="text-center" width="20%">মেয়াদ শেষ হবার তারিখ</th>
            </tr>
        </thead>
        <tbody>

            @if (@$expiringSoonProducts && count(@$expiringSoonProducts) > 0)
                @foreach ($expiringSoonProducts as $product)
                    <tr>
                        <td>{{ en2bn($loop->iteration) }}</td>
                        <td>{{ $product->po_no }}</td>
                        <td>{{ $product->product }}({{ $product->unit }})</td>
                        <td>
                            @if ($product->expire_date)
                                @php
                                    $expireDate = \Carbon\Carbon::parse($product->expire_date);
                                    $daysUntilExpiration = $expireDate->diffInDays(\Carbon\Carbon::now());
                                @endphp
                                {{ en2bn($daysUntilExpiration) . ' দিনের মধ্যে মেয়াদ শেষ হবে' }}
                            @else
                                N/A
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
