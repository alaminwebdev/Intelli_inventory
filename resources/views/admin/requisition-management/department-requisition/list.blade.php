@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.department.requisition.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Department Requisition</a>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">SL.</th>
                                        <th>Requisition No</th>
                                        <th>Requisition Details</th>
                                        <th>Status</th>
                                        {{-- <th width="15%">Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectionRequisitions as $list)
                                        @php
                                            $sectionRequisitionProducts = \App\Models\SectionRequisitionDetails::join('product_information', 'product_information.id', 'section_requisition_details.product_id')
                                                ->where('section_requisition_id', $list->id)
                                                ->select('section_requisition_details.current_stock as current_stock', 'section_requisition_details.demand_quantity as demand_quantity', 'product_information.name as product')
                                                ->get();
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                                            <td>
                                                @foreach (@$sectionRequisitionProducts as $item)
                                                    <ul class="{{ $loop->last ? '': 'border-bottom pb-3' }}">
                                                        <li class="">Product Name: {{ $item->product }} </li>
                                                        <li class="">Current Stock: {{ $item->current_stock }} </li>
                                                        <li class="">Demand Quantity: {{ $item->demand_quantity }} </li>
                                                    </ul>
                                                @endforeach
                                            </td>
                                            <td class="text-center">{!! activeRequisition($list->status) !!}</td>
                                            {{-- <td>
                                                @if (sorpermission('admin.section.edit'))
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.section.edit', $list->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if (sorpermission('admin.section.delete'))
                                                    <a class="btn btn-sm btn-danger destroy" data-id="{{ $list->id }}" data-route="{{ route('admin.section.delete') }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script></script>
@endsection
