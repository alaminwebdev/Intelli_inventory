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
						@php
						$email_configuration = json_decode(@$editData->email_configuration,true);
						@endphp
						<form id="submitForm">
							@csrf
							<div class="row">
								<label for="name" class="col-md-2 col-form-label">MAIL_MAILER</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm" name="email_configuration[MAIL_MAILER]" value="{{@$email_configuration['MAIL_MAILER']}}" placeholder="MAIL_MAILER">
								</div>
							</div>
							<div class="row">
								<label for="name" class="col-md-2 col-form-label">MAIL_HOST</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm" name="email_configuration[MAIL_HOST]" value="{{@$email_configuration['MAIL_HOST']}}" placeholder="MAIL_HOST">
								</div>
							</div>
							<div class="row">
								<label for="name" class="col-md-2 col-form-label">MAIL_PORT</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm" name="email_configuration[MAIL_PORT]" value="{{@$email_configuration['MAIL_PORT']}}" placeholder="MAIL_PORT">
								</div>
							</div>
							<div class="row">
								<label for="name" class="col-md-2 col-form-label">MAIL_USERNAME</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm" name="email_configuration[MAIL_USERNAME]" value="{{@$email_configuration['MAIL_USERNAME']}}" placeholder="MAIL_USERNAME">
								</div>
							</div>
							<div class="row">
								<label for="name" class="col-md-2 col-form-label">MAIL_PASSWORD</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm" name="email_configuration[MAIL_PASSWORD]" value="{{@$email_configuration['MAIL_PASSWORD']}}" placeholder="MAIL_PASSWORD">
								</div>
							</div>
							<div class="row">
								<label for="name" class="col-md-2 col-form-label">MAIL_ENCRYPTION</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm" name="email_configuration[MAIL_ENCRYPTION]" value="{{@$email_configuration['MAIL_ENCRYPTION']}}" placeholder="MAIL_ENCRYPTION">
								</div>
							</div>
							<div class="row">
								<label for="name" class="col-md-2 col-form-label">MAIL_FROM_ADDRESS</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm" name="email_configuration[MAIL_FROM_ADDRESS]" value="{{@$email_configuration['MAIL_FROM_ADDRESS']}}" placeholder="MAIL_FROM_ADDRESS">
								</div>
							</div>
							<div class="row">
								<label for="name" class="col-md-2 col-form-label">MAIL_FROM_NAME</label>
								<div class="col-md-10">
									<input type="text" class="form-control form-control-sm" name="email_configuration[MAIL_FROM_NAME]" value="{{@$email_configuration['MAIL_FROM_NAME']}}" placeholder="MAIL_FROM_NAME">
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
// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
  var fileName = $(this).val().split("\\").pop();
  $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});
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
					url : "{{route('admin.site-setting-management.email-configuration-info.update')}}",
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