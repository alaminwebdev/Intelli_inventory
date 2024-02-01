@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.employee.designation.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i>অফিসার্স পদবী তালিকা</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.employee.designation.update', $editData->id) : route('admin.employee.designation.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">পদবী <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm name @error('name') is-invalid @enderror" id="name" name="name" value="{{ @$editData->name }}" placeholder="Name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">সাজানো</label>
                                                <input type="text" class="form-control form-control-sm sort @error('sort') is-invalid @enderror" id="sort" name="sort" value="{{ @$editData->sort }}" placeholder="Sort">
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">অবস্থান <span class="text-red">*</span></label>
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
                                                <button type="submit" class="btn btn-success btn-sm">হালনাগাদ</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">সংরক্ষণ</button>
                                                <button type="reset" class="btn btn-danger btn-sm">মুছুন</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.employee.designation.list') }}">পিছনে যান</a>
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
