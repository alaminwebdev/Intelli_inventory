@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card shadow-sm">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <a href="{{ route('admin.employee.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list mr-1"></i> Officer's List</a>
                        </div>
                        <div class="card-body">
                            <form id="submitForm" action="{{ isset($editData) ? route('admin.employee.update', $editData->id) : route('admin.employee.store') }} " method="post" enctype="multipart/form-data" autocomplete="off">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row">
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">B.P. <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm bp_no @error('bp_no') is-invalid @enderror" id="bp_no" name="bp_no" value="{{ @$editData->bp_no }}" placeholder="BP Number">
                                                @error('bp_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label class="control-label">Designation <span class="text-red">*</span></label>
                                                <select name="designation_id" id="designation_id" class="form-control @error('designation_id') is-invalid @enderror select2 ">
                                                    <option value="">Please Select</option>
                                                    @foreach ($designations as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->designation_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('designation_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">Department <span class="text-red">*</span></label>
                                                <select name="department_id" id="department_id" class="form-control @error('department_id') is-invalid @enderror select2 ">
                                                    <option value="">Please Select</option>
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
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">Section </label>
                                                <select name="section_id" id="section_id" class="form-control select2 @error('section_id') is-invalid @enderror">
                                                    <option value="">Please Select</option>
                                                    @foreach ($sections as $section)
                                                        <option value="{{ $section->id }}" {{ @$editData->section_id == $section->id ? 'selected' : '' }}>{{ $section->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('section_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">Name <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm name @error('name') is-invalid @enderror" id="name" name="name" value="{{ @$editData->name }}" placeholder="Name">
                                                @error('name')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">Email <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm email @error('email') is-invalid @enderror" id="email" name="email" value="{{ @$editData->email }}" placeholder="Email">
                                                @error('email')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>
                                            <div class="form-group col-sm-4">
                                                <label class="control-label">Mobile <span class="text-red">*</span></label>
                                                <input type="text" class="form-control form-control-sm mobile_no  @error('mobile_no') is-invalid @enderror" id="mobile_no" name="mobile_no" value="{{ @$editData->mobile_no }}" placeholder="Mobile No">
                                                @error('mobile_no')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                @enderror
                                            </div>

                                            <div class="form-group col-sm-4">
                                                <label class="control-label">Sort</label>
                                                <input type="text" class="form-control form-control-sm sort @error('sort') is-invalid @enderror" id="sort" name="sort" value="{{ @$editData->sort }}" placeholder="Sort">
                                            </div>
                                            <div class="form-group col-sm-4">
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
                                                <a href="{{ route('admin.employee.list') }}">Back</a>
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

    <script>
        $(function() {

            $(document).on('change', '#department_id', function() {
                let department_id = $(this).val();
                console.log(department_id);
                $.ajax({
                    url: "{{ route('admin.get.sections.by.department') }}",
                    type: "GET",
                    data: {
                        department_id: department_id
                    },
                    success: function(data) {
                        console.log(data);
                        // Handle the data here
                        let section_div = document.getElementById('section_id');
                        section_div.innerHTML = '<option value="">Select Section</option>';
                        data.forEach(item => {
                            section_div.innerHTML +=
                                `<option value="${item.id}">${item.name}</option>`;
                        });
                    }
                });
            });
        });
    </script>
@endsection
