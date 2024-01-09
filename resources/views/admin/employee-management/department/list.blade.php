@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.department.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> দপ্তর যুক্ত করুন</a>
                        </div>
                        <div class="card-body">
                            <table id="sb-data-table" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="5%">নং.</th>
                                        <th>দপ্তর</th>
                                        <th>সাজানো</th>
                                        <th>অবস্থান</th>
                                        <th width="15%">অ্যাকশন</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($departments as $list)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ @$list->name ?? 'N/A' }}</td>
                                            <td>{{ @$list->sort ?? 'N/A' }}</td>

                                            <td>{!! activeStatus($list->status) !!}</td>
                                            <td>
                                                @if (sorpermission('admin.department.edit'))
                                                    <a class="btn btn-sm btn-success" href="{{ route('admin.department.edit', $list->id) }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if (sorpermission('admin.department.delete'))
                                                    <a class="btn btn-sm btn-danger destroy" data-id="{{ $list->id }}" data-route="{{ route('admin.department.delete') }}">
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
