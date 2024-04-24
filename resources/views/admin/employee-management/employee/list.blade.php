@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.employee.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Officer</a>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th>Name</th>
                                        <th>B.P.</th>
                                        <th>Department</th>
                                        <th>Section</th>
                                        <th>Designations</th>
                                        <th>Status</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($employees as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->name ?? 'N/A' }}</td>
                                            <td>{{ @$list->bp_no ?? 'N/A' }}</td>
                                            <td>{{ @$list->department ?? 'N/A' }}</td>
                                            <td>{{ @$list->section ?? 'N/A' }}</td>
                                            <td>{{ @$list->designations ?? 'N/A' }}</td>

                                            <td>{!! activeStatus($list->status) !!}</td>
                                            <td class="text-center">
                                                @if (sorpermission('admin.employee.edit'))
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.employee.edit', $list->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                {{-- @if (sorpermission('admin.employee.delete'))
                                                    <a class="btn btn-sm btn-danger destroy" data-id="{{ $list->id }}" data-route="{{ route('admin.employee.delete') }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                @endif --}}
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
