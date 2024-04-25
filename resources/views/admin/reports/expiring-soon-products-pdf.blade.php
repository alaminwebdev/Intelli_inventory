@extends('admin.layouts.pdf')

@section('pdf-title')
 Expiring Soon Products - {{ $date_in_english }}
@endsection

@section('pdf-header')
    <p style="font-size: 12px;">Intelli Inventory</p>
    <p style="font-size: 12px;">Expiring Soon Products Report</p>
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
            <p style="margin: 0; width:50%; float:left;">Expiring Soon Products</p>
            <p style="margin: 0; width:50%; float:right; text-align:right">Date : {{ $date_in_english }}</p>
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" width="5%">Sl.</th>
                <th class="text-center" width="15%">PO No.</th>
                <th class="text-center" width="60%">Product</th>
                <th class="text-center" width="20%">Expire Date</th>
            </tr>
        </thead>
        <tbody>

            @if (@$expiringSoonProducts && count(@$expiringSoonProducts) > 0)
                @foreach ($expiringSoonProducts as $product)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $product->po_no }}</td>
                        <td>{{ $product->product }}({{ $product->unit }})</td>
                        <td>
                            @if ($product->expire_date)
                                @php
                                    $expireDate = \Carbon\Carbon::parse($product->expire_date);
                                    $daysUntilExpiration = $expireDate->diffInDays(\Carbon\Carbon::now());
                                @endphp
                                {{-- {{ en2bn($daysUntilExpiration) . ' দিনের মধ্যে মেয়াদ শেষ হবে' }} --}}
                                Expire in {{ $daysUntilExpiration }} day{{ $daysUntilExpiration != 1 ? 's' : '' }}
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
