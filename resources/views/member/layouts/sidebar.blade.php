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
</style>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{url('/')}}" class="brand-link">
        <img src="{{fileExist(['url'=>@$site_setting->logo,'type'=>'logo'])}}" alt="Brand Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">{{(@$site_setting->name)?(@$site_setting->name):'Project Name'}}</span>
    </a>
    <div class="sidebar">
        <div class="form-inline mt-2">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="true">
                <li class="nav-item">
                    <a href="{{ route('member.dashboard') }}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item has-treeview">
                    <a href="#" class="nav-link">
                        <i class="nav-icon far fa-circle"></i>
                        <p>
                            Profile Management
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('member/profile-management/profile-info/profile')}}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Profile Info
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('member/change-password')}}" class="nav-link">
                                <i class="nav-icon far fa-circle"></i>
                                <p>
                                    Change Password
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{url('member/all-courses/list')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>All Courses</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{url('member/my-courses/list')}}" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>My Courses</p>
                    </a>
                </li>
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
