@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.section.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Section</a>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">Sl.</th>
                                        <th>Section</th>
                                        <th>Department</th>
                                        <th>Sort</th>
                                        <th>Status</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sections as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->name ?? 'N/A' }}</td>
                                            <td>{{ @$list->department_name ?? 'N/A' }}</td>
                                            <td>{{ @$list->sort ?? 'N/A' }}</td>

                                            <td>{!! activeStatus($list->status) !!}</td>
                                            <td>
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
