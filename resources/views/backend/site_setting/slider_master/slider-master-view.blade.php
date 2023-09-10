@extends('backend.layouts.app')
@section('content')
 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            {{-- <h1 class="m-0 text-dark">Manage Slider</h1> --}}
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
              <li class="breadcrumb-item active">Slider</li>
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
	        	<div class="card card-outline card-primary ">
	        		<div class="card-header ">
                    <h5 class="m-0 text-dark float-left">Manage Slider</h5>
                    <a href="{{ route('site-setting.slider-master.add') }}" class="btn btn-sm btn-info float-right"><i class="fas fa-plus"></i> Add Slider</a>
                <div class="card-tools">
                  {{-- <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fas fa-minus"></i>
                  </button> --}}
                </div>
                <!-- /.card-tools -->
	        		</div>
		            <div class="card-body">
		              <table id="dataTable" class="table table-sm table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>#</th>
                      <th>Name</th>
                      <th>Animation Type</th>
                      <th>Image</th>
                      <th width="80">Action</th>
		                </tr>
		                </thead>
		                <tbody>
		                @foreach($sliderMaster as $p)
		                <tr>
		                    <td> {{$loop->iteration}}</td>
                        <td>{!!  $p['name']   !!}</td>
                        <td>{!!  $p['animation_type']   !!}</td>
		                  	<td><a href="{{ route('site-setting.slider',$p->id) }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> View</a></td>
                    <td><a href="{{ route('site-setting.slider-master.edit',$p->id) }}" class="btn btn-primary btn-flat btn-sm edit" data-type="image" data-id="" data-table="Slider"><i class="fas fa-edit"></i></a> | <a class="delete btn btn-danger btn-flat btn-sm" data-route = "{{ route('site-setting.slider-master.delete') }}" data-id="{{ $p->id }}" data-token="{{ csrf_token() }}"><i class="fas fa-trash"></i></a>
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
@endsection

