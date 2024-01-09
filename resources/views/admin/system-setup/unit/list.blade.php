@extends('admin.layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow-sm">
					<div class="card-header text-right">
						<h4 class="card-title">{{@$title}}</h4>
						<a href="{{route('admin.unit.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> ইউনিট যুক্ত করুন</a>
					</div>
					<div class="card-body">
						<table id="sb-data-table" class="table table-bordered">
							<thead>
								<tr>
									<th width="5%">নং.</th>
									<th>ইউনিট</th>
									<th>বর্তমান অবস্থা</th>
									<th width="15%" class="text-center">অ্যাকশন</th>
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