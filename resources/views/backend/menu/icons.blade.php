@extends('backend.layouts.app')
@section('content')
<div class="col-xl-12">
    <div class="breadcrumb-holder">
        <h1 class="main-title float-left">Icon List</h1>
        <ol class="breadcrumb float-right">
            <li class="breadcrumb-item"><a href="{{route('dashboard')}}"><strong>Home</strong></a></li>
            <li class="breadcrumb-item"><a href="{{route('menu')}}">Menu</a></li>
            <li class="breadcrumb-item active">Menu Icon</li>
        </ol>
        <div class="clearfix"></div>
    </div>
</div>
<div class="container fullbody">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
               <button id="demo-btn-addrow" class="btn btn-success btn-sm" data-toggle="modal"
               data-target="#myModal">
               <i class="ion-plus"></i> Add Icon
           </button>
           <!-- <a class="btn btn-info pull-right" data-toggle="modal" data-target="#iconListModal"><i class="fa fa-list"></i> View Icon List</a> -->
       </div>
       <div class="card-body">
        <table class="table table-sm table-striped table-bordered" id="datatable">
          <thead>
            <tr>
                <th class="min-width">SL</th>
                <th>Icon Name</th>
                <th>View Icon</th>
                <th class="text-center">Action</th>
            </tr>
          </thead>
          <?php $i = 1; ?>
            <tbody>
                @foreach($icons as $icon)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $icon->name }}</td>
                    <td><i style="font-size: 20px" class="{{$icon->name}}"></i></td>
                    <td class="text-center">
                        <a class="editIcon btn btn-sm btn-info"><i class="fa fa-pencil-square-o"
                           aria-hidden="true"></i></a>
                           <a class="btn btn-sm btn-danger delete"
                           data-table="icons" data-id="{{$icon->id}}">
                           <i class="fa fa-trash" aria-hidden="true"></i>
                       </a>
                       <input class="iconId" type="hidden" value="{{ $icon->id }}"/>
                   </td>
               </tr>
               @endforeach
           </tbody>
        </table>


   </div>
</div>
</div>
<!--End page content-->

</div>

<!-- Modal -->
<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Create Icon</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="menuForm" action="{{ route('menu.icon.store') }}" method="post">
                {{ csrf_field()}}
                <div class="modal-body">
                    <div class="col-sm-12">
                        <div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
                            <label class="control-label">Icon Name</label>
                            <input data-toggle="modal" data-target="#iconListModal" type="text" id="name"
                            value="{{ old('name') }}" name="name" class="form-control"
                            placeholder="e.g ion-person" readonly="readonly">
                            @if ($errors->has('name'))
                            <span class="help-block">
                              <strong>{{ $errors->first('name') }}</strong>
                          </span>
                          @endif
                      </div>
                  </div>
              </div>
              <div class="modal-footer text-right">
                <button id="submitButton" class="btn btn-success" type="submit">Store Icon</button>
            </div>
        </form>
    </div>
</div>
</div>

<!--Bootstrap Modal-->
@include('backend.menu.icon-list')

<script type="text/javascript">
    $(document).ready(function () {
        $("#demo-btn-addrow").click(function () {
            $("input[type=text],select,input[type=number]").val("");
        });
        var err = '{{count($errors->all())}}';
        if (err > 0) {
            $('#myModal').modal('show');
        }
    });

    $(".editIcon").click(function () {
        var iconid = $(this).closest('tr').find('.iconId').val();
        $.ajax({
            url: "{{ route('menu.icon.edit') }}",
            type: "GET",
            data: {'id': iconid},
            success: function (data) {
                    // console.log(data);
                    var actionUrl = '{{route("menu.icon.update", "/")}}' + '/' + data.id;
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#submitButton').text('Update Menu');
                    $('#menuForm').attr('action', actionUrl);
                    $('#myModal').modal('show');
                }
            });
    });

    $(".demo-icon").click(function () {
        var icon = $(this).find('span').html();
        $('#name').val(icon);
        $('#iconListModal').modal('toggle');
    });

</script>
@endsection