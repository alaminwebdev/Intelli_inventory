@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-info"><i class="fas fa-tachometer-alt mr-1"></i>ড্যাশবোর্ড</a>
                        </div>
                        <div class="card-body">

                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং.</th>
                                        <th>চাহিদাপত্র নাম্বার</th>
                                        <th>শাখা</th>
                                        <th>পন্য</th>
                                        <th>বর্তমান মজূদ</th>
                                        <th>চাহিদার পরিমান</th>
                                        <th>সুপারিশ পরিমান</th>
                                        <th>অনুমোদিত পরিমান</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sectionRequisitionProducts as $list)
                                        <tr>
                                            <td>{{ en2bn($loop->iteration) }}</td>
                                            <td>{{ en2bn(@$list->requisition_no) ?? 'N/A' }}</td>
                                            <td>{{ @$list->section ?? 'N/A' }}</td>
                                            <td>{{ @$list->product }} ({{ @$list->unit }})</td>
                                            <td class="text-right">{{ en2bn(@$list->current_stock) ?? 'N/A' }}</td>
                                            <td class="text-right">{{ en2bn(@$list->demand_quantity) ?? 'N/A' }}</td>
                                            <td class="text-right">{{ en2bn(@$list->recommended_quantity) ?? 'N/A' }}</td>
                                            <td class="text-right">{{ en2bn(@$list->final_approve_quantity) ?? 'N/A' }}</td>
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
@endsection
