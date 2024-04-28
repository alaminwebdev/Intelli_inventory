@php
$user_role = Auth::user()->user_roles->pluck('role_id')->toArray();
$nav_menus = [];
@endphp

<style>
.nav-sidebar .nav-treeview .nav-item{
    position: relative;
}
.nav-sidebar .nav-treeview .nav-item .nav-link{
    padding-left: 35px;
}
.nav-sidebar .nav-treeview .nav-item:before {
    content: "";
    display: block;
    position: absolute;
    width: 9px;
    left: 25px;
    top: 17px;
    border-top: 1px dashed rgba(255,255,255,0.5);
}
.nav-sidebar .nav-treeview .nav-item:after {
    content: "";
    display: block;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 22px;
    width: 0;
    border-left: 1px dashed rgba(255,255,255,0.5);
}
.layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*=navbar]) {
    background-color: #50d8d7;
    background-image: linear-gradient(316deg, #50d8d7 0%, #923993 74%);
    font-weight: 600 !important;
    box-shadow: rgb(83 91 101 / 33%) 0px 7px 20px 0px;
}
[class*=sidebar-dark] .brand-link {
    border-bottom: none !important;
}

[class*=sidebar-dark] .brand-link, [class*=sidebar-dark] .brand-link .pushmenu {
    color: rgb(255 255 255 / 90%);
}
[class*=sidebar-dark-] .sidebar a {
    color: #fff;
}
[class*=sidebar-dark-] .nav-sidebar>.nav-item.menu-open>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item:hover>.nav-link, [class*=sidebar-dark-] .nav-sidebar>.nav-item>.nav-link:focus {
    background: rgba(63, 103, 145, 0.651) !important;
    transition: all .1s linear;
}

[class*=sidebar-dark-] {
    background-color: #50d8d7;
    background-image: linear-gradient(260deg, #50d8d7 0%, #923993 74%);

}
[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link{
    color: #f8f9fa;
}

[class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:focus, [class*=sidebar-dark-] .nav-treeview>.nav-item>.nav-link.active:hover {
    background-color: rgba(63, 103, 145, 0.40);
    color: #fff;
}

.sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active, .sidebar-light-primary .nav-sidebar>.nav-item>.nav-link.active {
    background-color: rgba(63, 103, 145, 0.30);
    color: #fff;
}


[class*=sidebar-dark] .btn-sidebar, [class*=sidebar-dark] .form-control-sidebar {
    background-color: #fff;
    border: 1px solid #ececec;
    color: #1f2d3d;
}
[class*=sidebar-dark] .btn-sidebar:focus, [class*=sidebar-dark] .form-control-sidebar:focus {
    border: 1px solid #ececec;
}
[class*=sidebar-dark] .btn-sidebar:hover, [class*=sidebar-dark] .btn-sidebar:focus  {
    background-color: #fff;
}
</style>



@if (in_array(1, $user_role) || in_array(8, $user_role) )
    @php
        $modules = App\Models\Module::where('status', 1)
            ->orderBy('sort', 'asc')
            ->get();
        foreach ($modules as $module) {
            $nav_menus[$module->id]['name'] = ($module->name=='Moduleless')?(''):($module->name);
            $nav_menus[$module->id]['color'] = @$module->color;
            $parents1 = App\Models\Menu::where('module_id', $module->id)
                ->where('parent', 0)
                ->where('status', 1)
                ->orderBy('sort', 'asc')
                ->get();
            foreach ($parents1 as $parent1) {
                $nav_menus[$module->id]['menus'][$parent1->id]['menu_name'] = $parent1->name;
                $nav_menus[$module->id]['menus'][$parent1->id]['menu_url_path'] = $parent1->url_path;
                $nav_menus[$module->id]['menus'][$parent1->id]['menu_icon'] = $parent1->icon;
                $parents2 = App\Models\Menu::where('parent', $parent1->id)
                    ->where('status', 1)
                    ->orderBy('sort', 'asc')
                    ->get();
                foreach ($parents2 as $parent2) {
                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_name'] = $parent2->name;
                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_url_path'] = $parent2->url_path;
                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_icon'] = $parent2->icon;
                    $parents3 = App\Models\Menu::where('parent', $parent2->id)
                        ->where('status', 1)
                        ->orderBy('sort', 'asc')
                        ->get();
                    foreach ($parents3 as $parent3) {
                        $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_name'] = $parent3->name;
                        $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_url_path'] = $parent3->url_path;
                        $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_icon'] = $parent3->icon;
                        $parents4 = App\Models\Menu::where('parent', $parent3->id)
                            ->where('status', 1)
                            ->orderBy('sort', 'asc')
                            ->get();
                        foreach ($parents4 as $parent4) {
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_name'] = $parent4->name;
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_url_path'] = $parent4->url_path;
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_icon'] = $parent4->icon;
                            $parents4 = App\Models\Menu::where('parent', $parent3->id)
                                ->where('status', 1)
                                ->orderBy('sort', 'asc')
                                ->get();
                        }
                    }
                }
            }
        }
    @endphp
@else
    @php
        $modules = App\Models\Module::where('status', 1)
            ->orderBy('sort', 'asc')
            ->get();
        foreach ($modules as $module) {
            $nav_menus[$module->id]['name'] = ($module->name=='Moduleless')?(''):($module->name);
            $nav_menus[$module->id]['color'] = @$module->color;
            $parents1 = App\Models\Menu::where('module_id', $module->id)
                ->where('parent', 0)
                ->whereNotIn('id', [11])
                ->where('status', 1)
                ->orderBy('sort', 'asc')
                ->get();
            foreach ($parents1 as $parent1) {
                if (
                    App\Models\MenuPermission::where('menu_id', $parent1->id)
                        ->whereIn('role_id', @$user_role)
                        ->where('menu_from', 'menu')
                        ->first()
                ) {
                    $nav_menus[$module->id]['menus'][$parent1->id]['menu_name'] = $parent1->name;
                    $nav_menus[$module->id]['menus'][$parent1->id]['menu_url_path'] = $parent1->url_path;
                    $nav_menus[$module->id]['menus'][$parent1->id]['menu_icon'] = $parent1->icon;
                    $parents2 = App\Models\Menu::where('parent', $parent1->id)
                        ->where('status', 1)
                        ->orderBy('sort', 'asc')
                        ->get();
                    foreach ($parents2 as $parent2) {
                        if (
                            App\Models\MenuPermission::where('menu_id', $parent2->id)
                                ->whereIn('role_id', @$user_role)
                                ->where('menu_from', 'menu')
                                ->first()
                        ) {
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_name'] = $parent2->name;
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_url_path'] = $parent2->url_path;
                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['menu_icon'] = $parent2->icon;
                            $parents3 = App\Models\Menu::where('parent', $parent2->id)
                                ->where('status', 1)
                                ->orderBy('sort', 'asc')
                                ->get();
                            foreach ($parents3 as $parent3) {
                                if (
                                    App\Models\MenuPermission::where('menu_id', $parent3->id)
                                        ->whereIn('role_id', @$user_role)
                                        ->where('menu_from', 'menu')
                                        ->first()
                                ) {
                                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_name'] = $parent3->name;
                                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_url_path'] = $parent3->url_path;
                                    $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['menu_icon'] = $parent3->icon;
                                    $parents4 = App\Models\Menu::where('parent', $parent3->id)
                                        ->where('status', 1)
                                        ->orderBy('sort', 'asc')
                                        ->get();
                                    foreach ($parents4 as $parent4) {
                                        if (
                                            App\Models\MenuPermission::where('menu_id', $parent4->id)
                                                ->whereIn('role_id', @$user_role)
                                                ->where('menu_from', 'menu')
                                                ->first()
                                        ) {
                                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_name'] = $parent4->name;
                                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_url_path'] = $parent4->url_path;
                                            $nav_menus[$module->id]['menus'][$parent1->id]['child'][$parent2->id]['child'][$parent3->id]['child'][$parent4->id]['menu_icon'] = $parent4->icon;
                                            $parents5 = App\Models\Menu::where('parent', $parent4->id)
                                                ->where('status', 1)
                                                ->orderBy('sort', 'asc')
                                                ->get();
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    @endphp
@endif


<aside class="main-sidebar sidebar-dark-primary elevation-1">
    <a href="{{url('/')}}" class="brand-link" style="transition: inherit;">
        <img src="{{fileExist(['url'=>@$site_setting->logo,'type'=>'logo'])}}" alt="Brand Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text">{{(@$site_setting->name)?(@$site_setting->name):'Project Name'}}</span>
    </a>
    <div class="sidebar">
        {{-- <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> --}}
        <nav class="mt-3">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                @foreach ($nav_menus as $nav_menu)
                    @if (@$nav_menu['menus'])
                        @if (@$nav_menu['name'])
                            <li class="nav-header">{{ $nav_menu['name'] }}</li>
                        @endif
                        @foreach ($nav_menu['menus'] as $nav_menu1)
                            @if (@$nav_menu1['child'] != null)
                                <li class="nav-item has-treeview">
                                    <a href="#" class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                        <i
                                            class="nav-icon far {{ $nav_menu1['menu_icon'] ? $nav_menu1['menu_icon'] : 'fa-circle' }}"></i>
                                        <p>
                                            {{ $nav_menu1['menu_name'] }}
                                            <i class="fas fa-angle-left right"></i>
                                        </p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        @foreach ($nav_menu1['child'] as $nav_menu2)
                                            @if (@$nav_menu2['child'] != null)
                                                <li class="nav-item has-treeview">
                                                    <a href="#" class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                        <i
                                                            class="nav-icon far {{ $nav_menu2['menu_icon'] ? $nav_menu2['menu_icon'] : 'fa-circle' }}"></i>
                                                        <p>
                                                            {{ $nav_menu2['menu_name'] }}
                                                            <i class="fas fa-angle-left right"></i>
                                                        </p>
                                                    </a>
                                                    <ul class="nav nav-treeview">
                                                        @foreach ($nav_menu2['child'] as $nav_menu3)
                                                            @if (@$nav_menu3['child'] != null)
                                                                <li class="nav-item has-treeview">
                                                                    <a href="#" class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                        <i
                                                                            class="nav-icon far {{ $nav_menu3['menu_icon'] ? $nav_menu3['menu_icon'] : 'fa-circle' }}"></i>
                                                                        <p>
                                                                            {{ $nav_menu3['menu_name'] }}
                                                                            <i class="fas fa-angle-left right"></i>
                                                                        </p>
                                                                    </a>
                                                                    <ul class="nav nav-treeview">
                                                                        @foreach ($nav_menu3['child'] as $nav_menu4)
                                                                            @if (@$nav_menu4['child'] != null)
                                                                                <li class="nav-item has-treeview">
                                                                                    <a href="#" class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                                        <i
                                                                                            class="nav-icon far {{ $nav_menu4['menu_icon'] ? $nav_menu4['menu_icon'] : 'fa-circle' }}"></i>
                                                                                        <p>
                                                                                            {{ $nav_menu4['menu_name'] }}
                                                                                            <i
                                                                                                class="fas fa-angle-left right"></i>
                                                                                        </p>
                                                                                    </a>
                                                                                    <ul class="nav nav-treeview">
                                                                                        @foreach ($nav_menu4['child'] as $nav_menu5)
                                                                                            @if (@$nav_menu5['child'] != null)
                                                                                                <li
                                                                                                    class="nav-item has-treeview">
                                                                                                    <a href="#"
                                                                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                                                        <i
                                                                                                            class="nav-icon far {{ $nav_menu5['menu_icon'] ? $nav_menu5['menu_icon'] : 'fa-circle' }}"></i>
                                                                                                        <p>
                                                                                                            {{ $nav_menu5['menu_name'] }}
                                                                                                            <i
                                                                                                                class="fas fa-angle-left right"></i>
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            @else
                                                                                                <li class="nav-item">
                                                                                                    <a href="{{ $nav_menu5['menu_url_path'] == '#' ? '#' : url($nav_menu5['menu_url_path']) }}"
                                                                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                                                        <i
                                                                                                            class="nav-icon far {{ $nav_menu5['menu_icon'] ? $nav_menu5['menu_icon'] : 'fa-circle' }}"></i>
                                                                                                        <p>
                                                                                                            {{ $nav_menu5['menu_name'] }}
                                                                                                        </p>
                                                                                                    </a>
                                                                                                </li>
                                                                                            @endif
                                                                                        @endforeach
                                                                                    </ul>
                                                                                </li>
                                                                            @else
                                                                                <li class="nav-item">
                                                                                    <a href="{{ $nav_menu4['menu_url_path'] == '#' ? '#' : url($nav_menu4['menu_url_path']) }}"
                                                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                                        <i
                                                                                            class="nav-icon far {{ $nav_menu4['menu_icon'] ? $nav_menu4['menu_icon'] : 'fa-circle' }}"></i>
                                                                                        <p>
                                                                                            {{ $nav_menu4['menu_name'] }}
                                                                                        </p>
                                                                                    </a>
                                                                                </li>
                                                                            @endif
                                                                        @endforeach
                                                                    </ul>
                                                                </li>
                                                            @else
                                                                <li class="nav-item">
                                                                    <a href="{{ $nav_menu3['menu_url_path'] == '#' ? '#' : url($nav_menu3['menu_url_path']) }}"
                                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                                        <i
                                                                            class="nav-icon far {{ $nav_menu3['menu_icon'] ? $nav_menu3['menu_icon'] : 'fa-circle' }}"></i>
                                                                        <p>
                                                                            {{ $nav_menu3['menu_name'] }}
                                                                        </p>
                                                                    </a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>
                                            @else
                                                <li class="nav-item">
                                                    <a href="{{ $nav_menu2['menu_url_path'] == '#' ? '#' : url($nav_menu2['menu_url_path']) }}"
                                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                                        <i
                                                            class="nav-icon far {{ $nav_menu2['menu_icon'] ? $nav_menu2['menu_icon'] : 'fa-circle' }}"></i>
                                                        <p>
                                                            {{ $nav_menu2['menu_name'] }}
                                                        </p>
                                                    </a>
                                                </li>
                                            @endif
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a href="{{ $nav_menu1['menu_url_path'] == '#' ? '#' : url($nav_menu1['menu_url_path']) }}"
                                        class="nav-link" style="color:{{ @$nav_menu['color'] }}">
                                        <i
                                            class="nav-icon far {{ $nav_menu1['menu_icon'] ? $nav_menu1['menu_icon'] : 'fa-circle' }}"></i>
                                        <p>
                                            {{ $nav_menu1['menu_name'] }}
                                        </p>
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</aside>

<script type="text/javascript">
    $(document).ready(function() {
        var mylist = [];
        var list_counter = 1;
        $(".sidebar .nav-item a").each(function() {
            if ($(this).attr('href') != '#') {
                mylist.push({
                    id: list_counter++,
                    name: $(this).attr('href')
                });
            }
        });
        navigationMenu(mylist);

        function navigationMenu(menu_array = null) {
            var url;
            var url_path = window.location.pathname;
            if (menu_array == null) {
                url = window.location.href;
            } else {
                if (menu_array.some(item => item.name === url_path)) {
                    url = window.location.href;
                } else {
                    url = highlight_navigation(menu_array);
                }
            }
            $('.sidebar .nav-item a[href="' + url + '"]').addClass('active');
            $('.sidebar .nav-item a[href="' + url + '"]').parents('ul').css('display', 'block');
            $('.sidebar .nav-item a[href="' + url + '"]').parents('li').addClass('nav-item menu-open');
            $('.sidebar .nav-item a').filter(function() {
                return this.href == url;
            }).addClass('active');
        }

        function highlight_navigation(list_array) {
            var path = window.location.href;
            path = path.replace(/\/$/, "");
            path = decodeURIComponent(path);
            var max_value = [];
            for (var i = 0; i < list_array.length; i++) {
                var percent = similar(list_array[i].name, path);
                max_value.push({
                    'name': list_array[i].name,
                    'percent': percent
                });
            }
            var xValues = max_value.map(function(o) {
                return o.percent;
            });
            xValues = Array.from(max_value, o => o.percent);
            var xMax = Math.max.apply(null, xValues);
            xMax = Math.max(...xValues);
            var maxXObjects = max_value.filter(function(o) {
                return o.percent === xMax;
            });
            var the_arr = maxXObjects[0].name.split('/');
            return (the_arr.join('/'));
        }

        function similar(a, b) {
            var equivalency = 0;
            var minLength = (a.length > b.length) ? b.length : a.length;
            var maxLength = (a.length < b.length) ? b.length : a.length;
            for (var i = 0; i < minLength; i++) {
                if (a[i] == b[i]) {
                    equivalency++;
                }
            }
            var weight = equivalency / maxLength;
            return Math.round(weight * 100); // + "%";
        }
    });
</script>
