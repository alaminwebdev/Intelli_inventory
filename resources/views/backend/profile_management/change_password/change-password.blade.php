@extends('backend.layouts.app') @section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0 text-dark">@lang('Password') @lang('Change')</h1>
            </div>
            <!-- /.col -->
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
                    <li class="breadcrumb-item active">@lang('Change')</li>
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
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        {{-- <a href="{{route('project-management.role.view')}}" class="btn btn-info btn-sm"><i class="fas fa-stream"></i> View Role</a> --}}
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile-management.store.password') }}" method="post" enctype="multipart/form-data" id="myForm">
                            @csrf
                            <div class="form-row">

                                <div class="form-group col-sm-6">
                                    <label>@lang('Old') @lang('Password')<span class="text-red">*</span></label>
                                    <input type="password" class="form-control @error('old_password') is-invalid @enderror" name="old_password" autocomplete="off" value="{{ !empty($editData->old_password)? $editData->old_password : old('old_password') }}">
                                    @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <span style="color: red">{!! Session::has('msg') ? Session::get("msg") : '' !!}</span>
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>@lang('New') @lang('Password')<span class="text-red">*</span></label>
                                    <input type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" id="new_password" autocomplete="off" value="{{ !empty($editData->new_password)? $editData->new_password : old('new_password') }}">
                                    @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group col-sm-6">
                                    <label>@lang('Confirm') @lang('Password')<span class="text-red">*</span></label>
                                    <input type="password" class="form-control @error('confirm_password') is-invalid @enderror" name="confirm_password" autocomplete="off" value="{{ !empty($editData->confirm_password)? $editData->confirm_password : old('confirm_password') }}">
                                    @error('confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                </div>
                                <div class="form-group col-sm-6" style="padding-top: 30px;">
                                    <button class="btn bg-gradient-success btn-flat"><i class="fas fa-save"></i> @lang('Update')</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
        </div>
    </div>
    <!--/. container-fluid -->
</section>

<script>
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
</script>

<script type="text/javascript">

    $(document).ready(function () {

    jQuery.validator.addMethod("notEqualTo",
    function(value, element, param) {
        var notEqual = true;
        value = $.trim(value);
        for (i = 0; i < param.length; i++) {
            if (value == $.trim($(param[i]).val())) { notEqual = false; }
        }
        return this.optional(element) || notEqual;
    },
    "Please enter a diferent value."
    );

      $('#myForm').validate({
		onkeyup: false,
        rules: {
            old_password: {
             required: true,
             notEqualTo: ['#old_password'],
          },
          new_password: {
            required : true,
			pwcheck:true,
			minlength:8
          },
          confirm_password:{
            required : true,
            equalTo :'#new_password'

          },

        },
        messages: {
			old_password:{
				required:"Old Password required",
			},
			new_password:{
				required:"Password required",
				pwcheck:"Password must contain combination with upper, lower, special character and numeric digit",
				minlength:"password must be 8 characters long"
			},
			confirm_password:{
				required:"Confirm Password required",
			}
        },
        errorElement: 'span',
        errorPlacement: function (error, element) {
          error.addClass('invalid-feedback');
          element.closest('.form-group').append(error);
        },
        highlight: function (element, errorClass, validClass) {
          $(element).addClass('is-invalid');
        },
        unhighlight: function (element, errorClass, validClass) {
          $(element).removeClass('is-invalid');
        }
      });
	  $.validator.addMethod("pwcheck", function(value) {
		return /^[A-Za-z0-9\d=!\-@._$!%*#?&]*$/.test(value) // consists of only these
			&& /[a-z]/.test(value) // has a lowercase letter
			&& /[A-Z]/.test(value) // has a uppercase letter
			&& /[@$!%*#?&]/.test(value) // has a uppercase letter
			&& /\d/.test(value) // has a digit
		});

		$('#myForm').on('submit',function(e) {
        	$("#myForm").valid();
    	});
    });
  </script>
@endsection
