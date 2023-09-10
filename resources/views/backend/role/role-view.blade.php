@extends('backend.layouts.app')
@section('content')
 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">List of Roles</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Manage Role</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
        	<div class="col-lg-12">
	        	<div class="card">
	        		<div class="card-header">
	        			<a href="{{route('project-management.role.add')}}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add Role </a>
	        		</div>
		            <div class="card-body">
		              <table id="dataTable" class="table table-sm table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th width="120">#</th>
		                  <th>Resource Role</th>
                          <th width="80">Action</th>
		                </tr>
		                </thead>
		                <tbody>
		                @foreach($role as $key => $r)
                    {{-- @php

                    $d[$key] = Crypt::encryptString($r['id']);


                    @endphp --}}
		                <tr>
		                  <td> {{$loop->iteration}}</td>
                      <td>{{ $r['name'] }}</td>
		                  	<td>
                          <a href="{{ route('project-management.role.edit',$r->id) }}" class="btn btn-primary btn-flat btn-sm edit" data-type="image" data-id="" data-table="Slider"><i class="fas fa-edit"></i></a> |
                          <a  class="delete btn btn-danger btn-flat btn-sm" data-route = "{{ route('project-management.role.delete') }}"  data-id="{{$r->id}}" data-table="roles" ><i class="fas fa-trash"></i></a>

                          {{-- <a class="btn btn-sm btn-danger delete" title="Delete" data-id="{{$r->id}}" data-tablename="roles"><i class="fa fa-trash"></i></a> --}}
		                  </td>
		                </tr>
		                @endforeach
		                </tbody>
		              </table>
		            </div>
	            <!-- /.card-body -->
          		</div>
          <!-- /.card -->
        	</div>
        </div>
      </div>
      <!--/. container-fluid -->
    </section>
<script>
    function ConfirmDelete()
    {
      var x = confirm("Are you sure you want to delete?");
      if (x)
          return true;
      else
        return false;
    }
</script> @endsection

