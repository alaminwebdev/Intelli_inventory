@extends('backend.layouts.app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">@lang('Ministry') @lang('User') @lang('Manage')</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
          <li class="breadcrumb-item active">@lang('Ministry') @lang('User')</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<section class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5>@lang('Ministry') @lang('User') @lang('List')
              <a class="btn btn-sm btn-success float-right" href="{{route('user.ministry.add')}}"><i class="fa fa-plus-circle"></i> @lang('User') @lang('Add')</a>
            </h5>
          </div>
          <div class="card-body">
            <table id="dataTable" class="table table-sm table-bordered table-striped">
              <thead>
                  <tr>
                    <th class="min-width">@lang('SL')</th>
                    <th>@lang('User') @lang('Name')</th>
                    <th>@lang('Ministry') @lang('Name')</th>
                    <th>@lang('Designation')</th>
                    <th>@lang('Department')</th>
                    <th>@lang('Action')</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($data as $ministry_data)
                <tr>
                  <td>{{$loop->index+1}}</td>
                  <td>{{$ministry_data->user_name->name}}</td>
                  <td>{{$ministry_data->ministry_name->name_bn}}</td>
                  {{-- @if(session()->get('language') =='en')
                  <td>{!!$log->what_changed_en!!}</td>
                  @else
                  <td>{!!$log->what_changed_bn!!}</td>
                  @endif --}}
                  <td>{{$ministry_data->designation}}</td>
                  <td>{{$ministry_data->department}}</td>
                  {{-- <td>{{date('d-M-Y H:i a',strtotime($ministry_data->created_at))}}</td> --}}
                  <td>
                    <a href="{{route('ministry.user.edit',$ministry_data->id)}}" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-sm btn-danger" id="delete" title="Delete" data-id="{{$ministry_data->id}}" data-token="{{csrf_token()}}" href="{{route('ministry.user.delete')}}"><i class="fa fa-trash"></i></a>
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

</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#demo-btn-addrow").click(function(){
      $("input[type=text],select,input[type=number]").val("");
    });
    var err='{{count($errors->all())}}';
    if(err>0){
      $('#myModal').modal('show');
    }
  });

  $(".editRole").click(function(){
    var roleid = $(this).attr('data-id');
    $.ajax({
      url: "{{ route('user.role.edit') }}",
      type: "GET",
      data: {'id' : roleid},
      success: function(data){
        var actionUrl = '{{route("user.role.update", "/")}}'+'/'+data.id;
        $('#id').val(data.id);
        $('#name').val(data.name);
        $('#description').val(data.description);
        $('#submitButton').text('Update Role');
        $('#menuForm').attr('action', actionUrl);
        $('#myModal').modal('show');
      }
    });
  });


</script>
@endsection
