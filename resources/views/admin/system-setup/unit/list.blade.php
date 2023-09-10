@extends('admin.layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card">
					<div class="card-header text-right">
						<h4 class="card-title">{{@$title}}</h4>
						<a href="{{route('admin.unit.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> Add Unit</a>
					</div>
					<div class="card-body">
						<table id="dataTable" class="table table-bordered" style="width:100%; border-collapse: collapse;">
							<thead class="thead-custom">
								<tr>
									<th width="5%">SL.</th>
									<th>Unit Name</th>
									<th>Status</th>
									<th width="15%" class="text-center">Action</th>
								</tr>
							</thead>
							<tbody >
								@foreach($units as $list)
								<tr data-id="{{$list->id}}">
									<td>{{ $loop->iteration}}</td>
									<td>{{ @$list->name ?? 'N/A' }}</td>

									<td>{!! activeStatus($list->status) !!}</td>
									<td class="text-center">
										@if(sorpermission('admin.unit.edit'))
										<a class="btn btn-sm btn-success" href="{{route('admin.unit.edit',$list->id)}}">
											<i class="fa fa-edit"></i>
										</a>
										@endif
										@if(sorpermission('admin.unit.delete'))
										<a class="btn btn-sm btn-danger destroy" data-id="{{$list->id}}" data-route="{{route('admin.unit.delete')}}">
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
<script>

</script>
@endsection