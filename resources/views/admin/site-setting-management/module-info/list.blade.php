@extends('admin.layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header text-right">
						<h4 class="card-title">{{@$title}}</h4>
						<a href="{{route('admin.site-setting-management.module-info.add') }}" class="btn btn-sm btn-info" data-swup><i class="fas fa-plus"></i> Add Module</a>
					</div>
					<div class="card-body" style="margin-bottom: 30px;">
						<table class="table table-sm table-bordered table-striped">
							<thead>
								<tr>
									<th width="5%">SL.</th>
									<th>Name</th>
									<th>Color</th>
									<th>Status</th>
									<th width="10%" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody id="sortable" class="sortable">
								@foreach($modules as $list)
								<tr data-id="{{$list->id}}">
									<td>{{ $loop->iteration}}</td>
									<td>{{ $list->name ?? 'Without Module'}}</td>
									<td class="text-center">
										<span style ="background:{{ $list->color ?? ''}}; padding: 5px 25px 5px 25px; border-radius: 8px"></span>
									</td>
									<td>{!! activeStatus($list->status) !!}</td>
									<td class="text-center">
										<a class="btn btn-sm btn-success" href="{{route('admin.site-setting-management.module-info.edit',$list)}}">
											<i class="fa fa-edit"></i>
										</a>
										<a class="btn btn-sm btn-danger destroy" data-route="#">
											<i class="fa fa-trash"></i>
										</a>
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
					url: "{{route('admin.site-setting-management.module-info.sorting')}}",
					type: "get",
					data: {jsondata:jsondata},
					dataType: 'json',
					success: function (data) {

					}
				});
			}
		}).disableSelection();
	})
</script>
@endsection