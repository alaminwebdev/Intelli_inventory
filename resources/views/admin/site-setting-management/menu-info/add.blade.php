@extends('admin.layouts.app')   
@section('content')
<?php 

if (!function_exists('getPrivateSubMenu')) {
	function getPrivateSubMenu($wheredata = ['parent' => null], $selected_sub_menu_id = null)
	{
		$sub_menus = App\Models\Menu::where('parent', $wheredata['parent'])->orderBy('sort', 'asc')->get();
		$html      = '<option value="">' . __('Select Sub Menu') . '</option>';
		foreach ($sub_menus as $key => $sub_menu) {
			if ($selected_sub_menu_id == $sub_menu->id) {
				$select = 'selected';
			} else {
				$select = '';
			}
			$html .= '<option value="' . $sub_menu['id'] . '" ' . @$select . '>' . $sub_menu['name'] . ' ( ' . $sub_menu['module']['name'] . ' ) ' . '</option>';
		}
		return $html;
	}
}
?>
<section class="content">  
	<div class="container-fluid">  
		<div class="row">  
			<div class="col-lg-12">  
				<div class="card">  
					<div class="card-header text-right">  
						<h4 class="card-title">{{@$title}}</h4>
						<a href="{{route('admin.site-setting-management.menu-info.list')}}" class="btn btn-sm btn-info"><i class="fas fa-list"></i> Menu List</a>  
					</div>  
					<div class="card-body">  
						<form id="submitForm">  
							@csrf  
							<div class="row">  
								<div class="col-sm-4">  
									<div class="form-group">  
										<label class="control-label">Menu Name </label>  
										<input type="text" name="name" value="{{@$editData->name}}" class="form-control form-control-sm name" placeholder="Enter Menu Name" >                 
									</div>  
								</div>
								<div class="col-sm-4">  
									<div class="form-group {{$errors->has('module_id') ? 'has-error' : ''}}">   
										<label class="control-label">Module</label>  
										<select name="module_id" class="form-control form-control-sm select2 module_id">
											<option value="">Select Module Name</option>
											@foreach($modules as $module)
											<option value="{{$module->id}}" {{($module->id == @$editData->module_id)?('selected'):''}}>{{($module->name)?($module->name):'Without Module'}}</option>
											@endforeach
										</select>  
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group {{$errors->has('main_menu') ? 'has-error' : ''}}">   
										<label class="control-label">Main Menu</label>  
										<select name="main_menu" class="form-control form-control-sm select2 main_menu">  
											<?php echo getPrivateSubMenu($wheredata=['parent'=>0],$selected_sub_menu_id = @$menu_parent[0]);?>   
										</select>  
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group {{$errors->has('parent') ? 'has-error' : ''}}">   
										<label class="control-label">Sub Menu 1</label>  
										<select name="sub_menu_1" class="form-control form-control-sm select2 sub_menu_1">  
											<?php echo getPrivateSubMenu($wheredata=['parent'=>@$menu_parent[0]],$selected_sub_menu_id = @$menu_parent[1]);?>   
										</select>  
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group {{$errors->has('parent') ? 'has-error' : ''}}">   
										<label class="control-label">Sub Menu 2</label>  
										<select name="sub_menu_2" class="form-control form-control-sm select2 sub_menu_2">  
											<?php echo getPrivateSubMenu($wheredata=['parent'=>@$menu_parent[1]],$selected_sub_menu_id = @$menu_parent[2]);?>   
										</select>  
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group {{$errors->has('parent') ? 'has-error' : ''}}">   
										<label class="control-label">Sub Menu 3</label>  
										<select name="sub_menu_3" class="form-control form-control-sm select2 sub_menu_3">  
											<?php echo getPrivateSubMenu($wheredata=['parent'=>@$menu_parent[2]],$selected_sub_menu_id = @$menu_parent[3]);?>   
										</select>  
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group {{$errors->has('parent') ? 'has-error' : ''}}">   
										<label class="control-label">Sub Menu 4</label>  
										<select name="sub_menu_4" class="form-control form-control-sm select2 sub_menu_4">  
											<?php echo getPrivateSubMenu($wheredata=['parent'=>@$menu_parent[3]],$selected_sub_menu_id = @$menu_parent[4]);?>   
										</select>  
									</div>  
								</div>
								<div class="col-sm-4">  
									<div class="form-group">  
										<label class="control-label">URL Path</label>  
										<input type="text" name="url_path" value="{{@$editData->url_path}}" class="form-control form-control-sm url_path" placeholder="Enter URL Path">
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group">  
										<label class="control-label">Status</label>  
										<select name="status" class="form-control form-control-sm select2 status">  
											<option value="">Select Status</option>  
											<option value="1" {{(@$editData->status == '1')?("selected"):""}}>Active</option>  
											<option value="0" {{(@$editData->status == '0')?("selected"):""}}>Inactive</option>  
										</select>  
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group">  
										<label class="control-label">Sort Order</label>  
										<input type="number"  value="{{@$editData->sort}}" name="sort" class="form-control form-control-sm sort" placeholder="Enter Sort Number">  
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group">  
										<label class="control-label">Icon</label>    
										<input data-toggle="modal" data-target="#iconListModal" data-backdrop="static" data-keyboard="false" type="text" name="icon" id="icon" value="{{@$editData->icon}}" class="form-control form-control-sm icon" placeholder="Enter Icon Name" readonly="readonly">  
									</div>  
								</div>  
								<div class="col-sm-4">  
									<div class="form-group">  
										<label class="control-label">If Exist Extra Route</label>    
										<button type="button" class="btn btn-sm btn-default btn-block addextraRoute">Add More Route</button>  
									</div>  
								</div>  
							</div>  
							<div id="addextraRouteDiv">  
								@if(@$menuRoutes != null)  
								@foreach($menuRoutes as $sl=>$val)  
								<div class="remove_extraRouteDiv card card-body" style="background: #e9e9e9;">                 
									<div class="row">  
										<div class="col-sm-2">  
											<div class="form-group">  
												<label class="control-label">Menu Name </label>  
												<input type="text" id="extra_name[{{$val->id}}]" name="extra_name[{{$val->id}}]" value="{{$val->name}}" class="extra_name form-control form-control-sm" placeholder="Enter Menu Name" >                 
											</div>  
										</div>
										<div class="col-md-2">
											<div class="form-group" style="padding: 14px;margin-bottom: 0px;background: white;border-radius: 10px;">
												<div class="custom-control custom-radio">
													<input class="custom-control-input extra_section_or_route" type="radio" id="extra_section_or_route_{{$val->id}}_1" value="section" name="extra_section_or_route[{{$val->id}}]" {{($val->section_or_route != 'route')?('checked'):''}}>
													<label for="extra_section_or_route_{{$val->id}}_1" class="custom-control-label">Section</label>
												</div>
												<div class="custom-control custom-radio">
													<input class="custom-control-input extra_section_or_route" type="radio" id="extra_section_or_route_{{$val->id}}_2" value="route" name="extra_section_or_route[{{$val->id}}]" {{($val->section_or_route == 'route')?('checked'):''}}>
													<label for="extra_section_or_route_{{$val->id}}_2" class="custom-control-label">Route</label>
												</div>
											</div>
										</div>
										<div class="col-sm-3">  
											<div class="form-group">  
												<label class="control-label">Section/Route Name</label>  
												<input type="text" id="extra_route[{{$val->id}}]" name="extra_route[{{$val->id}}]" value="{{$val->route}}" class="extra_route form-control form-control-sm" placeholder="Enter Route Name">  
											</div>  
										</div>  
										<div class="col-sm-2">  
											<div class="form-group">  
												<label class="control-label">Sort Order</label>  
												<input type="number" id="extra_sort[{{$val->id}}]" name="extra_sort[{{$val->id}}]" value="{{$val->sort}}" class="extra_sort form-control form-control-sm" placeholder="Enter Sort Number">  
											</div>  
										</div>  
										<div class="form-group col-md-1" style="padding-top: 30px;">
											<button class="btn btn-sm btn-info addextraRoute">
												<i class="fa fa-plus-circle"></i>
											</button>  
											<button class="btn btn-sm btn-danger removeextraRoute">
												<i class="fa fa-minus-circle"></i>
											</button> 
										</div>  
									</div>							   
								</div>  
								@endforeach  
								@endif  
							</div>  
							<div class="row">	   
								<div class="col-sm-6">  
									<div class="form-group">  
										<button type="submit" class="btn btn-sm btn-success">{{(@$editData) ? __('Update') : __('Save')}}</button>  
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
@include('admin.site-setting-management.menu-info.all-icon-list')   

<script src="{{asset('extra-plugins')}}/handlebar/js/handlebars-v4.0.12.js"></script>
<script id="document-template" type="text/x-handlebars-template">  
	<div class="remove_extraRouteDiv card card-body" style="background: #e9e9e9;">  
		<div class="row">  
			<div class="col-sm-2">  
				<div class="form-group">  
					<label class="control-label">Menu Name </label>  
					<input type="text" id="extra_name[@{{counter}}]" name="extra_name[@{{counter}}]" value="" class="extra_name form-control form-control-sm" placeholder="Enter Menu Name" >                 
				</div>  
			</div>
			<div class="col-md-2">
				<div class="form-group" style="padding: 14px;margin-bottom: 0px;background: white;border-radius: 10px;">
					<div class="custom-control custom-radio">
						<input class="custom-control-input extra_section_or_route" type="radio" id="extra_section_or_route_@{{counter}}_1" value="section" name="extra_section_or_route[@{{counter}}]" checked>
						<label for="extra_section_or_route_@{{counter}}_1" class="custom-control-label">Section</label>
					</div>
					<div class="custom-control custom-radio">
						<input class="custom-control-input extra_section_or_route" type="radio" id="extra_section_or_route_@{{counter}}_2" value="route" name="extra_section_or_route[@{{counter}}]">
						<label for="extra_section_or_route_@{{counter}}_2" class="custom-control-label">Route</label>
					</div>
				</div>
			</div>
			<div class="col-sm-3">  
				<div class="form-group">  
					<label class="control-label">Section/Route Name</label>  
					<input type="text" id="extra_route[@{{counter}}]" name="extra_route[@{{counter}}]" value="" class="extra_route form-control form-control-sm" placeholder="Enter Route Name">  
				</div>  
			</div>  
			<div class="col-sm-2">  
				<div class="form-group">  
					<label class="control-label">Sort Order</label>  
					<input type="number" id="extra_sort[@{{counter}}]"  value="" name="extra_sort[@{{counter}}]" class="extra_sort form-control form-control-sm" placeholder="Enter Sort Number">  
				</div>  
			</div>  
			<div class="form-group col-md-1" style="padding-top: 30px;">
				<button class="btn btn-sm btn-info addextraRoute">
					<i class="fa fa-plus-circle"></i>
				</button>  
				<button class="btn btn-sm btn-danger removeextraRoute">
					<i class="fa fa-minus-circle"></i>
				</button>
			</div>  
		</div>							   
	</div>  
</script>  


<script type="text/javascript">  
	$(document).ready(function(){  
		var counter = '10000000';  
		$(document).on("click",".addextraRoute",function(){  
			var source = $("#document-template").html();  
			var template = Handlebars.compile(source);   
			var data= {counter:counter};   
			var html = template(data);   
			counter ++;  
			$("#addextraRouteDiv").append(html);   
		});   

		$(document).on("click", ".removeextraRoute", function (event) {  
			$(this).closest(".remove_extraRouteDiv").remove();         
		});   
	});   
</script>  

<script type="text/javascript">  
	$(document).ready(function() {  
		$(".demo-icon").click(function(){  
			var icon = $(this).find('span').html();     
			$('#icon').val(icon);     
			$('#iconListModal').modal('toggle');   
		});   
	});   
</script>  



<script>  
	$(document).ready(function(){  
		$('#submitForm').validate({  
			ignore:[], 
			errorPlacement: function(error, element){
				if(element.hasClass("parentchield")){error.insertAfter(element.next()); }
				else if (element.hasClass("status")){error.insertAfter(element.next()); }
				else if (element.hasClass("extra_section_or_route")){error.insertAfter(element.parents('.form-group')); }
				else{error.insertAfter(element);}
			},
			errorClass:'text-danger',   
			validClass:'text-success',   

			submitHandler: function (form) {  
				event.preventDefault();  
				$('[type="submit"]').attr('disabled','disabled').css('cursor','not-allowed');   
				var formInfo = new FormData($("#submitForm")[0]);   
				$.ajax({  
					url : "{{(@$editData)?(route('admin.site-setting-management.menu-info.update',@$editData->id)):route('admin.site-setting-management.menu-info.store')}}",   
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
			// name: {  
			// 	required: true,  
			// },
			// url_path: {  
			// 	required: true,  
			// },   
			// status: {  
			// 	required: true,  
			// },  
			// sort: {  
			// 	required: true,  
			// },  
			// extra_name: {  
			// 	required: true,  
			// },
			// extra_section_or_route: {  
			// 	required: true,
			// },  
			// extra_route: {  
			// 	required: true,  
			// },
			// extra_sort: {  
			// 	required: true,  
			// }  
		});   
	});   
</script>  

<script type="text/javascript">  
	$(document).on('change','.main_menu',function(){  
		var exist = $('.sub_menu_1').hasClass('select2');   
		if($('.sub_menu_1').length){  
			var parent = $('.main_menu').val();  
			$.ajax({  
				url:"{{route('admin.site-setting-management.menu-info.get-sub-menu')}}",   
				type:"GET",   
				data:{parent:parent},   
				success:function(data){  
					$('.sub_menu_1').html(data);   
					if(exist == true){  
						$('.sub_menu_1').val('').select2();  
					}  
				}  
			});   
		}  
	});   
</script>  

<script type="text/javascript">  
	$(document).on('change','.sub_menu_1',function(){  
		var exist = $('.sub_menu_2').hasClass('select2');   
		if($('.sub_menu_2').length){  
			var parent = $('.sub_menu_1').val();  
			$.ajax({  
				url:"{{route('admin.site-setting-management.menu-info.get-sub-menu')}}",   
				type:"GET",   
				data:{parent:parent},   
				success:function(data){  
					$('.sub_menu_2').html(data);   
					if(exist == true){  
						$('.sub_menu_2').val('').select2();  
					}  
				}  
			});   
		}  
	});   
</script>  

<script type="text/javascript">  
	$(document).on('change','.sub_menu_2',function(){  
		var exist = $('.sub_menu_3').hasClass('select2');   
		if($('.sub_menu_3').length){  
			var parent = $('.sub_menu_2').val();  
			$.ajax({  
				url:"{{route('admin.site-setting-management.menu-info.get-sub-menu')}}",   
				type:"GET",   
				data:{parent:parent},   
				success:function(data){  
					$('.sub_menu_3').html(data);   
					if(exist == true){  
						$('.sub_menu_3').val('').select2();  
					}  
				}  
			});   
		}  
	});   
</script>  

<script type="text/javascript">  
	$(document).on('change','.sub_menu_3',function(){  
		var exist = $('.sub_menu_4').hasClass('select2');   
		if($('.sub_menu_4').length){  
			var parent = $('.sub_menu_3').val();  
			$.ajax({  
				url:"{{route('admin.site-setting-management.menu-info.get-sub-menu')}}",   
				type:"GET",   
				data:{parent:parent},   
				success:function(data){  
					$('.sub_menu_4').html(data);   
					if(exist == true){  
						$('.sub_menu_4').val('').select2();  
					}  
				}  
			});   
		}  
	});   
</script>  

@endsection  
