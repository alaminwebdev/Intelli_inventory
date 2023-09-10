@extends('backend.layouts.app') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                {{-- <h1 class="m-0 text-dark">{{ !empty($editData)? 'Update Slider' : 'Add Slider' }}</h1> --}}
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Home</a></li>
                    <li class="breadcrumb-item active">Slider</li>
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

        <div class="card card-outline card-info">
            <div class="card-header">
                <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                    {{ !empty($editData)? 'Update Slider' : 'Add Slider' }} <small> using in Banner slider </small>
                  </h3>
                  <div class="card-tools">
                   
                    <a href="{{route('site-setting.slider-master')}}" class="btn btn-info btn-sm"><i class="fas fa-stream"></i> View Slider</a>
                  </div>
                       
                    </div>
            <div class="card-body">
                <form action="{{ !empty($editData)? route('site-setting.slider-master.update',$editData->id) : route('site-setting.slider-master.store') }}" method="post" enctype="multipart/form-data" autocomplete="off">

                    @csrf
                    <div class="form-row">

                        <div class="form-group col-sm-6">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control  @error('name') is-invalid @enderror" id="name" value="{{ !empty($editData->name)? $editData->name : old('name') }}">
                            {{-- <textarea type="text" class="form-control @error('text_on_banner') is-invalid @enderror textarea " name="text_on_banner">{{ !empty($editData->text_on_banner)? $editData->text_on_banner : old('text_on_banner') }}</textarea> --}}
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>

                        <div class="form-group col-sm-6">
                            <label>Animation Type</label>
                            <input type="text" name="animation_type" class="form-control  @error('animation_type') is-invalid @enderror" id="animation_type" value="{{ !empty($editData->animation_type)? $editData->animation_type : old('animation_type') }}">
                            @error('animation_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div>

                        {{-- <div class="form-group col-sm-4" style="display: none">
                            <label>Slider Type</label>
                            <input type="text" name="slider_type" class="form-control  @error('slider_type') is-invalid @enderror" id="slider_type" value="{{ !empty($editData->slider_type)? $editData->slider_type : old('slider_type') }}">
                            @error('slider_type')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span> @enderror
                        </div> --}}

                        <button class="btn bg-gradient-success btn-flat"><i class="fas fa-save"></i> {{ !empty($editData)? 'Update Slider' : 'Save Slider' }}</button>
                    </div>
                </form>

            </div>

        </div>
        <!--/. container-fluid -->
    </section>
    @endsection