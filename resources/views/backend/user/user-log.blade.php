@extends('backend.layouts.app')
@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h2 class="m-0 text-dark">@lang('Audit Log')</h2>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
          <li class="breadcrumb-item active">@lang('Logs')</li>
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
          <div class="card-body">
            <table id="dataTable" class="table table-sm table-bordered table-striped">
              <thead>
                  <tr>
                    <th class="min-width">@lang('SL')</th>
                    <th>@lang('Table Name')</th>
                    <th>@lang('Changed By')</th>
                    <th>@lang('What Changed')</th>
                    <th>@lang('Changed At')</th>
                  </tr>
              </thead>
              <tbody>
                @foreach ($get_log as $log)
                <tr>
                  @if(session()->get('language') == 'en')
                    <td>{{$loop->iteration}}</td>
                  @else
                    <td>{{ \App\Helpers\BanglaConverter::en2bn($loop->iteration) }}</td>
                  @endif
                  <td>{{$log->table_name}}</td>
                  <td>{{$log->who_changed}}</td>
                  @if(session()->get('language') =='en')
                  <td>{!!$log->what_changed_en!!}</td>
                  @else 
                  <td>{!!$log->what_changed_bn!!}</td>
                  @endif
                  <td>{{date('d-M-Y h:i a',strtotime($log->created_at))}}</td>
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