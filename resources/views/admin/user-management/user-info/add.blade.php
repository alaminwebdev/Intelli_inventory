@extends('admin.layouts.app')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header text-right">
                            <h4 class="card-title">{{ @$title }}</h4>
                            <div class="d-flex align-items-center">
                                <div class="custom-control custom-switch mr-3">
                                    <input type="checkbox" class="custom-control-input" id="is_employee" name="is_employee" >
                                    <label class="custom-control-label" for="is_employee">Toggle this to create user from Employee</label>
                                </div>
                                <a href="{{ route('admin.user-management.user-info.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list"></i> User List</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <form id="submitForm">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-row px-4 py-3 mb-3 shadow-sm border rounded" id="employeeFieldContainer" style="display: none;">
                                            <div class="form-group col-md-6">
                                                <label class="control-label">Select Employee <span class="text-red">*</span></label>
                                                <select name="employee_id" id="employee_id" class="form-control select2">
                                                    <option value="">Please Select</option>
                                                    @foreach ($employees as $item)
                                                        <option value="{{ $item->id }}" {{ @$editData->employee_id == $item->id ? 'selected' : '' }}>{{ $item->bp_no }} - {{ $item->name }} </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <fieldset class="border p-3">
                                            <legend class="w-auto pl-2 pr-2">Personal Information</legend>
                                            <div class="row">
                                                <label for="name" class="col-md-3 col-form-label">Name <span class="required">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control form-control-sm name" id="name" name="name" value="{{ @$editData->name }}" placeholder="Name">
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="mobile_no" class="col-md-3 col-form-label">Mobile <span class="required">*</span></label>
                                                <div class="col-md-9">
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">+88</span>
                                                        </div>
                                                        <input type="text" data-rule-minlength="11" data-rule-maxlength="11" data-msg-minlength="Mobile No format is not correct. Enter 11 digits" data-msg-maxlength="Mobile No format is not correct. Enter 11 digits" name="mobile_no" id="mobile_no" value="{{ $editData->mobile_no ?? old('mobile_no') }}" class="form-control form-control-sm mobile_no" placeholder="Mobile No">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="email" class="col-md-3 col-form-label">Email <span class="required">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="text" class="form-control form-control-sm email" id="email" name="email" value="{{ @$editData->email }}" placeholder="Email">
                                                </div>
                                            </div>
                                            {{-- <div class="row">
											<label for="designation_id" class="col-md-3 col-form-label">Designation <span class="required">*</span></label>
											<div class="col-md-9">
												<select name="designation_id" id="designation_id" class="form-control form-control-sm designation_id select2">
													<option value="">Select Designation</option>
													@foreach ($designations as $list)
													<option value="{{$list->id}}" {{(@$editData->designation_id == $list->id)?('selected'):''}}>{{$list->name}}</option>
													@endforeach
												</select>
											</div>
										</div>
										<div class="row">
											<label for="working_place" class="col-md-3 col-form-label">Working place</label>
											<div class="col-md-9">
												<input type="text" class="form-control form-control-sm working_place" id="working_place" name="working_place" value="{{@$editData->working_place}}" placeholder="Working place">
											</div>
										</div> --}}
                                            <div class="row">
                                                <label for="role_ids" class="col-md-3 col-form-label">Role <span class="required">*</span></label>
                                                <div class="col-md-9">
                                                    <select name="role_ids[]" id="role_ids" class="form-control form-control-sm role_ids select2" multiple>
                                                        @foreach ($roles as $role)
                                                            <option value="{{ $role->id }}" {{ @$editData ? (in_array($role->id, @$editData->user_roles->pluck('role_id')->toArray()) ? 'selected' : '') : '' }}>{{ $role->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <label for="status" class="col-md-3 col-form-label">Status <span class="required">*</span></label>
                                                <div class="col-md-9">
                                                    <select name="status" id="status" class="form-control form-control-sm status select2">
                                                        <option value="1" {{ @$editData->status == '1' ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ @$editData->status == '0' ? 'selected' : '' }}>Inactive</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="row file_div">
                                                <label class="col-md-3 col-form-label my-auto justify-content-center">Profile</label>
                                                <div class="col-md-7 d-flex my-auto justify-content-center">
                                                    <div class="custom-file mb-1">
                                                        <input type="file" class="custom-file-input profile_file image" name="image" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg">
                                                        <label class="custom-file-label" for="customFile">Choose Profile</label>
                                                    </div>
                                                </div>
                                                <div class="col-md-2 mb-1">
                                                    <img class="profile-user-img img-fluid img_preview" src="{{ fileExist(['url' => @$editData->image, 'type' => 'profile']) }}" alt="{{ @$editData->name }}" style="width:100px; height: 100px;">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                    <div class="col-md-4">
                                        <fieldset class="border p-3">
                                            <legend class="w-auto pl-2 pr-2">Credential Information</legend>
                                            <div class="row {{ !@$editData ? 'd-none' : '' }}">
                                                <div class="icheck-primary d-inline">
                                                    <input type="checkbox" id="change_password" name="change_password" {{ !@$editData ? 'checked' : '' }}>
                                                    <label for="change_password">Are you want to Change Password?</label>
                                                </div>
                                            </div>
                                            <div class="row change_password_action {{ @$editData ? 'd-none' : '' }}">
                                                <label for="name" class="col-md-3 col-form-label">Password <span class="required">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control form-control-sm password" id="password" name="password" value="" placeholder="Password" autocomplete="new-password">
                                                </div>
                                            </div>
                                            <div class="row change_password_action {{ @$editData ? 'd-none' : '' }}">
                                                <label for="name" class="col-md-3 col-form-label">Confirm password <span class="required">*</span></label>
                                                <div class="col-md-9">
                                                    <input type="password" class="form-control form-control-sm confirm_password" id="confirm_password" name="password_confirmation" value="" placeholder="Confirm Password" autocomplete="new-password">
                                                </div>
                                            </div>
                                        </fieldset>
                                    </div>
                                </div>
                                <div class="row pt-2">
                                    <div class="col-sm-8">
                                        <div class="form-group text-right">
                                            @if (@$editData->id)
                                                <button type="submit" class="btn btn-success btn-sm">Update</button>
                                            @else
                                                <button type="submit" class="btn btn-success btn-sm">Save</button>
                                                <button type="reset" class="btn btn-danger btn-sm">Clear</button>
                                            @endif
                                            <button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
                                                <a href="{{ route('admin.user-management.user-info.list') }}">Back</a>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <script type="text/javascript">
        $(function() {
            $(document).on('change', '#change_password', function() {
                var check_status = $(this).prop('checked');
                if (check_status) {
                    $('.change_password_action').removeClass('d-none');
                } else {
                    $('.change_password_action').addClass('d-none');
                }
            });
        });
    </script>
    <script>
        $(function() {
            $('#is_employee').change(function() {
                if (this.checked) {
                    $('#employeeFieldContainer').show();
                    $('#employee_id').val('');
                } else {
                    $('#employeeFieldContainer').hide();
                    // Clear the fields if no employee is selected
                    $('#name').val('').prop('readonly', false);
                    $('#mobile_no').val('').prop('readonly', false);
                    $('#email').val('').prop('readonly', false);
                }
            });

            $('#employee_id').change(function() {
                var employeeId = $(this).val();
                if (employeeId) {
                    $.ajax({
                        type: 'GET',
                        url: "{{ route('admin.get.employee.by.id') }}",
                        data: {
                            employee_id: employeeId
                        },
                        success: function(data) {
                            if (data) {
                                console.log(data);
                                $('#name').val(data.name).prop('readonly', true);
                                $('#mobile_no').val(data.mobile_no).prop('readonly', true);
                                $('#email').val(data.email).prop('readonly', true);
                            } else {
                                // Handle the case when no data is found for the selected employee
                                $('#name').val('').prop('readonly', false);
                                $('#mobile_no').val('').prop('readonly', false);
                                $('#email').val('').prop('readonly', false);
                            }
                        },
                        error: function() {
                            // Handle the AJAX error if needed
                        }
                    });
                } else {
                    // Clear the fields if no employee is selected
                    $('#name').val('').prop('readonly', false);
                    $('#mobile_no').val('').prop('readonly', false);
                    $('#email').val('').prop('readonly', false);
                }
            });
        });
    </script>
    <script>
        $(function() {
            var profile_img_preview = $('.profile_file').parents('.file_div').find(".img_preview").attr("src");
            var profile_custom_file_label = $('.profile_file').parents('.file_div').find(".custom-file-label").html();

            $(".profile_file").on("change", function() {
                var btnThis = $(this);
                var fileName = $(btnThis).val().split("\\").pop();
                if (btnThis[0].files[0]) {
                    var reader = new FileReader();
                    reader.onload = function() {
                        $(btnThis).parents('.file_div').find(".img_preview").attr("src", reader.result);
                    }
                    reader.readAsDataURL(btnThis[0].files[0]);
                    $(btnThis).parents('.file_div').find(".custom-file-label").html(fileName);
                } else {
                    $(btnThis).parents('.file_div').find(".img_preview").attr("src", profile_img_preview);
                    $(btnThis).parents('.file_div').find(".custom-file-label").html(profile_custom_file_label);
                }
            });
        })
    </script>
    <script>
        $(document).ready(function() {
            $('#submitForm').validate({
                ignore: [],
                errorPlacement: function(error, element) {
                    if (element.hasClass("role_ids")) {
                        error.insertAfter(element.next());
                    } else if (element.hasClass("status")) {
                        error.insertAfter(element.next());
                    } else if (element.hasClass("designation_id")) {
                        error.insertAfter(element.next());
                    } else if (element.hasClass("mobile_no")) {
                        error.insertAfter(element.parents('.input-group'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                errorClass: 'text-danger',
                validClass: 'text-success',

                submitHandler: function(form) {
                    event.preventDefault();
                    $('[type="submit"]').attr('disabled', 'disabled').css('cursor', 'not-allowed');
                    var formInfo = new FormData($("#submitForm")[0]);
                    $.ajax({
                        url: "{{ isset($editData) ? route('admin.user-management.user-info.update', $editData) : route('admin.user-management.user-info.store') }}",
                        data: formInfo,
                        type: "POST",
                        processData: false,
                        contentType: false,
                        beforeSend: function() {
                            $('.preload').show();
                        },
                        success: function(data) {
                            if (data.status == 'success') {
                                Swal.fire({
                                    icon: "success",
                                    title: data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                setTimeout(function() {
                                    location.replace(data.reload_url);
                                }, 2000);
                            } else if (data.status == 'validation') {
                                var errors = data.errors;
                                $.each(errors, function(key, val) {
                                    $("." + key).parent().append('<label id="' + key + '-error" class="text-danger" for="' + key + '">' + val[0] + '</label>');
                                });

                                $('[type="submit"]').removeAttr('disabled').css('cursor', 'pointer');
                                $('.preload').hide();
                            } else {
                                Swal.fire({
                                    icon: "error",
                                    title: data.message,
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000
                                });
                                $('[type="submit"]').removeAttr('disabled').css('cursor', 'pointer');
                                $('.preload').hide();
                            }
                        },
                        error: function(XMLHttpRequest, textStatus, errorThrown) {
                            Swal.fire({
                                icon: "error",
                                title: "দুঃখিত !!সফটওয়্যার মেইনটেনেন্স সমস্যার কারনে তথ্য সংরক্ষন করা যাচ্ছে না। আপনি রিলোড না নিয়ে সংশিষ্ট সাপোর্ট ইঞ্জিনিয়ারকে জানান",
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('[type="submit"]').removeAttr('disabled').css('cursor', 'pointer');
                            $('.preload').hide();
                        }
                    });
                }
            });

            jQuery.validator.addClassRules({
                'name': {
                    required: true,
                },
                'email': {
                    required: true,
                    email: true,
                    remote: {
                        url: "{{ route('admin.user-management.user-info.duplicate-email-check') }}",
                        type: "GET",
                        data: {
                            email: function() {
                                return $("#email").val();
                            },
                            edit_data: function() {
                                return "{{ @$editData->id }}"
                            }
                        },
                    },
                },
                'mobile_no': {
                    required: true,
                    digits: true,
                    // minlength:5,
                    // maxlength:5,
                    remote: {
                        url: "{{ route('admin.user-management.user-info.duplicate-mobile_no-check') }}",
                        type: "GET",
                        data: {
                            mobile_no: function() {
                                return $("#mobile_no").val();
                            },
                            edit_data: function() {
                                return "{{ @$editData->id }}"
                            }
                        },
                    },
                },
                'designation_id': {
                    required: true,
                },
                'role_ids': {
                    required: true,
                },
                'status': {
                    required: true,
                },
                'password': {
                    required: function() {
                        return $('#change_password').prop('checked');
                    },
                },
                'confirm_password': {
                    required: function() {
                        return $('#change_password').prop('checked');
                    },
                    equalTo: '#password',
                },
            });
        });
    </script>
@endsection
