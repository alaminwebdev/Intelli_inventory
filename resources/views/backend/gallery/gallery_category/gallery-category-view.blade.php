@extends('backend.layouts.app')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">Manage Gallery Category</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active">Gallery Category</li>
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
          <a href="{{ route('homepages.gallery.category.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add Gallery Category</a>
        </div>
        <div class="card-body">
         <table id="dataTable" class="table table-sm table-bordered table-striped ">
          <thead>
            <tr>
              <th width="80">#</th>
              <th>Sort Number</th>
              <th>Gallery Category Name</th>
              {{-- <th><center>Gallery Image</center> </th> --}}
              <th width="80">Action</th>
            </tr>
          </thead>
          <tbody>
           @foreach($gallery_category as $value)
           <tr>
            <td> {{$loop->iteration}}</td>
            <td>{{$value->sort}}</td>
            <td>{{$value->name}}</td>
            {{-- <td><center><img src="{{asset('public/upload/gallery.category/'.$value['image']) }}" width="80" height="80"></center> </td> --}}
            <td><a href="{{ route('homepages.gallery.category.edit',$value->id) }}" class="btn btn-primary btn-flat btn-sm" data-type="image"><i class="fas fa-edit"></i></a> | <a class="btn btn-danger btn-flat btn-sm" id="delete" title="Delete" data-token="{{csrf_token()}}" href="{{ route('homepages.gallery.category.delete') }}" data-id="{{ $value->id }}" ><i class="fas fa-trash"></i></a>
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

