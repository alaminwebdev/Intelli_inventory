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
								<label for="name" class="col-md-2 col-form-label">Site name</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm name" name="name" value="{{@$editData->name}}" placeholder="Site name">
								</div>
							</div>
							<div class="row file_div">
								<label class="col-md-2 col-form-label my-auto justify-content-center">Site Logo</label>
								<div class="col-md-8 d-flex my-auto justify-content-center">
									<div class="custom-file mb-1">
										<input type="file" class="custom-file-input logo_file logo" name="logo" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg">
										<label class="custom-file-label" for="customFile">Choose Logo</label>
									</div>
								</div>
								<div class="col-md-2 mb-1">
									<img class="profile-user-img img-fluid img_preview" src="{{fileExist(['url'=>@$editData->logo,'type'=>'logo'])}}" alt="{{@$editData->name}}" style="width:100px; height: 100px;">
								</div>
							</div>
							<div class="row file_div">
								<label class="col-md-2 col-form-label my-auto justify-content-center">Site Favicon</label>
								<div class="col-md-8 d-flex my-auto justify-content-center">
									<div class="custom-file mb-1">
										<input type="file" class="custom-file-input favicon_file favicon" name="favicon" accept="image/jpeg, image/png, image/jpg, image/gif, image/svg">
										<label class="custom-file-label" for="customFile">Choose Favicon</label>
									</div>
								</div>
								<div class="col-md-2 mb-1">
									<img class="profile-user-img img-fluid img_preview" src="{{fileExist(['url'=>@$editData->favicon,'type'=>'favicon'])}}" alt="{{@$editData->name}}" style="width:100px; height: 100px;">
								</div>
							</div>
							<div class="row">
								<label for="version" class="col-md-2 col-form-label">Version</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm version" name="version" value="{{@$editData->version}}" placeholder="Version">
								</div>
							</div>
							<div class="row">
								<label for="copy_right_year" class="col-md-2 col-form-label">Copyright from year</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm copy_right_year" name="copy_right_year" value="{{@$editData->copy_right_year}}" placeholder="Copyright from year">
								</div>
							</div>
							<div class="row">
								<label for="copy_right_org_link" class="col-md-2 col-form-label">Copyright Org Link</label>
								<div class="col-md-10">
									<input type="url" class="form-control form-control-sm copy_right_org_link" name="copy_right_org_link" value="{{@$editData->copy_right_org_link}}" placeholder="Copyright Org Link">
								</div>
							</div>
							<div class="row">
								<label for="title_suffix" class="col-md-2 col-form-label">Title suffix</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm title_suffix" name="title_suffix" value="{{@$editData->title_suffix}}" placeholder="Title suffix">
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group text-right">
										<button type="submit" class="btn btn-success btn-sm">Update</button>
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
		var logo_img_preview = $('.logo_file').parents('.file_div').find(".img_preview").attr("src");
		var logo_custom_file_label = $('.logo_file').parents('.file_div').find(".custom-file-label").html();
		
		$(".logo_file").on("change", function() {
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
				$(btnThis).parents('.file_div').find(".img_preview").attr("src", logo_img_preview);
				$(btnThis).parents('.file_div').find(".custom-file-label").html(logo_custom_file_label);
			}
		});

		var favicon_img_preview = $('.favicon_file').parents('.file_div').find(".img_preview").attr("src");
		var favicon_custom_file_label = $('.favicon_file').parents('.file_div').find(".custom-file-label").html();

		$(".favicon_file").on("change", function() {
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
				$(btnThis).parents('.file_div').find(".img_preview").attr("src", favicon_img_preview);
				$(btnThis).parents('.file_div').find(".custom-file-label").html(favicon_custom_file_label);
			}
		});
	})
</script>
<script>
	$(document).ready(function(){
		$('#submitForm').validate({
			ignore:[],
			errorPlacement: function(error, element){
				error.insertAfter(element);
			},
			errorClass:'text-danger',
			validClass:'text-success',

			submitHandler: function (form) {
				event.preventDefault();
				$('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');
				var formInfo = new FormData($("#submitForm")[0]);
				$.ajax({
					url : "{{route('admin.site-setting-management.site-setting-info.update')}}",
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
		});
	});
</script>
@endsection