 @extends('admin.layouts.app')
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


 	.dd { position: relative; display: block; margin: 0; padding: 0; max-width: 600px; list-style: none; font-size: 13px; line-height: 20px; }
 	.dd-list { display: block; position: relative; margin: 0; padding: 0; list-style: none; }
 	.dd-list .dd-list { padding-left: 30px; }
 	.dd-collapsed .dd-list { display: none; }
 	.dd-item,
 	.dd-empty,
 	.dd-placeholder { display: block; position: relative; margin: 0; padding: 0; min-height: 20px; font-size: 13px; line-height: 20px; }
 	.dd-handle { display: block; height: 30px; margin: 5px 0; padding: 5px 10px; color: #333; text-decoration: none; font-weight: bold; border: 1px solid #ccc;
 		background: #fafafa;
 		background: -webkit-linear-gradient(top, #fafafa 0%, #eee 100%);
 		background:    -moz-linear-gradient(top, #fafafa 0%, #eee 100%);
 		background:         linear-gradient(top, #fafafa 0%, #eee 100%);
 		-webkit-border-radius: 3px;
 		border-radius: 3px;
 		box-sizing: border-box; -moz-box-sizing: border-box;
 	}
 	.dd-handle:hover { color: #2ea8e5; background: #fff; }
 	.dd-item > button { display: block; position: relative; cursor: pointer; float: left; width: 25px; height: 20px; margin: 5px 0; padding: 0; text-indent: 100%; white-space: nowrap; overflow: hidden; border: 0; background: transparent; font-size: 12px; line-height: 1; text-align: center; font-weight: bold; }
 	.dd-item > button:before { content: '+'; display: block; position: absolute; width: 100%; text-align: center; text-indent: 0; }
 	.dd-item > button[data-action="collapse"]:before { content: '-'; }
 	.dd-placeholder,
 	.dd-empty { margin: 5px 0; padding: 0; min-height: 30px; background: #f2fbff; border: 1px dashed #b6bcbf; box-sizing: border-box; -moz-box-sizing: border-box; }
 	.dd-empty { border: 1px dashed #bbb; min-height: 100px; background-color: #e5e5e5;
 		background-image: -webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
 		-webkit-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
 		background-image:    -moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
 		-moz-linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
 		background-image:         linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff),
 		linear-gradient(45deg, #fff 25%, transparent 25%, transparent 75%, #fff 75%, #fff);
 		background-size: 60px 60px;
 		background-position: 0 0, 30px 30px;
 	}
 	.dd-dragel { position: absolute; pointer-events: none; z-index: 9999; }
 	.dd-dragel > .dd-item .dd-handle { margin-top: 0; }
 	.dd-dragel .dd-handle {
 		-webkit-box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
 		box-shadow: 2px 4px 6px 0 rgba(0,0,0,.1);
 	}
 	.nestable-lists { display: block; clear: both; padding: 30px 0; width: 100%; border: 0; border-top: 2px solid #ddd; border-bottom: 2px solid #ddd; }
 	#nestable-menu { padding: 0; margin: 20px 0; }
 	#nestable-output{ width: 100%; height: 7em; font-size: 0.75em; line-height: 1.333333em; font-family: Consolas, monospace; padding: 5px; box-sizing: border-box; -moz-box-sizing: border-box; }
 	@media only screen and (min-width: 700px) {
 		.dd { float: left; width: 48%; }
 		.dd + .dd { margin-left: 2%; }
 	}
 	.dd-hover > .dd-handle { background: #2ea8e5 !important; }
 </style>
 <div class="container fullbody" style="margin-bottom: 50px;">
 	<div class="col-md-12">
 		<div class="card">
 			<div class="card-header text-right">
                <h4 class="card-title">{{@$title}}</h4>
 				<a id="demo-btn-addrow" class="btn btn-success btn-sm" href="{{route('admin.site-setting-management.menu-info.add')}}">
 					<i class="ion-plus"></i> Add Menu
 				</a>
 			</div>
 			<div class="card-body">
 				<div class="row">
 					<div class="col-md-12">
 						<div id="nestable" style="width: 100%;">
 							<?php $parents = App\Models\Menu::with(['module'])->join('modules', 'modules.id', '=', 'menus.module_id')->orderBy('modules.sort', 'asc')->orderBy('sort','asc')->where('parent','0')->get(['menus.*']);?>
 							@if(count($parents) != 0)
 							<ol class="dd-list new_data">
 								@foreach($parents as $parent)
 								<li class="dd-item" data-id="{{$parent->id}}">
 									<div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}"> <i class=" text-success {{ $parent->icon }}"></i> | {{$parent->name}} </div>
 									<span style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;">
 										<a href="{{route('admin.site-setting-management.menu-info.edit',$parent->id)}}">
 											<i class="fa fa-edit text-primary"></i>
 										</a>
 									</span>
 									<span style="z-index:10;position:absolute; right:90px; top:4px; cursor:pointer;font-weight: bold;">
 										{{@$parent['module']['name']}}
 									</span>
 									<?php $parents = App\Models\Menu::with(['module'])->join('modules', 'modules.id', '=', 'menus.module_id')->orderBy('modules.sort', 'asc')->orderBy('sort','asc')->where('parent',$parent->id)->get(['menus.*']);?>
 									@if(count($parents) != 0)
 									<ol class="dd-list">
 										@foreach($parents as $parent)
 										<li class="dd-item" data-id="{{$parent->id}}">
 											<div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}"> <i class=" text-success {{ $parent->icon }}"></i> | {{$parent->name}} </div>
 											<span style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;">
 												<a href="{{route('admin.site-setting-management.menu-info.edit',$parent->id)}}">
 													<i class="fa fa-edit text-primary"></i>
 												</a>
 											</span>
 											<span style="z-index:10;position:absolute; right:90px; top:4px; cursor:pointer;font-weight: bold;">
 												{{@$parent['module']['name']}}
 											</span>
 											<?php $parents = App\Models\Menu::with(['module'])->join('modules', 'modules.id', '=', 'menus.module_id')->orderBy('modules.sort', 'asc')->orderBy('sort','asc')->where('parent',$parent->id)->get(['menus.*']);?>
 											@if(count($parents) != 0)
 											<ol class="dd-list">
 												@foreach($parents as $parent)
 												<li class="dd-item" data-id="{{$parent->id}}">
 													<div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}"> <i class=" text-success {{ $parent->icon }}"></i> | {{$parent->name}} </div>
 													<span style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;">
 														<a href="{{route('admin.site-setting-management.menu-info.edit',$parent->id)}}">
 															<i class="fa fa-edit text-primary"></i>
 														</a>
 													</span>
 													<span style="z-index:10;position:absolute; right:90px; top:4px; cursor:pointer;font-weight: bold;">
 														{{@$parent['module']['name']}}
 													</span>
 													<?php $parents = App\Models\Menu::with(['module'])->join('modules', 'modules.id', '=', 'menus.module_id')->orderBy('modules.sort', 'asc')->orderBy('sort','asc')->where('parent',$parent->id)->get(['menus.*']);?>
 													@if(count($parents) != 0)
 													<ol class="dd-list">
 														@foreach($parents as $parent)
 														<li class="dd-item" data-id="{{$parent->id}}">
 															<div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}"> <i class=" text-success {{ $parent->icon }}"></i> | {{$parent->name}} </div>
 															<span style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;">
 																<a href="{{route('admin.site-setting-management.menu-info.edit',$parent->id)}}">
 																	<i class="fa fa-edit text-primary"></i>
 																</a>
 															</span>
 															<span style="z-index:10;position:absolute; right:90px; top:4px; cursor:pointer;font-weight: bold;">
 																{{@$parent['module']['name']}}
 															</span>
 															<?php $parents = App\Models\Menu::with(['module'])->join('modules', 'modules.id', '=', 'menus.module_id')->orderBy('modules.sort', 'asc')->orderBy('sort','asc')->where('parent',$parent->id)->get(['menus.*']);?>
 															@if(count($parents) != 0)
 															<ol class="dd-list">
 																@foreach($parents as $parent)
 																<li class="dd-item" data-id="{{$parent->id}}">
 																	<div class="dd-handle {{($parent->status =='1')?('text-dark'):'text-danger'}}"> <i class=" text-success {{ $parent->icon }}"></i> | {{$parent->name}} </div>
 																	<span style="font-size: 20px;z-index:10;position:absolute; right:35px; top:4px; cursor:pointer;">
 																		<a href="{{route('admin.site-setting-management.menu-info.edit',$parent->id)}}">
 																			<i class="fa fa-edit text-primary"></i>
 																		</a>
 																	</span>
 																	<span style="z-index:10;position:absolute; right:90px; top:4px; cursor:pointer;font-weight: bold;">
 																		{{@$parent['module']['name']}}
 																	</span>
 																</li>
 																@endforeach
 															</ol>
 															@endif
 														</li>
 														@endforeach
 													</ol>
 													@endif
 												</li>
 												@endforeach
 											</ol>
 											@endif
 										</li>
 										@endforeach
 									</ol>
 									@endif
 								</li>
 								@endforeach
 							</ol>
 							@endif
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</div>	
 </div>

 @endsection