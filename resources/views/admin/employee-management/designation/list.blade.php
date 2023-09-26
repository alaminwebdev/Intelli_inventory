@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.employee.designation.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> পদবী যোগ করুন</a>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং.</th>
                                        <th>পদবী</th>
                                        <th>সাজানো</th>
                                        <th>অবস্থান</th>
                                        <th width="15%">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($designations as $list)
                                        <tr>
                                            <td>{{ en2bn($loop->iteration) }}</td>
                                            <td>{{ @$list->name ?? 'N/A' }}</td>
                                            <td>{{ en2bn(@$list->sort) ?? 'N/A' }}</td>

                                            <td>{!! activeStatus($list->status) !!}</td>
                                            <td>
                                                @if (sorpermission('admin.employee.designation.edit'))
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.employee.designation.edit', $list->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if (sorpermission('admin.employee.designation.delete'))
                                                    <a class="btn btn-sm btn-danger destroy" data-id="{{ $list->id }}" data-route="{{ route('admin.employee.designation.delete') }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
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
