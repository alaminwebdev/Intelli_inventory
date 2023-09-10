<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
    </ul>
    <ul class="navbar-nav ml-auto">
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" data-toggle="tooltip" title="full screen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <img src="{{ asset('common/images/default_profile.png')}}" class="img-circle" alt="Profile Image" style="width: 20px;">                
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card-body box-profile">
                            <div class="text-center">
                                <img class="profile-user-img img-fluid img-circle" src="{{fileExist(['url'=>auth()->user()->image,'type'=>'profile'])}}" alt="{{auth()->user()->name}}">
                            </div>
                            <h3 class="profile-username text-center">{{auth()->user()->name}}</h3>
                        </div>
                    </div>
                </div>
                <div class="dropdown-divider"></div>
                <a href="{{ route('member.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="dropdown-item">
                    <form id="logout-form" action="{{ route('member.logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                    <i class="fa fa-power-off mr-2"></i> Logout
                </a>
                <a href="{{ route('member.change-password') }}" class="dropdown-item">
                    <i class="fa fa-lock mr-2"></i> Change Password
                </a>
                <div class="dropdown-divider"></div>
            </div>
        </li>
    </ul>
</nav>