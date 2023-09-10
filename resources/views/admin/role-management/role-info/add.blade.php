@extends('admin.layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<form id="submitForm">
						<div class="card-header">
							<div class="row">
								<div class="col-6">
									<div class="icheck-primary d-inline">
										<input type="checkbox" id="is_super_power" name="is_super_power" {{(@$editData->is_super_power=='1')?('checked'):''}}>
										<label for="is_super_power">Super power</label>
									</div>
								</div>
								<div class="col-6 text-right">
									<a href="{{route('admin.role-management.role-info.list') }}" class="btn btn-sm btn-info"><i class="fas fa-list"></i> Role List</a>
								</div>
							</div>
						</div>
						<div class="card-body">
							@csrf
							<div class="form-row">
								<div class="form-group col-sm-4">
									<label class="control-label">Name</label>
									<input type="text" name="name" id="name" value="{{ $editData->name ?? old('name') }}" class="form-control form-control-sm name" placeholder="Name">
								</div>
								<div class="form-group col-sm-4">
									<label class="control-label">OTP</label>
									<select name="otp_ids[]" id="otp_ids" class="form-control form-control-sm otp_ids select2" multiple>
										@foreach($otps as $otp)
										<option value="{{$otp->id}}" {{(@$editData)?((in_array($otp->id, @$editData->otp_role_list->pluck('otp_id')->toArray()))?('selected'):''):''}}>{{$otp->name}}</option>
										@endforeach
									</select>
								</div>
								<div class="form-group col-sm-4">
									<label class="control-label">Status</label>
									<select name="status" id="status" class="form-control form-control-sm status select2">
										<option value="1" {{(@$editData->status == '1')?('selected'):''}}>Active</option>
										<option value="0" {{(@$editData->status == '0')?('selected'):''}}>Inactive</option>
									</select>
								</div>
								<div class="form-group col-sm-12">
									<label class="control-label">Functionalities of this Role</label>
									<textarea name="description" id="description" rows="3" class="form-control form-control-sm description" placeholder="Functionalities of this Role">{{ $editData->description ?? old('description') }}</textarea>
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
											<a href="{{route('admin.role-management.role-info.list') }}">Back</a>
										</button>
									</div>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

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
					url : "{{ isset($editData) ? route('admin.role-management.role-info.update',$editData) : route('admin.role-management.role-info.store') }}",
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
					url: "{{route('admin.role-management.role-info.duplicate-name-check')}}",
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