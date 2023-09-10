@extends('backend.layouts.app')
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h4 class="m-0 text-dark"> @lang('List of FAQ')</h4> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('FAQ')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content-header -->
    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <script type="text/javascript">
                $(function() {
                    $.notify("{{ $error }}", {
                        globalPosition: 'top right',
                        className: 'error'
                    });
                });
            </script>
        @endforeach
    @endif
    <div class="content">
        <div class="container-fluid">
            <div class="col-md-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h5>@lang('FAQ') @lang('List')
                            <a class="btn btn-sm btn-primary float-right" href="{{ route('site-setting.faq.add') }}"><i
                                    class="fa fa-plus-circle"></i> @lang('FAQ') @lang('Add')</a>
                        </h5>
                    </div>
                    <div class="card-body">
                        <table id="dataTable" class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>@lang('SL')</th>
                                    <th>Question</th>
                                    <th>Answer</th>
                                    <th style="width:10%">@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($faq_lists as $faq_list)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ @$faq_list->question }}</td>
                                        <td>{!! \Illuminate\Support\Str::limit( @$faq_list->answer, $limit = 150, $end = '...') !!}</td>
                                        <td>
                                            <a class="btn btn-sm btn-primary" title="Edit"
                                                href="{{ route('site-setting.faq.edit', @$faq_list->id) }}"><i
                                                    class="fa fa-edit"></i></a>
                                            <a class="delete btn btn-sm btn-danger" title="Delete"
                                                data-id="{{ @$faq_list->id }}" data-token="{{ csrf_token() }}"
                                                data-route="{{ route('site-setting.faq.delete') }}"><i class="fa fa-trash"></i></a>
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

@endsection
