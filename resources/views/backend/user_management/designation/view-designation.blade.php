@extends('backend.layouts.app')
@section('content')
 <!-- Content Header (Page header) -->
 <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"> @lang('List of Designations')</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
            <li class="breadcrumb-item active">@lang('Designation')</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
<!-- /.content-header -->
@if ($errors->any())
  @foreach ($errors->all() as $error)
  <script type="text/javascript">
    $(function () {
      $.notify("{{$error}}", {globalPosition: 'top right', className: 'error'});
    });
  </script>
  @endforeach
  @endif
<div class="content">
  <div class="container-fluid">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <h5>@lang('Designation') @lang('List')
            <a class="btn btn-sm btn-success float-right" href="{{route('user.designation.add')}}"><i class="fa fa-plus-circle"></i> @lang('Designation') @lang('Add')</a>
          </h5>
        </div>
          <div class="card-body">
            <table id="dataTable" class="table table-sm table-bordered table-striped">
              <thead>
                <tr>
                  <th>@lang('SL')</th>
                  <th>@lang('Designation') @lang('Name')</th>
                  <th>@lang('Action')</th>
                </tr>
              </thead>
              <tbody>
                @foreach($designations as $designation)
                <tr>
                  <td>{{$loop->iteration}}</td>
                  <td>{{$designation['name']}}</td>
                  <td><a href="{{route('user.designation.edit',$designation->id)}}" class="btn btn-primary btn-flat btn-sm edit" data-type="image" data-id="" data-table=""><i class="fas fa-edit"></i></a>
                    <a class="delete btn btn-danger btn-flat btn-sm" data-route="{{ route('user.designation.delete') }}" data-id="{{ $designation->id }}" data-token="{{ csrf_token() }}" ><i class="fas fa-trash"></i></a>
                </tr>
                @endforeach
                {{-- <tr>
                  <td>1</td>
                  <td>Designation 1</td>
                  <td>
                    
                  </td>
                </tr> --}}
              </tbody>
            </table>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection
