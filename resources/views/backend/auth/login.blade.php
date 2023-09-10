
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('public/backend/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/backend/plugins/toastr/toastr.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('public/backend/css/adminlte.css')}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('public/backend/css/login-page.css')}}">
    <script src="{{asset('public/backend/plugins/jquery/jquery.min.js')}}"></script>
  </head>

<style>
    .login-body {
        background-size: unset !important;
        background-repeat: repeat;
    }

    footer{
        color:#6a6363;
    }
</style>
<body class="login-page login-body">
<div class="login-box">
    <div class="row justify-content-center">
        <div class="login-logo">
            <a><b><img src="{{asset('public/images/logo/bup_logo.png')}}" height="150"> </a>
        </div>
        <div class="card card-box">
            {{-- <h4 style="/* width:100%; */color:#007fd0;font-size: 19px;font-weight:bold;margin-left: -7px;margin-top: -24px;/* margin:0px !important; *//* padding:0px !important; */">BUP</h4> --}}
            <div class="card-body login-card-body">
            {{-- @dd(Session::get('info')) --}}
            
            <h4 class="login-box-msg">Sign in to Admin Panel</h4>

            <form action="{{route('login')}}" method="post">
                @csrf
                <div class="form-group @error('email') has-error @enderror">
                    <div class="input-group mb-3">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" placeholder="Email" value="{{old('email')}}">
                    <div class="input-group-append input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="form-group @error('password') has-error @enderror">
                    <div class="input-group mb-3">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
                    <div class="input-group-append input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{$message}}</strong>
                        </span>
                    @enderror
                    </div>
                </div>
                <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember">
                        Remember Me
                    </label>
                    </div>
                </div>
                </div>
                <div class="row">
                <!-- /.col -->
                <div class="col-12">
                    <button type="submit" class="btn btn-info btn-block">Login</button>
                    {{-- @if($_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['SERVER_NAME'] == '103.204.209.67')
                    @else
                    <a href="https://n-doptor-accounts-stage.nothi.gov.bd/login?referer=aHR0cHM6Ly9wZ3UubmFub2l0LmJpei9sb2dpbg==" class="btn btn-success btn-block">Doptor</a>
                    @endif --}}
                </div>
                <!-- /.col -->
                </div>
            </form>
            <p class="mb-1">
                <a href="{{route('reset.password')}}"><i>Forgot Password</i></a>
            </p>
            </div>
        </div>
    </div>

    
</div>
{{-- <footer class="container">
    <div class="row">
        <div class="col-md-11 offset-md-1">
            <strong>@lang('Copyright') &copy; {{date('Y')}} <span style="color:#17a2b8">@lang('BUP')</span></strong>
            <strong style="margin-left:15%">Development Completion on <span style="color:#17a2b8">April 2022</span></strong>
            <strong style="margin-left:15%">
                @lang('Developed by:') <a target="_blank" href="http://www.nanoit.biz"> <span style="color:#17a2b8;font-weight:bold">@lang('Nanosoft')</span></a>
            </strong>
        </div>
    </div>
</footer> --}}
</body>
</html>


