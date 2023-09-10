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
		<h1 class="main-title float-left">Menu List</h1>
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
				<a id="demo-btn-addrow" class="btn btn-success btn-sm" href="{{route('menu.add')}}">
					<i class="ion-plus"></i> Add Menu
				</a>
			</div>
			<div class="card-body">
				<table id="datatable" class="table table-sm table-bordered">
					<thead>
						<tr>
							<th style="width:8%" class="text-center">Icon</th>
							<th class="text-center">Name</th>
							<th class="text-center">Parent</th>
							<th class="text-center">Route</th>							
							<th style="width: 18%" class="text-center">Exist Route(optional)</th>
							<th class="text-center">Order</th>
							<th class="text-center">Action</th>
						</tr>
					</thead>
					<tbody>
						@foreach ($menus as  $menu)
						@php 
						if($menu->parent == 0){
							$parent_name = $menu->name;        
						}else{
							$parent = App\Models\Menu::where('id',$menu->parent)->first();
							$parent_name = $parent->name;
						}
						@endphp
						<tr>
							<td class="text-center"><i class="{{ $menu->icon }}"></i></td>
							<td>
								<span class="text-semibold">{{ $menu->name }}</span>            
								<input class="menuId" type="hidden" value="{{ $menu->id }}" />
							</td>
							<td class="text-center"><span class="{{($menu->parent==0)?'text-success':''}} text-semibold">{{ $parent_name }}</span></td>
							<td class="text-center"><span class="text-semibold">{{ $menu->route }}</span></td>
							<td class="text-center"></td>
							<td class="text-center"><span class="text-semibold">{{ $menu->sort }}</span></td>
							<td class="text-center">
								<a class="btn btn-sm btn-success" href="{{route('menu.edit',$menu->id)}}">
									<i class="fa fa-edit"></i>
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

@endsection