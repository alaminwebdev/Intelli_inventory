@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.product.information.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i> Product List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.product.information.update', $editData->id) : route('admin.product.information.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Product Code</label>
                                                <input type="text" class="form-control form-control-sm code @error('code') is-invalid @enderror" id="code" name="code" value="{{ @$editData->code }}" placeholder="Product Code">
                                                @error('code')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Product <span class="text-red">*</span>
                                                </label>
                                                <input type="text" class="form-control form-control-sm name @error('name') is-invalid @enderror" id="name" name="name" value="{{ @$editData->name }}" placeholder="Name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Product Type <span class="text-red">*</span></label>
                                                <select name="product_type_id" id="product_type_id" class="form-control select2 @error('product_type_id') is-invalid @enderror">
                                                    <option value="" >Please Select</option>
                                                    @foreach ($product_types as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->product_type_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('product_type_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label class="control-label"> Unit <span class="text-red">*</span></label>
                                                <select name="unit_id" id="unit_id" class="form-control select2 @error('unit_id') is-invalid @enderror">
                                                    <option value="" >Please Select</option>
                                                    @foreach ($units as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->unit_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('unit_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Status <span class="text-red">*</span></label>
                                                <select name="status" id="status" class="form-control select2 ">
                                                    <option value="1" {{ @$editData->status == '1' ? 'selected' : '' }}>Active
                                                    </option>
                                                    <option value="0" {{ @$editData->status == '0' ? 'selected' : '' }}>Inactive
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="text-right">
                                            @if (@$editData->id)
                                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                                <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.product.information.list') }}">Back</a>
                                            </button>
                                        </div>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
