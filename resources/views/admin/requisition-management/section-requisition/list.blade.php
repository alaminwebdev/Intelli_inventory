@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.section.requisition.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Section Requisition</a>
                        </div>
                        <div class="card-body">
                            
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">SL.</th>
                                        <th>Requisition No</th>
                                        <th>Product</th>
                                        <th>Current Stock</th>
                                        <th>Demand Quantity</th>
                                        <th>Status</th>
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
                                        @if (count($sectionRequisitionProducts) > 0)
                                            @php $rowspan = count($sectionRequisitionProducts); @endphp
                                            @foreach ($sectionRequisitionProducts as $item)
                                                <tr>
                                                    @if ($loop->first)
                                                        <td rowspan="{{ $rowspan }}">{{ $loop->parent->iteration }}</td>
                                                        <td rowspan="{{ $rowspan }}">{{ @$list->requisition_no ?? 'N/A' }}</td>
                                                    @endif
                                                    <td>{{ $item->product }}</td>
                                                    <td class="text-right">{{ $item->current_stock }}</td>
                                                    <td class="text-right">{{ $item->demand_quantity }}</td>
                                                    @if ($loop->first)
                                                        <td rowspan="{{ $rowspan }}" class="text-center">{!! activeRequisition($list->status) !!}</td>
                                                    @endif
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ @$list->requisition_no ?? 'N/A' }}</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td class="text-center">{!! activeRequisition($list->status) !!}</td>
                                            </tr>
                                        @endif
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
