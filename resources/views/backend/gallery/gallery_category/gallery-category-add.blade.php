@extends('backend.layouts.app') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ !empty($editData)? 'Update Gallery Category' : 'Add Gallery Category' }}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Site Gallery Category</li>
                </ol>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
</div>
<!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">

        <div class="card">
            <div class="card-header">
                <a href="{{route('homepages.gallery.category')}}" class="btn btn-info btn-sm"><i class="fas fa-stream"></i> View Gallery Category</a>
            </div>
            <div class="card-body">
                <form action="{{ !empty($editData)? route('homepages.gallery.category.update',$editData->id) : route('homepages.gallery.category.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">

                    @csrf
                    <div class="form-row">
                        <div class="form-group col-sm-6">
                            <label>Gallery Category Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" autocomplete="off" value="{{ !empty($editData->name)? $editData->name : old('name') }}"> @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>
                        <div class="form-group col-sm-6">
                            <label>Category Name Sort Number</label>
                            <input type="text" class="form-control @error('sort') is-invalid @enderror" name="sort" autocomplete="off" value="{{ !empty($editData->sort)? $editData->sort : old('sort') }}"> @error('sort')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>

                    </div>
                    <button class="btn bg-gradient-success btn-flat"><i class="fas fa-save"></i> {{ !empty($editData)? 'Update Gallery Category' : 'Save Gallery Category' }}</button>
                </form>

            </div>

        </div>
        <!--/. container-fluid -->
    </section>

    @endsection
