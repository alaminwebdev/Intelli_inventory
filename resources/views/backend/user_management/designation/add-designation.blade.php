 @extends('backend.layouts.app')
@section('content')
<style type="text/css">
  .i-style{
        display: inline-block;
        padding: 10px;
        width: 2em;
        text-align: center;
        font-size: 2em;
        vertical-align: middle;
        color: #444;
  }
  .demo-icon{cursor: pointer; }
</style>
<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark"></h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
            <li class="breadcrumb-item active">@lang('Designation')</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

<div class="container-fluid">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>
					@if(isset($editData))
					@lang('Designation') @lang('Update')
					@else
					@lang('Designation') @lang('Add')
					@endif
					<a class="btn btn-sm btn-success float-right" href="{{route('user.designation')}}"><i class="fa fa-list"></i> @lang('Designation') @lang('List')</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('user.designation.update',$editData->id) : route('user.designation.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
                  <div class="row justify-content-center">
                      <div class="col-md-12">
                        <div class="show_module_more_event">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label class="control-label">@lang('Designation') @lang('Name') <span class="text-red">*</span></label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}">
                                </div>

                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm" style="">
                            @if(isset($editData))
                            @lang('Update')
                            @else
                            @lang('Save')
                            @endif
                        </button>
                      </div>
                  </div>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div>
</div>

<script>
	$(document).ready(function(){
	  $('[data-toggle="tooltip"]').tooltip();
	});
</script>

<script type="text/javascript">
    $(document).ready(function () {
      $('#myForm').validate({
		onkeyup: false,
        rules: {
          name: {
             required: true,
          },
          email: {
             required: true,
            email:true
          },
          mobile:{
               required:true,
          },
          role_id: {
             required: true,
          },
          password : {
            required : true,
			pwcheck:true,
			minlength:8
          },
          password2 : {
            required : true,
            equalTo : '#password'
          }
        },
        messages: {
			password:{
				required:"Password required",
				pwcheck:"Password must contain combination with upper, lower, special character and numeric digit",
				minlength:"password must be 8 characters long"
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
