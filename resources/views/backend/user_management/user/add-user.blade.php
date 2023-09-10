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
          <h4 class="m-0 text-dark">User Add</h4>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">@lang('Home')</a></li>
            <li class="breadcrumb-item active">@lang('User')</li>
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
					@lang('User') @lang('Update')
					@else
					@lang('User') @lang('Add')
					@endif
					<a class="btn btn-sm btn-success float-right" href="{{route('user')}}"><i class="fa fa-list"></i> @lang('User') @lang('List')</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{!empty($editData->id) ? route('user.update',$editData->id) : route('user.store')}}" id="myForm">
				{{csrf_field()}}
				<div class="card-body">
                  <div class="row">
                      <div class="col-md-12">
                        <div class="">
                          {{-- <div class="form-row">
                            <div class="form-group col-md-5">
                                <label class="control-span">@lang('BUP ID') <span class="text-red">*</span></label>
                                <input type="text" name="bup_id" id="bup_id" class="" value="{{@$editData->bup_id}}" style="width: 80%;">
                            </div>
                            <div class="form-group col-md-5">
                              <label class="control-span">@lang('or Email') <span class="text-red">*</span></label>
                              <input type="text" name="email" id="email" class="" value="{{@$editData->email}}" style="width: 80%;">
                            </div>
                            <div class="col-md-2">
                              <button type="button" class="btn btn-info btn-sm" style="width: 100%;">Search</button>
                            </div>
                          </div> --}}
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label class="control-label">@lang('Name') {{--<span class="text-red">*</span>--}}</label>
                                    <input type="text" name="name" id="name" class="form-control form-control-sm" value="{{@$editData->name}}">
                                </div>
                                {{-- <div class="form-group col-md-4">
                                  <label class="control-label">@lang('BUP ID') </label>
                                  <input type="text" name="bup_id" id="bup_id" class="form-control form-control-sm" value="{{@$editData->bup_id}}">
                                </div> --}}
                                <div class="form-group col-md-4">
                                    <label class="control-label">@lang('Email') </label>
                                    <input type="email" name="email" id="email" class="form-control form-control-sm" value="{{@$editData->email}}" autocomplete="off">
                                    <font color="red">{{($errors->has('email'))?($errors->first('email')):''}}</font>
                                </div>
                                {{-- <div class="form-group col-md-4">
                                  <label class="control-label">@lang('Designation') </label>
                                  <input type="text" name="designation" id="designation" class="form-control form-control-sm" value="{{@$editData->designation}}">
                                </div>
                                <div class="form-group col-md-4">
                                  <label class="control-label">@lang('Department') </label>
                                  <input type="text" name="department" id="department" class="form-control form-control-sm" value="{{@$editData->department}}">
                                </div>
                                <div class="form-group col-md-4">
                                  <label class="control-label">@lang('Address') </label>
                                  <input type="text" name="address" id="address" class="form-control form-control-sm" value="{{@$editData->address}}">
                                </div> --}}
                                <div class="form-group col-md-4">
                                    <label class="control-label">@lang('Contact No') </label>
                                    <input type="number" name="mobile" id="mobile" class="form-control form-control-sm" value="{{@$editData->mobile}}" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                    maxlength = "11">
                                    <font color="red">{{($errors->has('mobile'))?($errors->first('mobile')):''}}</font>
                                </div>
                                {{-- @php dd(@$editData); @endphp --}}
                                <div class="form-group col-md-4">
                                    <label class="control-label">@lang('Role') </label>
                                    <select name="role_id" id="role_id" class="form-control form-control-sm">
                                        <option value="">@lang('Select')</option>
                                        @foreach($roles as $role)
                                        <option value="{{ $role->id }}" {{(@$editData['user_roles']['role_id']==$role->id)?"selected":""}}>{{ $role->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @if(!isset($editData))
                                <div class="form-group col-md-4">
                                    <label class="control-label">@lang('Password') </label>
                                    <input type="password" name="password" id="password" class="form-control form-control-sm" autocomplete="off">
                                </div>
                                <div class="form-group col-md-4">
                                    <label class="control-label">@lang('Confirm') @lang('Password') </label>
                                    <input type="password" name="password2" class="form-control form-control-sm">
                                </div>
                                @endif
                                <div class="col-sm-3" @if(!isset($editData)) style="margin-bottom: 0;margin-top: 35px;" @else style="margin-bottom: 0;margin-top: 35px;" @endif>
                                    <div class="form-check" style="margin-left: 5px;">
                                      <input type="checkbox" name="status" class="form-check-input" id="status" value="1" {{ @$editData->status == 1 ? 'checked':'' }}>
                                      <label data-toggle="tooltip" title="ON/OFF the checkbox to Active/Inactive user !" class="form-check-label" for="status">@if(session()->get('language') == 'en') Active / Inactive @else Active / Inactive @endif </label>
                                    </div>
                                </div>
                                {{-- <div class="form-group col-md-4">
                                  <label class="control-label">@lang('Image') </label>
                                </div> --}}

                            </div>
                        </div>
                        <div class="">
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
