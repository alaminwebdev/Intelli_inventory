@extends('admin.layouts.pdf')

@section('pdf-title')
    Requisition List - {{ $date_in_english }}
@endsection

@section('pdf-header')
    <p style="font-size: 12px;">Intelli Inventory</p>
    <p style="font-size: 12px;">Requisition List</p>
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
            {{-- <p style="margin: 0; width:50%; float:left;">Department : {{ $department ? $department->name : 'সবগুলি'  }}  - Section : {{ @$section ? $section->name : 'সবগুলি'  }} </p> --}}
            <p style="margin: 0; width:50%; float:right; text-align:right">Date : {{ $date_from }} - {{ $date_to }}</p>
        </div>
    </div>

    <table class="table table-bordered" style="margin-top: 10px;">
        <thead>
            <tr>
                <th class="text-left" width="5%">Sl.</th>
                <th class="text-center">Requisition No.</th>
                <th class="text-center">Requested Section</th>
                <th class="text-center">Requested Department</th>
                <th class="text-center">Status</th>
                <th class="text-center" id="requisition_date">Date</th>
            </tr>
        </thead>
        <tbody>
            @if (@$sectionRequisitions && count(@$sectionRequisitions) > 0)
                @foreach ($sectionRequisitions as $list)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                        <td>{{ @$list->section->name ?? 'N/A' }}</td>
                        <td>{{ @$list->section->department->name ?? 'N/A' }}</td>
                        <td>
                            @if ($list->status == 3)
                                Approved
                            @elseif ($list->status == 4)
                                Distributed
                            @else
                                Initiated 
                            @endif
                        </td>
                        <td>
                            @if ($list->status == 3)
                                {{date('d-M-Y', strtotime($list->final_approve_at))}}
                            @elseif ($list->status == 4)
                                {{ date('d-M-Y', strtotime($list->distribute_at)) }}
                            @else
                                {{ date('d-M-Y', strtotime($list->created_at)) }}
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
