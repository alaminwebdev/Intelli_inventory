@extends('admin.layouts.pdf')

@section('pdf-title')
    Requisition No. - {{ $requestedRequisitionInfo->requisition_no }}
@endsection

@php
    if ($requestedRequisitionInfo->status == 0) {
        $status = 'Initiated';
    } elseif ($requestedRequisitionInfo->status == 1) {
        $status = 'Recommended';
    } elseif ($requestedRequisitionInfo->status == 2) {
        $status = 'Rejected';
    } elseif ($requestedRequisitionInfo->status == 3) {
        $status = 'Approved';
    } elseif ($requestedRequisitionInfo->status == 4) {
        $status = 'Distributed';
    }elseif ($requestedRequisitionInfo->status == 5) {
        $status = 'Received';
    }elseif ($requestedRequisitionInfo->status == 6) {
        $status = 'Verified';
    }else {
        $status = '';
    }
@endphp


@section('pdf-header')
    <p style="font-size: 12px;">Intelli Inventory</p>
    <p style="font-size: 12px;">Requisition Report</p>
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
            <p style="margin: 0; width:50%; float:left;">Requisition No. : {{ $requestedRequisitionInfo->requisition_no }}</p>
            <p style="margin: 0; width:50%; float:right; text-align:right">Date : {{ $date_in_english }}</p>
        </div>
        <p style="margin: 0;">Requested Department : {{ @$requestedRequisitionInfo->section->department->name }}</p>
        <p style="margin: 0;">Requested Section : {{ @$requestedRequisitionInfo->section->name }}</p>
        <p style="margin: 0;">Status : {{ $status }}</p>
    </div>
    @if (@$requisitionProducts && count(@$requisitionProducts) > 0)
        <table class="table table-bordered" style="margin-top: 10px;">
            <thead>
                <tr>
                    <th class="text-left" width="10%">Sl.</th>
                    <th class="text-center" width="30%">Product</th>
                    <th class="text-center">Current Stock</th>
                    <th class="text-center">Demand Quantity</th>
                    <th class="text-center">Recommended Quantity</th>
                    <th class="text-center">Approved Quantity</th>
                    <th class="text-center">Distribute Quantity</th>
                    <th class="text-center">Remark</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $counter = 0;
                @endphp

                @foreach ($requisitionProducts as $list)
                    @foreach ($list['products'] as $product)
                        <tr>
                            <td>{{ ++$counter }}</td>
                            <td>{{ $product['product_name'] }}</td>
                            <td class="text-right">{{ $product['current_stock'] }}</td>
                            <td class="text-right">{{ $product['demand_quantity'] }}</td>
                            <td class="text-right">{{ $product['recommended_quantity'] }}</td>
                            <td class="text-right">{{ $product['final_approve_quantity'] }}</td>
                            <td class="text-right">{{ $product['total_distribute_quantity'] }}</td>
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
            {{-- @if ($requestedRequisitionInfo->status == 0 || $requestedRequisitionInfo->status == 1 || $requestedRequisitionInfo->status == 3) --}}
                <div style="width: 30%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->requisition_owner->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->requisition_owner->name ?? 'Not available' }}</p>
                    <p style="margin:0; {{ @$requestedRequisitionInfo->requisition_owner->employee->employee_designation->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->requisition_owner->employee->employee_designation->name ?? 'Not available' }}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">Requisition Owner</p>
                </div>
                <div style="width: 40%; float: left; text-align: center;">
                    <p style="margin: 0; {{ @$requestedRequisitionInfo->recommended_user->name ? '' : 'visibility: hidden;'  }}" >{{ @$requestedRequisitionInfo->recommended_user->name ?? 'Not available'}}</p>
                    <p style="margin:0; {{ @$requestedRequisitionInfo->recommended_user->employee->employee_designation->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->recommended_user->employee->employee_designation->name ?? 'Not available' }}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 80px; padding: 5px; border-top: 1px dotted black;">Recommender</p>
                </div>
                <div style="width: 30%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->approve_user->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->approve_user->name ?? 'Not available' }}</p>
                    <p style="margin:0; {{ @$requestedRequisitionInfo->approve_user->employee->employee_designation->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->approve_user->employee->employee_designation->name ?? 'Not available' }}</p>
                    {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                    <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">Approver</p>
                </div>
                
            {{-- @elseif ($requestedRequisitionInfo->status == 4 || $requestedRequisitionInfo->status == 5) --}}
                {{-- <div style="width: 30%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->requisition_owner->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->requisition_owner->name ?? 'Not available' }}</p>
                    <p style="margin:0; {{ @$requestedRequisitionInfo->requisition_owner->employee->employee_designation->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->requisition_owner->employee->employee_designation->name ?? 'Not available' }}</p>
                    <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">চাহিদাকারী</p>
                </div>
                <div style="width: 40%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->distribute_user->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->distribute_user->name ?? 'Not available' }}</p>
                    <p style="margin:0; {{ @$requestedRequisitionInfo->distribute_user->employee->employee_designation->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->distribute_user->employee->employee_designation->name ?? 'Not available' }}</p>
                    <p style="margin:0 80px; padding: 5px; border-top: 1px dotted black;">বিতরনকারী</p>
                </div>
                <div style="width: 30%; float: left; text-align: center;">
                    <p style="margin:0; {{ @$requestedRequisitionInfo->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->name ?? 'Not available' }}</p>
                    <p style="margin:0; {{ @$requestedRequisitionInfo->designation ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->designation ?? 'Not available' }}</p>
                    <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">গ্রহনকারী</p>
                </div> --}}
            {{-- @endif --}}
        </div>
        <div style="width: 100%; margin-top: 80px; font-size: 12px;">
            <div style="width: 50%; float: left; text-align: center;">
                <p style="margin:0; {{ @$requestedRequisitionInfo->distribute_user->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->distribute_user->name ?? 'Not available' }}</p>
                <p style="margin:0; {{ @$requestedRequisitionInfo->distribute_user->employee->employee_designation->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->distribute_user->employee->employee_designation->name ?? 'Not available' }}</p>
                {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                <p style="margin:0 80px; padding: 5px; border-top: 1px dotted black;">Distributor</p>
            </div>
            <div style="width: 50%; float: left; text-align: center;">
                <p style="margin:0; {{ @$requestedRequisitionInfo->name ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->name ?? 'Not available' }}</p>
                <p style="margin:0; {{ @$requestedRequisitionInfo->designation ? '' : 'visibility: hidden;'  }}">{{ @$requestedRequisitionInfo->designation ?? 'Not available' }}</p>
                {{-- <p style="margin:0; visibility: hidden;">signnature</p> --}}
                <p style="margin:0 50px; padding: 5px; border-top: 1px dotted black;">Receiver</p>
            </div>
        </div>

    @endif
@endsection
