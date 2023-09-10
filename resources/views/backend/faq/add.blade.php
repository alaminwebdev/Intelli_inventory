@extends('backend.layouts.app')
@section('content')
    <style type="text/css">
        .i-style {
            display: inline-block;
            padding: 10px;
            width: 2em;
            text-align: center;
            font-size: 2em;
            vertical-align: middle;
            color: #444;
        }

        .demo-icon {
            cursor: pointer;
        }
    </style>
    <style>
        .select2-container .select2-selection--single {
            height: 35px;
        }
    </style>
    <style>
        .select2-container {
            display: block;
        }
    </style>
    <style>
        .ms-container {
            width: 100%;
        }
    </style>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    {{-- <h4 class="m-0 text-dark">FAQ Add</h4> --}}
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('dashboard')}}">@lang('Home')</a></li>
                        <li class="breadcrumb-item active">@lang('FAQ')</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="col-md-12">
            <div class="card card-outline card-info">
                <div class="card-header">
                    <h5>
                        @if (isset($editData))
                            @lang('FAQ') @lang('Update')
                        @else
                            @lang('FAQ') @lang('Add')
                        @endif
                        <a class="btn btn-sm btn-info float-right" href="{{ route('site-setting.faq') }}"><i
                                class="fa fa-list"></i> @lang('FAQ') @lang('List')</a>
                    </h5>
                </div>
                <!-- Form Start-->
                <form method="post"
                    action="{{ @$editData ? route('site-setting.faq.update', $editData->id) : route('site-setting.faq.store') }}"
                    id="myForm" enctype="multipart/form-data">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">

                            <div class="form-group col-md-6">
                                <label for="faq_type">@lang('FAQ For') <span class="text-red">*</span></label>
                                <select id="faq_for" name="faq_type" class="form-control select2">
                                    <option value="" disabled selected>@lang('Select')</option>
                                    <option value="1" {{ @$editData->faq_type == '1' ? 'selected' : '' }}>Faculty
                                    </option>
                                    <option value="2" {{ @$editData->faq_type == '2' ? 'selected' : '' }}>Department
                                    </option>
                                    <option value="3" {{ @$editData->faq_type == '3' ? 'selected' : '' }}>Program
                                    </option>
                                    <option value="4" {{ @$editData->faq_type == '4' ? 'selected' : '' }}>CHSR</option>
                                    <option value="5" {{ @$editData->faq_type == '5' ? 'selected' : '' }}>CPC</option>
                                </select>
                            </div>
                            <div id="faculty_div" class="form-group col-md-6"
                                style="display:{{ @$editData->faq_type == 1 ? '' : 'none' }}">
                                <label for="">@lang('Faculty') <span class="text-red">*</span></label>
                                <select id="" name="faculty_id" class="form-control">
                                    <option value="">Select</option>
                                    {{-- @foreach ($faculties as $faculty)
                                        <option value="{{ $faculty->id }}"
                                            {{ @$editData->ref_id == $faculty->id ? 'selected' : '' }}>
                                            {{ @$faculty->name }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div id="department_div" class="form-group col-md-6"
                                style="display:{{ @$editData->faq_type == 2 ? '' : 'none' }}">
                                <label for="">@lang('Department') <span class="text-red">*</span></label>
                                <select id="" name="dept_id" class="form-control select2">
                                    <option value="">Select</option>
                                    {{-- @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ @$editData->ref_id == $department->id ? 'selected' : '' }}>
                                            {{ @$department->name }}</option>
                                    @endforeach --}}
                                </select>
                            </div>
                            <div id="program_div" class="form-group col-md-6"
                                style="display:{{ @$editData->faq_type == 3 ? '' : 'none' }}">
                                <label for="">@lang('Program') <span class="text-red">*</span></label>
                                <select id="" name="program_id" class="form-control select2">
                                    <option value="">Select</option>
                                    {{-- @foreach ($programs as $program)
                                        <option value="{{ $program->id }}"
                                            {{ @$editData->ref_id == $program->id ? 'selected' : '' }}>
                                            {{ @$program->program_title }}</option>
                                    @endforeach --}}
                                </select>
                                </select>
                            </div>

                            {{-- <div id="service_div" class="form-group col-md-6" style="display: none;">
                                <label for="service_id">@lang('Service') <span class="text-red">*</span></label>
                                <select id="service_id" name="service_id" class="form-control select2">
                                    <option value="" disabled>@lang('Select')</option>
                                    <option value="1" {{ @$editData->service_id == '0' ? 'selected' : '' }}>Service 1
                                    </option>
                                    <option value="2" {{ @$editData->service_id == '1' ? 'selected' : '' }}>Service 2
                                    </option>
                                </select>
                            </div> --}}

                            <div class="form-group col-md-6" id="chsr_div" style="display:{{ @$editData->faq_type == 4 ? '' : 'none' }}">
                                <label for="faq_for">@lang('Category') <span class="text-red">*</span></label>
                                <select id="ref_id" name="chsr_id" class="form-control select2">
                                    <option value="" disabled selected>@lang('Select')</option>
                                    <option value="1" {{ @$editData->ref_id == '1' ? 'selected' : '' }}>
                                        About CHSR
                                    </option>
                                    <option value="2" {{ @$editData->ref_id == '2' ? 'selected' : '' }}>
                                        MPhil Program
                                    </option>
                                    <option value="3" {{ @$editData->ref_id == '3' ? 'selected' : '' }}>
                                        PhD Program
                                    </option>
                                    <option value="4" {{ @$editData->ref_id == '4' ? 'selected' : '' }}>
                                        MPhil Adminssion
                                    </option>
                                    <option value="5" {{ @$editData->ref_id == '5' ? 'selected' : '' }}>
                                        PhD Adminssion
                                    </option>
                                </select>
                            </div>

                            {{-- @php
                                $cpc = \App\Models\Cpc::all();
                            @endphp --}}
                            <div id="cpc_div" class="form-group col-md-6" style="display:{{ @$editData->faq_type == 5 ? '' : 'none' }}">
                                <label for="">@lang('CPC') <span class="text-red">*</span></label>
                                <select id="" name="cpc_id" class="form-control select2">
                                    <option value="">@lang('Select')</option>
                                    {{-- @foreach ($cpc as $name)
                                        <option value="{{ $name->id }}"
                                            {{ @$editData->ref_id == $name->id ? 'selected' : '' }}>{{ $name->name }}
                                        </option>
                                    @endforeach --}}
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="question">@lang('Question') <span class="text-red">*</span></label>
                                <input id="question" type="text" name="question" class="form-control"
                                    value="{{ @$editData->question }}" placeholder="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="answer">@lang('Answer') <span class="text-red">*</span></label>
                                {{-- <input id="answer" type="text" name="answer" class="form-control"
                                    value="{{ @$editData->answer }}" placeholder=""> --}}
                                <textarea class="textarea" name="answer" id="" cols="30" rows="10">{!! @$editData->answer !!}</textarea>
                            </div>
                            <div class="col-sm-3"
                                @if (!isset($editData)) style="margin-bottom: 10px;margin-top: 0px;" @else style="margin-bottom: 10px;margin-top: 0px;" @endif>
                                <div class="form-check" style="margin-left: 0px;">
                                    <input type="checkbox" name="status" class="form-check-input" id="status"
                                        value="1" {{ @$editData->status == 1 ? 'checked' : '' }}>
                                    <label data-toggle="tooltip" title="ON/OFF the checkbox to Active/Inactive user !"
                                        class="form-check-label" for="status">
                                        @if (session()->get('language') == 'en')
                                            Active / Inactive
                                        @else
                                            Active / Inactive
                                        @endif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-3">
                                <button type="submit"
                                    class="btn btn-info">{{ @$editData ? 'Update' : 'Submit' }}</button>
                            </div>
                        </div>
                    </div>
            </div>
            </form>
            <!--Form End-->
        </div>
    </div>
    </div>

    <script type="text/javascript">
        $(document).on('select change', '#faq_for', function() {
            var faq_for = $('#faq_for').val();
            // alert(faq_for);
            if (faq_for == 1) {
                document.getElementById("faculty_div").style.display = "";
                document.getElementById("department_div").style.display = "none";
                document.getElementById("program_div").style.display = "none";
                document.getElementById("chsr_div").style.display = "none";
                document.getElementById("cpc_div").style.display = "none";

            } else if (faq_for == 2) {
                document.getElementById("faculty_div").style.display = "none";
                document.getElementById("department_div").style.display = "";
                document.getElementById("program_div").style.display = "none";
                document.getElementById("chsr_div").style.display = "none";
                document.getElementById("cpc_div").style.display = "none";

            } else if (faq_for == 3) {
                document.getElementById("faculty_div").style.display = "none";
                document.getElementById("department_div").style.display = "none";
                document.getElementById("program_div").style.display = "";
                document.getElementById("chsr_div").style.display = "none";
                document.getElementById("cpc_div").style.display = "none";

            } else if (faq_for == 4) {
                document.getElementById("faculty_div").style.display = "none";
                document.getElementById("department_div").style.display = "none";
                document.getElementById("program_div").style.display = "none";
                document.getElementById("chsr_div").style.display = "";
                document.getElementById("cpc_div").style.display = "none";
            } else if (faq_for == 5) {
                document.getElementById("faculty_div").style.display = "none";
                document.getElementById("department_div").style.display = "none";
                document.getElementById("program_div").style.display = "none";
                document.getElementById("chsr_div").style.display = "none";
                document.getElementById("cpc_div").style.display = "";
            }
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '#faculty_idd', function() {
            var faculty_id = $('#faculty_id').val();
            var department_id = $('#department_id').val();
            $.ajax({
                url: "",
                type: "GET",
                data: {
                    faculty_id: faculty_id
                },
                success: function(data) {
                    // console.log(data);
                    $('#department_id').empty().multiSelect('refresh');
                    $.each(data, function(index, subcatObj) {
                        $('#department_id').multiSelect('addOption', {
                            value: subcatObj.id,
                            text: subcatObj.name
                        });
                    });
                    $('#department_id').multiSelect('select', department_id);
                    $('#department_id').trigger('change');
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).on('change', '#department_idDD', function() {
            var department_id = $('#department_id').val();
            var program_id = $('#program_id').val();
            $.ajax({
                url: "",
                type: "GET",
                data: {
                    department_id: department_id
                },
                success: function(data) {
                    $('#program_id').empty().multiSelect('refresh');
                    $.each(data, function(index, subcatObj) {
                        $('#program_id').multiSelect('addOption', {
                            value: subcatObj.id,
                            text: subcatObj.program_title
                        });
                    });
                    $('#program_id').multiSelect('select', program_id);
                }
            });
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            var a1 = CKEDITOR.replace('long_title_en');
            CKFinder.site-settingCKEditor(a1, '/ckfinder/');
            var a1 = CKEDITOR.replace('long_title_bn');
            CKFinder.site-settingCKEditor(a1, '/ckfinder/');
        });
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $('textarea').each(function() {
                $(this).val($(this).val().trim());
            });

            $('#myForm').validate({
                ignore: [],
                debug: false,
                rules: {
                    date: {
                        required: true,
                    },
                    short_title_en: {
                        required: true,
                    },
                    short_title_bn: {
                        required: true,
                    },
                    long_title_en: {
                        required: true,
                    },
                    long_title_bn: {
                        required: true,
                    },
                    // status: {
                    //     required: true,
                    // }
                },
                messages: {

                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endsection
