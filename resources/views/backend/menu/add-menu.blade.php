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
<div class="col-xl-12">
	<div class="breadcrumb-holder">
		<h1 class="main-title float-left">Menu add</h1>
		<ol class="breadcrumb float-right">
			<li class="breadcrumb-item"><a href="{{route('dashboard')}}"><strong>Home</strong></a></li>
			<li class="breadcrumb-item active">Menu</li>
		</ol>
		<div class="clearfix"></div>
	</div>
</div>

<div class="container fullbody">
	<div class="col-md-12">
		<div class="card">
			<div class="card-header">
				<h5>Menu সংযোজন<a class="btn btn-sm btn-success float-right" href="{{route('menu')}}"><i class="fa fa-list"></i> Menu তালিকা</a></h5>
			</div>
			<!-- Form Start-->
			<form method="post" action="{{(@$editData)?(route('menu.update',$editData->id)):route('menu.store')}}" id="myForm">
				@csrf
				<div class="card-body">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Menu Name</label>
								<input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" placeholder="Enter Menu Name" >
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group {{ $errors->has('parent') ? 'has-error' : '' }}">
								<label class="control-label">Menu Type</label>
								<select id="parent" name="parent" class="form-control">
									<option value="">Select Type</option>
									<option value="0">Parent Menu</option>
									@foreach($parentMenu as $pm)
									<option value="{{ $pm->id }}" {{ old('parent') == $pm->id ? 'selected' : '' }} > {{ $pm->name }} </option>
									@endforeach
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Sub Menu <small>(if exist)</small></label>
								<select id="parentchield" name="parentchield" class="form-control">
									<option value="">Select Sub Menu</option>
									<option value="0">None</option>
								</select>
							</div>
						</div>
						<!-- <div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">Sub Sub Menu <small>(if exist)</small></label>
								<select id="parentchildchield" name="parentchildchield" class="form-control">
									<option value="">Select Sub Sub Menu</option>
									<option value="0">None</option>
								</select>
							</div>
						</div> -->
						<div class="col-sm-6">
							<div class="form-group">
								<label class="control-label">URL(Route Name)</label>
								<input type="text" id="url" name="url" value="{{ old('url') }}" class="form-control" placeholder="Enter Route Name">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Status</label>
								<select id="status" name="status" class="form-control">
									<option value="">Select Status</option>
									<option value="1" selected>Active</option>
									<option value="0">Inactive</option>
								</select>
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Sort Order</label>
								<input type="number" id="sort"  value="{{ old('sort') }}" name="sort" class="form-control" placeholder="Enter Sort Number">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">Icon</label>
								<input data-toggle="modal" data-target="#iconListModal" data-backdrop="static" data-keyboard="false" type="text" id="icon" name="icon" value="" class="form-control" placeholder="Enter Icon" readonly="readonly">
							</div>
						</div>
						<div class="col-sm-3">
							<div class="form-group">
								<label class="control-label">if Exist Extra route</label>
								<button type="button" class="btn btn-default btn-block addextraRoute">add More Route</button>
							</div>
						</div>
					</div>
					<div id="addextraRouteDiv"></div>
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-sm">{{(@$editData) ? 'হাল নাগাদ করুন ' : 'জমা দিন'}}</button>
							</div>
						</div>
					</div>
				</div>
			</form>
			<!--Form End-->
		</div>
	</div>
</div>


<div class="modal fade" id="iconListModal" role="dialog">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Icon List</h4>
				<button type="button" class="close demo-icon" data-dismiss="modal">&times;</button>
			</div>
			<div class="modal-body">
				<div class="">
					<div class="">
						<div class="clearfix demo-icon-list">
							<div class="row">
							@foreach($icon as $i)
								<div class="col-sm-6 col-md-6">
									<div class="demo-icon "><i class="{{$i->name}} i-style"></i><span>{{$i->name}}</span></div>
								</div>
							@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<script id="document-template" type="text/x-handlebars-template">
	<div class="remove_extraRouteDiv" id="remove_extraRouteDiv">
		<div class="row">
			<div class="col-sm-4">
				<div class="form-group">
					<label class="control-label">Menu Name</label>
					<input type="text" id="newname[]" name="newname[]" value="" class="newname form-control form-control-sm" placeholder="Enter Menu Name" >
				</div>
			</div>
			<div class="col-sm-4">
				<div class="form-group">
					<label class="control-label">URL(Route Name)</label>
					<input type="text" id="newurl[]" name="newurl[]" value="" class="newurl form-control form-control-sm" placeholder="Enter Route Name">
				</div>
			</div>
			<div class="col-sm-2">
				<div class="form-group">
					<label class="control-label">Sort Order</label>
					<input type="number" id="newsort[]"  value="" name="newsort[]" class="newsort form-control form-control-sm" placeholder="Enter Sort Number">
				</div>
			</div>
			<div class="form-group col-md-2" style="padding-top: 30px;">
				<i class="btn btn-info fa fa-plus-circle addextraRoute"></i>
				<i class="btn btn-danger fa fa-minus-circle removeextraRoute"> </i>
			</div>
		</div>
	</div>
</script>


<script type="text/javascript">
	$(document).ready(function(){
		var checkhas = '0';
		$(document).on("click",".addextraRoute",function(){
			var source = $("#document-template").html();
			var template = Handlebars.compile(source);
			var data= {checkhas:checkhas};
			var html = template(data);
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

		$(document).on('change','#parent',function(){
			var parent = $(this).val();
			$.ajax({
		      url: "{{ route('menu.getajaxsubparent') }}",
		      type: "GET",
		      data: {'parent' : parent},
		      success: function(data){
		      	var html = '<option value="0">None</option>';
    			$.each( data, function( key, v ) {
    				html +='<option value="'+v.id+'">'+v.name+'</option>';
    			});
    			$('#parentchield').html(html);
		      }
		    });
		});

		$(document).on('change','#parentchield',function(){
			var parent = $(this).val();
			$.ajax({
		      url: "{{ route('menu.getajaxsubparent') }}",
		      type: "GET",
		      data: {'parent' : parent},
		      success: function(data){
		      	var html = '<option value="0">None</option>';
    			$.each( data, function( key, v ) {
    				html +='<option value="'+v.id+'">'+v.name+'</option>';
    			});
    			$('#parentchildchield').html(html);
		      }
		    });
		});
	});
</script>

@endsection