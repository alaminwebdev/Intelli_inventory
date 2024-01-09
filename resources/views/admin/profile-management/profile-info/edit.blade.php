@extends('admin.layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header text-right">
						<h4 class="card-title">{{@$title}}</h4>
					</div>
					<div class="card-body">
						<form id="submitForm">
							@csrf
							<div class="row">
								<div class="col-md-8">
									<fieldset class="border p-3">
										<legend  class="w-auto pl-2 pr-2">Personal Information</legend>
										<div class="row">
											<label for="name" class="col-md-3 col-form-label">Name <span class="required">*</span></label>
											<div class="col-md-9">
												<input type="text" class="form-control form-control-sm name" id="name" name="name" value="{{@$editData->name}}" placeholder="Name">
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
												<input type="text" class="form-control form-control-sm email" id="email" name="email" value="{{@$editData->email}}" placeholder="Email">
											</div>
										</div>
										<div class="row">
											<label for="designation_id" class="col-md-3 col-form-label">Designation <span class="required">*</span></label>
											<div class="col-md-9">
												<select name="designation_id" id="designation_id" class="form-control form-control-sm designation_id select2">
													<option value="">Select Designation</option>
													@foreach($designations as $list)
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
												<img class="profile-user-img img-fluid img_preview" src="{{fileExist(['url'=>@$editData->image,'type'=>'profile'])}}" alt="{{@$editData->name}}" style="width:100px; height: 100px;">
											</div>
										</div>
									</fieldset>
								</div>
							</div>

							<div class="row pt-2">
								<div class="col-sm-8">
									<div class="form-group text-right">
										<button type="submit" class="btn btn-success btn-sm">Update</button>
										<button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
											<a href="{{route('admin.profile-management.profile-info.profile') }}">Back</a>
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

<script>
	$(function(){
		var profile_img_preview = $('.profile_file').parents('.file_div').find(".img_preview").attr("src");
		var profile_custom_file_label = $('.profile_file').parents('.file_div').find(".custom-file-label").html();
		
		$(".profile_file").on("change", function() {
			var btnThis = $(this); 
			var fileName = $(btnThis).val().split("\\").pop();
			if(btnThis[0].files[0]){
				var reader = new FileReader(); 
				reader.onload = function(){
					$(btnThis).parents('.file_div').find(".img_preview").attr("src", reader.result);
				}
				reader.readAsDataURL(btnThis[0].files[0]);
				$(btnThis).parents('.file_div').find(".custom-file-label").html(fileName);
			}else{
				$(btnThis).parents('.file_div').find(".img_preview").attr("src", profile_img_preview);
				$(btnThis).parents('.file_div').find(".custom-file-label").html(profile_custom_file_label);
			}
		});
	})
</script>

<script>
	$(document).ready(function(){
		$('#submitForm').validate({
			ignore:[],
			errorPlacement: function(error, element){
				if(element.hasClass("role_ids")){error.insertAfter(element.next()); }
				else if(element.hasClass("status")){error.insertAfter(element.next()); }
				else if(element.hasClass("designation_id")){error.insertAfter(element.next()); }
				else if(element.hasClass("mobile_no")){error.insertAfter(element.parents('.input-group')); }
				else{error.insertAfter(element);}
			},
			errorClass:'text-danger',
			validClass:'text-success',

			submitHandler: function (form) {
				event.preventDefault();
				$('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
				var formInfo = new FormData($("#submitForm")[0]);
				$.ajax({
					url : "{{route('admin.profile-management.profile-info.update')}}",
					data : formInfo,
					type : "POST",
					processData: false,
					contentType: false,
					beforeSend : function(){
						$('.preload').show();
					},
					success:function(data){
						if(data.status == 'success'){
							Swal.fire({
								icon: "success",
								title: data.message,
								toast: true,
								position: 'top-end',
								showConfirmButton: false,
								timer: 3000
							});
							setTimeout(function(){
								location.replace(data.reload_url);
							}, 2000);
						}else if(data.status == 'validation'){
							var errors = data.errors;
							$.each(errors, function (key, val) {
								$("."+key).parent().append('<label id="'+key+'-error" class="text-danger" for="'+key+'">'+val[0]+'</label>');
							});

							$('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
							$('.preload').hide();
						}else{
							Swal.fire({
								icon: "error",
								title: data.message,
								toast: true,
								position: 'top-end',
								showConfirmButton: false,
								timer: 3000
							}); 
							$('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
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
						$('[type="submit"]').removeAttr('disabled').css('cursor','pointer');
						$('.preload').hide();
					}
				});
			}
		});

		jQuery.validator.addClassRules({
			'name' : {
				required : true,
			},
			'email' : {
				required : true,
				email : true,
				remote: {
					url: "{{route('admin.profile-management.profile-info.duplicate-email-check')}}",
					type: "GET",
					data: {
						email: function(){return $("#email").val();}
					},
				},
			},
			'mobile_no' : {
				required : true,
				digits : true,
				// minlength:5,
				// maxlength:5,
				remote: {
					url: "{{route('admin.profile-management.profile-info.duplicate-mobile_no-check')}}",
					type: "GET",
					data: {
						mobile_no: function(){return $("#mobile_no").val();}
					},
				},
			},
			'designation_id' : {
				required : true,
			}
		});
	});
</script>

@endsection