@extends('backend.layouts.app')
@section('content')
 <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Manage Post</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Post</li>
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
	        			<a href="{{ route('frontend-menu.post.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add Post</a>
	        		</div>
		            <div class="card-body">
		              <table id="dataTable" class="table table-sm table-bordered table-striped">
		                <thead>
		                <tr>
		                  <th>#SL</th>
		                  <th>Title</th>
                      {{-- <th>Discription</th> --}}
                      <th width="80">Action</th>
		                </tr>
		                </thead>
		                <tbody>
		                  @foreach($posts as $key => $post)	
  		                <tr>		                  	                 
  		                  <td> {{$key+1}}</td>
                        <td>{{$post->title}}</td>
                          {{-- <td>@php echo $post->description @endphp</td> --}}
  		                  	<td><a href="{{route('frontend-menu.post.edit',$post->id)}}" class="btn btn-primary btn-flat btn-sm edit" data-type="image" data-id="" data-table="Slider"><i class="fas fa-edit"></i></a>
                            <a class="delete btn btn-danger btn-flat btn-sm" data-route="{{ route('frontend-menu.post.destroy') }}" data-id="{{ $post->id }}" data-token="{{csrf_token()}}"><i class="fas fa-trash"></i></a>
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

