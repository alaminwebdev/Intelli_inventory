<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ fileExist(['url' => @$site_setting->favicon, 'type' => 'favicon']) }}" type="image/x-icon">
    <link rel="icon" href="{{ fileExist(['url' => @$site_setting->favicon, 'type' => 'favicon']) }}" type="image/x-icon">
    <title>{{ @$site_setting->title_suffix ? @$site_setting->title_suffix : 'Intelli Inventory' }} | {{ @$title ?? '' }} Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style type="text/css">
        body,
        html {
            font-family: "Roboto", sans-serif;
            background-color: #50d8d7;
            background-image: linear-gradient(316deg, #50d8d7 0%, #923993 74%);
            height: 100%;
        }

        .card-container.card {
            background: rgb(80 216 215 / 20%)
        }


        .card {
            word-wrap: break-word;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 15px;
            box-shadow: 0 0.125rem 20rem rgb(0 0 0 / 10%) !important;
        }

        .profile-img-card {
            width: 80px;
        }

        .profile-name-card {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0 0;
            min-height: 1em;
            color: #fff;
        }


        .form-signin .form-control:focus {
            border-color: rgb(104, 145, 162);
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
        }

    </style>
</head>

<body>
    <div class="container h-100 d-flex justify-content-center align-items-center p-5">
        <div class="card card-container p-3">
            <div class="card-body">
                <div class="text-center">
                    <img src="{{ fileExist(['url' => @$site_setting->logo, 'type' => 'logo']) }}" class="profile-img-card img-circle">
                </div>
                <p id="profile-name" class="profile-name-card">Intelli Inventory Management System</p>
                <br>
                <form class="form-signin" id="form-signin" action="{{ $url }}" method="post">
                    {{ csrf_field() }}
                    @if (session()->has('login_error'))
                        <div class="alert alert-danger">{{ session()->get('login_error') }}</div>
                    @endif
                    <div class="form-group mb-3 {{ $errors->has('user') ? 'has-error' : '' }}">
                        <input type="text" class="form-control" name="user" id="user" value="" placeholder="Enter Email / Mobile" required>
                        @if ($errors->has('user'))
                            <span class="help-block">
                                <strong>{{ $errors->first('user') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group mb-3 {{ $errors->has('password') ? 'has-error' : '' }}">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="d-grid gap-3">
                        <button class="btn btn-primary" type="submit">Sign In</button>
                        <a class="btn btn-success" style="cursor: pointer" href="{{ route('admin.login-as-viewer') }}">
                            Login as a Viewer
                        </a>
                    </div>
                </form>
                {{-- <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                        @if (Route::has(getGuard() . '.password.request'))
                            <a class="btn btn-link" href="{{ route(getGuard() . '.password.request') }}" style="cursor: pointer;">
                                Forget password
                            </a>
                        @endif
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#form-signin').validate({
                ignore: [],
                errorClass: 'text-danger',
                validClass: 'text-success',
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
                },
                rules: {
                    'user': {
                        required: true
                    },
                    'password': {
                        required: true
                    }
                },
                messages: {
                    'user': {
                        required: 'Enter Email / Mobile',
                    },
                    'password': {
                        required: 'Please Enter right password'
                    }
                }
            });
        });
    </script>
</body>

</html>
