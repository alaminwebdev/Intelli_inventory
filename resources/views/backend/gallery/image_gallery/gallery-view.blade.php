@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Manage Gallery</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Gallery</li>
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
          <a href="{{ route('homepages.gallery.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add Gallery</a>
          <a href="{{ route('homepages.gallery.category') }}" class="btn btn-sm btn-info" style="float: right;"><i class="fas fa-plus"></i>Setup Gallery Category</a>
        </div>
        <div class="card-body">
         <table id="dataTable" class="table table-sm table-bordered table-striped ">
          <thead>
            <tr>
              <th width="80">Sl</th>
              <th><center>Image</center> </th>
              <th><center>Category</center> </th>
              <th width="80">Action</th>
            </tr>
          </thead>
          <tbody>
           @foreach($gallery as $value)
           <tr>
            <td> {{$loop->iteration}}</td>
            <td><center><img src="{{asset('public/upload/gallery/'.$value->image) }}" width="80" height="80"></center> </td>
            <td> {{$value->categories->name}}</td>
            <td>
                <a href="{{ route('homepages.gallery.edit',$value->id) }}" class="btn btn-primary btn-flat btn-sm" data-type="image"><i class="fas fa-edit"></i></a> |
                 {{-- <a class="delete btn btn-danger btn-flat btn-sm" data-route="{{ route('homepages.gallery.delete') }}" data-id="{{ $value->id }}" ><i class="fas fa-trash"></i></a> --}}
                 <a class="btn btn-sm btn-danger" id="delete" title="Delete" data-id="{{$value->id}}" data-token="{{csrf_token()}}" href="{{route('homepages.gallery.delete')}}"><i class="fa fa-trash"></i></a>

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

