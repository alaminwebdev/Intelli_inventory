<ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
    </li>
    {{-- <li>
        <h5 style="color:#17a2b8;font-size:22px;font-weight:bold;margin-left:15px;margin-top:6px">Urban Water Supply Management System <span style="font-size:14px">Department of Public Health Engineering, Dhaka , Bangladesh</span></h5>
    </li> --}}
</ul>

{{-- <form class="form-inline ml-3">
    <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
            <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
            </button>
        </div>
    </div>
</form> --}}

<ul class="navbar-nav ml-auto">
    {{-- <li class="nav-item">
        @if(session()->get('language') =='bn')
            <a class="nav-link btn btn-sm"href="{{route('language','en')}}" style="background: white;color: #17a2b8;border: 2px solid #17a2b8;">English</a>
        @else
            <a class="nav-link btn btn-sm"href="{{route('language','bn')}}" style="background: white;color: #17a2b8;border: 2px solid #17a2b8;">বাংলা</a>
        @endif
    </li> --}}
    <li class="nav-item dropdown show">
        <a class="nav-link" data-toggle="dropdown" href="#" aria-expanded="true">
            <i class="fa fa-user"></i> {{auth()->user()->name}}
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <a href="{{route('profile-management.change.password')}}" class="dropdown-item" >
                <i class="fas fa-lock"></i> Change Password
            </a>
            <a href="#" class="dropdown-item" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fas fa-lock"></i> Logout
            </a>
            <form style="display: none;" method="post" id="logout-form" action="{{route('logout')}}">
                @csrf
            </form>
        </div>
    </li>
</ul>
