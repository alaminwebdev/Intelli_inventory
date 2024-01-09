@extends('admin.layouts.app')
@section('content')
<style>
	.custom-size .colorpicker-saturation {
		width: 250px;
		height: 250px;
	}

	.custom-size .colorpicker-hue,
	.custom-size .colorpicker-alpha {
		width: 40px;
		height: 250px;
	}

	.custom-size .colorpicker-color,
	.custom-size .colorpicker-color div {
		height: 40px;
	}
</style>
<link rel="stylesheet" href="{{asset('extra-plugins')}}/colorpicker/css/colorpicker.css">
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header text-right">
						<h4 class="card-title">{{@$title}}</h4>
						<a href="{{route('admin.site-setting-management.module-info.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list"></i> Module List</a>
					</div>
					<div class="card-body">
						<form id="submitForm">
							@csrf
							<div class="form-row">
								<div class="form-group col-sm-4">
									<label class="control-label">Name</label>
									<input type="text" name="name" id="name" value="{{ $editData->name ?? old('name') }}" class="form-control form-control-sm name" placeholder="Name">
								</div>
								<div class="form-group col-sm-4">
									<label class="control-label">Status</label>
									<select name="status" id="status" class="form-control form-control-sm status select2">
										<option value="1" {{(@$editData->status == '1')?('selected'):''}}>Active</option>
										<option value="0" {{(@$editData->status == '0')?('selected'):''}}>Inactive</option>
									</select>
								</div>

								<div class="form-group col-md-4">
									<label class="control-label">Color</label>
									<div class="input-group input-group-sm colorpicker-component">
										<input type="text" name="color" id="color" class="form-control form-control-sm color" value="{{!empty(@$editData->color) ? (@$editData->color) : ''}}" placeholder="Enter Color Code" readonly>
										<div class="input-group-append">
											<span class="input-group-text" style="padding-bottom: 0px">
												<span class="input-group-addon"><i  style="padding-left:40px !important"></i></span>
											</span>
										</div>
									</div>
								</div>
							</div>							
							<div class="row">
								<div class="col-sm-12">
									<div class="form-group text-right">
										@if(@$editData->id)
										<button type="submit" class="btn btn-success btn-sm">Update</button>
										@else
										<button type="submit" class="btn btn-success btn-sm">Save</button>
										<button type="reset" class="btn btn-danger btn-sm">Clear</button>
										@endif
										<button type="button" class="btn btn-default btn-sm ion-android-arrow-back">
											<a href="{{route('admin.site-setting-management.module-info.list') }}">Back</a>
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
<script type="text/javascript" src="{{asset('extra-plugins')}}/colorpicker/js/colorpicker.js"></script>
<script>
	$(function () {
		$('.colorpicker-component').colorpicker({
			customClass: 'custom-size',
			sliders: {
				saturation: {
					maxLeft: 250,
					maxTop: 250
				},
				hue: {
					maxTop: 250
				},
				alpha: {
					maxTop: 250
				}
			}
		});
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
					url : "{{ isset($editData) ? route('admin.site-setting-management.module-info.update',$editData->id) : route('admin.site-setting-management.module-info.store') }}",
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
				remote: {
					url: "{{route('admin.site-setting-management.module-info.duplicate-name-check')}}",
					type: "GET",
					data: {
						name: function(){return $("#name").val();},
						edit_data: function(){return "{{@$editData->id}}"}
					},
				},
			}
		});
	});
</script>



@endsection