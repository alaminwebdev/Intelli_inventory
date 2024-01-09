@extends('admin.layouts.app')
@section('content')
<section class="content">
	<div class="container-fluid">
		<div class="row">
			<div class="col-lg-12">
				<div class="card shadow-sm">
					<div class="card-header text-right">
						<h4 class="card-title">{{@$title}}</h4>
						<a href="{{route('admin.product.information.add') }}" class="btn btn-sm btn-info"><i class="fas fa-plus mr-1"></i> পন্য যুক্ত করুন</a>
					</div>
					<div class="card-body">
						<table id="sb-data-table" class="table table-bordered">
							<thead>
								<tr>
									<th width="5%">নং.</th>
									<th>পন্য </th>
									<th>পন্যের ধরন</th>
									<th>বর্তমান অবস্থা</th>
									<th width="15%" class="text-center">অ্যাকশন</th>
								</tr>
							</thead>
							<tbody >
								@foreach($products as $list)
								<tr data-id="{{$list->id}}">
									<td>{{ $loop->iteration}}</td>
									<td>{{ @$list->code }} - {{ @$list->name}}({{ @$list->unit }})</td>
									<td>{{ @$list->product_type}}</td>

									<td>{!! activeStatus($list->status) !!}</td>
									<td class="text-center">
										@if(sorpermission('admin.product.information.edit'))
										<a class="btn btn-sm btn-success" href="{{route('admin.product.information.edit',$list->id)}}">
											<i class="fa fa-edit"></i>
										</a>
										@endif
										@if(sorpermission('admin.product.information.delete'))
										<a class="btn btn-sm btn-danger destroy" data-id="{{$list->id}}" data-route="{{route('admin.product.information.delete')}}">
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