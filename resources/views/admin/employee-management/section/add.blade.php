@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.section.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i> Section List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.section.update', $editData->id) : route('admin.section.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Section <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm name @error('name') is-invalid @enderror" id="name" name="name" value="{{ @$editData->name }}" placeholder="Name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Department <span class="text-red">*</span></label>
                                                <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror select2 ">
                                                    <option value="" >Please Select</option>
                                                    @foreach ($departments as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->department_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('department_id')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Sort</label>
                                                <input type="text" class="form-control form-control-sm sort @error('sort') is-invalid @enderror" id="sort" name="sort" value="{{ @$editData->sort }}" placeholder="Sort">
                                            </div>
                                            <div class="form-group col-sm-6">
                                                <label class="control-label">Status</label>
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
                                                <a href="{{ route('admin.section.list') }}">Back</a>
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
