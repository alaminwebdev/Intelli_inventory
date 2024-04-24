<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ fileExist(['url' => @$site_setting->favicon, 'type' => 'favicon']) }}" type="image/x-icon">
    <link rel="icon" href="{{ fileExist(['url' => @$site_setting->favicon, 'type' => 'favicon']) }}" type="image/x-icon">
    <title>{{ @$site_setting->title_suffix ? @$site_setting->title_suffix : 'Project Name' }} | {{ @$title ?? '' }} Login</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
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
            width: 350px;
            padding: 40px 40px;
            background: rgb(80 216 215 / 20%)
        }

        .btn {
            font-weight: 700;
            height: 36px;
            -moz-user-select: none;
            -webkit-user-select: none;
            user-select: none;
            cursor: default;
        }

        .card {
            word-wrap: break-word;
            background-clip: border-box;
            border: 0 solid rgba(0, 0, 0, .125);
            border-radius: 15px;
            box-shadow: 0 0.125rem 20rem rgb(0 0 0 / 10%) !important ;
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

        .form-signin input {
            direction: ltr;
            height: 44px;
            font-size: 16px;
        }

        .form-signin input,
        .form-signin button {
            width: 100%;
            display: block;
            margin-bottom: 10px;
            z-index: 1;
            position: relative;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box;
        }

        .form-signin .form-control:focus {
            border-color: rgb(104, 145, 162);
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgb(104, 145, 162);
        }

        .btn.btn-signin {
            cursor: pointer;
            font-weight: 700;
            font-size: 14px;
            height: 36px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            border: none;
            -o-transition: all 0.218s;
            -moz-transition: all 0.218s;
            -webkit-transition: all 0.218s;
            transition: all 0.218s;
            background: #2a527b;
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="container" style="display: flex;justify-content: center; align-items: center; height: 100%; padding:30px;">
        <div class="card card-container">
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
                <div class="form-group {{ $errors->has('user') ? 'has-error' : '' }}">
                    <input type="text" class="form-control" name="user" id="user" value="" placeholder="Enter Email / Mobile" required>
                    @if ($errors->has('user'))
                        <span class="help-block">
                            <strong>{{ $errors->first('user') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row">
                    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                        <button class="btn btn-lg btn-block btn-signin" type="submit">Sign In</button>
                    </div>
                </div>
            </form>
            {{-- <div class="row">
                <div class="form-group text-center">
                    @if (Route::has(getGuard() . '.password.request'))
                        <a class="btn btn-link" href="{{ route(getGuard() . '.password.request') }}" style="cursor: pointer;">
                            Forget password
                        </a>
                    @endif
                </div>
            </div> --}}
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
