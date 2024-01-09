@extends('admin.layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header text-right">
						<h4 class="card-title">{{@$title}}</h4>
						@if(sorpermission('admin.role-management.role-info.add'))
						<a href="{{route('admin.role-management.role-info.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus"></i> Add Role</a>
						@endif
					</div>
					<div class="card-body">
						<table id="dataTable" class="table table-sm table-bordered table-striped">
							<thead>
								<tr>
									<th width="5%">SL.</th>
									<th>Name</th>
									<th width="30%">Functionalities of this Role</th>
									<th>OTP</th>
									<th>Status</th>
									<th width="10%" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody id="sortable" class="sortable">
								@foreach($roles as $list)
								<tr data-id="{{$list->id}}">
									<td>{{ $loop->iteration}}</td>
									<td>{{ $list->name }}</td>
									<td class="text-center">{{ $list->description ?? 'N/A'}}</td>
									<td>{{(count(@$list->otp_role_list) > 0)?(implode(',',$list->otp_role_list->pluck('otp')->pluck('name')->toArray())):("N/A")}}</td>
									<td>{!! activeStatus($list->status) !!}</td>
									<td class="text-center">
										@if(sorpermission('admin.role-management.role-info.edit'))
										<a class="btn btn-sm btn-success" href="{{route('admin.role-management.role-info.edit',$list)}}">
											<i class="fa fa-edit"></i>
										</a>
										@endif
										@if(sorpermission('admin.role-management.role-info.destroy'))
										<a class="btn btn-sm btn-danger destroy" data-id="{{$list->id}}" data-route="{{route('admin.role-management.role-info.destroy')}}">
											<i class="fa fa-trash"></i>
										</a>
										@endif
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<script type="text/javascript">
	$(function(){
		$("#sortable").sortable({
			update:function(event, ui){
				var jsonSortable = [];
				jsonSortable.length = 0;
				$("#sortable tr").each(function (index, value){
					let item = {};
					item.id = $(this).data("id");
					jsonSortable.push(item);
				});

				var jsondata = JSON.stringify(jsonSortable);
				$.ajax({
					url: "{{route('admin.role-management.role-info.sorting')}}",
					type: "get",
					data: {jsondata:jsondata},
					dataType: 'json',
					success: function (data) {
						console.log(data);
					}
				});
			}
		}).disableSelection();
	})
</script>
@endsection