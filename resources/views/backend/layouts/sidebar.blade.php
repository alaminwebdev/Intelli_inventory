
{{-- Menu Initialized from $nav_menu Array --}}

@php
$prefix=Request::route()->getPrefix();
$route=Route::current()->getName();
$user_role_array=Auth::user()->user_role;
 
if(isset($user_role_array) && count($user_role_array)>0){
  foreach($user_role_array as $rolee){
    $user_role[] = $rolee->role_id;
  }
}else{
  $user_role = [];
  
}
$parentroutearray = explode('.',$route);
$parentroute = $parentroutearray[0];
$childroute = $parentroute.'.'.@$parentroutearray[1];
$nav_menu=[];
@endphp

@if(Auth::user()->id=='1')
@php
$grand_parents = App\Models\Menu::where('parent', 0)->where('status',1)->orderBy('sort', 'asc')->get();
foreach ($grand_parents as  $grand_parent){
  $nav_menu[$grand_parent->id]['grand_parent']=$grand_parent->name;
  $nav_menu[$grand_parent->id]['grand_parent_route']=$grand_parent->route;
  $nav_menu[$grand_parent->id]['grand_parent_icon']=$grand_parent->icon;
  $parents=App\Models\Menu::where('parent', $grand_parent->id)->where('status',1)->orderBy('sort', 'asc')->get();
  foreach($parents as $parent){
    $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_id']=$parent->id;
    $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_name']=$parent->name;
    $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_route']=$parent->route;
    $childs=App\Models\Menu::where('parent', $parent->id)->where('status',1)->orderBy('sort', 'asc')->get();
    foreach($childs as $child){
      $nav_menu[$grand_parent->id]['is_child']='yes';
      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_id']=$child->id;
      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_name']=$child->name;
      $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_route']=$child->route;
    }
  }
}
@endphp
@else
@php
$grand_parents = App\Models\Menu::where('parent', 0)->where('status',1)->where('id','!=',1)->orderBy('sort', 'asc')->get();
foreach ($grand_parents as  $grand_parent){
  $parents=App\Models\Menu::where('parent', $grand_parent->id)->where('status',1)->orderBy('sort', 'asc')->get();
  foreach($parents as $parent){
    $check_parent=App\Models\MenuPermission::where('menu_id',$parent->id)->whereIn('role_id',@$user_role)->first();
    if($check_parent){
      $permission=App\Models\MenuPermission::where('permitted_route',$parent->route)->whereIn('role_id', @$user_role)->first();
      if($permission){
        $nav_menu[$grand_parent->id]['grand_parent']=$grand_parent->name;
        $nav_menu[$grand_parent->id]['grand_parent_route']=$grand_parent->route;
        $nav_menu[$grand_parent->id]['grand_parent_icon']=$grand_parent->icon;
        $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_id']=$parent->id;
        $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_name']=$parent->name;
        $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_route']=$parent->route;
      }
    }

    $childs=App\Models\Menu::where('parent', $parent->id)->where('status',1)->orderBy('sort', 'asc')->get();
    if(count($childs)>0){
      foreach($childs as $child){
        $permission=App\Models\MenuPermission::where('permitted_route',$child->route)->whereIn('role_id', @$user_role)->first();
        if($permission){
          $nav_menu[$grand_parent->id]['is_child']='yes';
          $nav_menu[$grand_parent->id]['grand_parent']=$grand_parent->name;
          $nav_menu[$grand_parent->id]['grand_parent_route']=$grand_parent->route;
          $nav_menu[$grand_parent->id]['grand_parent_icon']=$grand_parent->icon;
          $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_name']=$parent->name;
          $nav_menu[$grand_parent->id]['parent'][$parent->id]['parent_route']=$parent->route;
          $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_id']=$child->id;
          $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_name']=$child->name;
          $nav_menu[$grand_parent->id]['parent'][$parent->id]['child'][$child->id]['child_route']=$child->route;
        }
      }
    }
  }
}
@endphp
@endif
  <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #222d32;">
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{asset('public/images/logo/bup_logo.png')}}" alt="Admin Dashboard" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light" style="font-size: 15px;font-weight: bold;">BUP</span>
    </a>
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('public/images/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="true">
          <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link {{$route == 'dashboard'?'active':''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          @foreach($nav_menu as $grand_menu)
          <li class="nav-item has-treeview {{$parentroute==$grand_menu['grand_parent_route'] ? 'menu-open' :''}}">
            <a href="#" class="nav-link {{$parentroute==$grand_menu['grand_parent_route'] ? 'active' :''}}">
              <i class="nav-icon {{$grand_menu['grand_parent_icon'] ? $grand_menu['grand_parent_icon'] :'fas fa-tools'}}"></i>
              <p>
                {{$grand_menu['grand_parent']}}
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview" style="{{$parentroute==$grand_menu['grand_parent_route'] ? 'display:block' :'display:none'}}">
              @foreach($grand_menu['parent'] as $parent_menu)
              @if(!empty($parent_menu['child']))
              @else
              <li class="nav-item">
                <a href="{{route($parent_menu['parent_route'])}}" class="nav-link {{$route==$parent_menu['parent_route'] ? 'active' : ''}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>{{$parent_menu['parent_name']}}</p>
                </a>
              </li>
              @endif
              @endforeach
            </ul>
          </li>
          @endforeach
        </ul>
      </nav>
    </div>
  </aside>






