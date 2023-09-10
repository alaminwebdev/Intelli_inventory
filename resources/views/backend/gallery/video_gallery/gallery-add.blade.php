@extends('backend.layouts.app') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">{{ !empty($editData)? 'Update Gallery' : 'Add Gallery' }}</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                    <li class="breadcrumb-item active">Site Gallery</li>
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
                <a href="{{route('homepages.gallery')}}" class="btn btn-info btn-sm"><i class="fas fa-stream"></i> View Gallery</a>
            </div>
            <div class="card-body">
                <form action="{{ !empty($editData)? route('homepages.gallery.update',$editData->id) : route('homepages.gallery.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">

                    @csrf
                    <div class="form-row">
                        {{-- <div class="form-group col-sm-6">
                            <label>Gallery Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title" autocomplete="off" value="{{ !empty($editData->title)? $editData->title : old('title') }}"> @error('title')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div> --}}
                        <div class="form-group col-sm-6">
                                    <label>Gallery Category</label>
                                    <select class="select2 form-control @error('category_id') is-invalid @enderror" name="gallery_category_id" >
                                        <option value="">--Select Category--</option>
                                        @foreach($category as $c)
                                        <option {{ @$editData->gallery_category_id == $c->id ? 'selected':''}} value="{{$c->id}}">{{ $c['name'] }}</option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                        <div class="form-group col-sm-6">
                            <label>Gallery Image</label>
                            <input type="file" class="form-control filer_input_single @error('image') is-invalid @enderror" name="image"> @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>

                    </div>
                    <button class="btn bg-gradient-success btn-flat"><i class="fas fa-save"></i> {{ !empty($editData)? 'Update Gallery' : 'Save Gallery' }}</button>
                </form>

            </div>

        </div>
        <!--/. container-fluid -->
    </section>

    @endsection
