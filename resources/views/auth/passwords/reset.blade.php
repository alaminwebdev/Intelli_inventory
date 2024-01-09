<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{fileExist(['url'=>@$site_setting->favicon,'type'=>'favicon'])}}" type="image/x-icon">
    <link rel="icon" href="{{fileExist(['url'=>@$site_setting->favicon,'type'=>'favicon'])}}" type="image/x-icon">
    <title>{{(@$site_setting->title_suffix)?(@$site_setting->title_suffix):'Project Name'}} | Reset password</title>

    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <style type="text/css">
        body, html {
            font-family: "Roboto", sans-serif;
        }

        .card-container.card {
            max-width: 350px;
            padding: 40px 40px;
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
            background-color: #f7f7f7d4;
            padding: 20px 25px 30px;
            margin: 0 auto 25px;
            margin-top: 50px;
            -moz-border-radius: 2px;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            -moz-box-shadow: 15px 15px 27px rgb(0 0 0 / 50%);
            -webkit-box-shadow: 15px 15px 27px rgb(0 0 0 / 50%);
            box-shadow: 15px 15px 27px rgb(0 0 0 / 50%);
            -moz-box-shadow: 15px 15px 27px rgb(0 0 0 / 50%);
            -webkit-box-shadow: 15px 15px 27px rgb(0 0 0 / 50%);
            box-shadow: 15px 15px 27px rgb(0 0 0 / 50%);
        }

        .profile-img-card {
            width: 100px;
        }

        .profile-name-card {
            font-size: 16px;
            font-weight: bold;
            text-align: center;
            margin: 10px 0 0;
            min-height: 1em;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card card-container">
            <div class="text-center">
                <img src="{{fileExist(['url'=>@$site_setting->logo,'type'=>'logo'])}}" class="profile-img-card img-circle">
            </div>
            <p id="profile-name" class="profile-name-card">Reset Password</p>
            <br>
            @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
            @endif
            <form id="form-signin" method="POST" action="{{ route(getGuard().'.password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="row">
                    <div class="form-group col-sm-12">
                        <label class="control-label">Email Address</label>
                        <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" class="form-control form-control-sm email  @error('email') is-invalid @enderror" placeholder="Email Address" autocomplete="email">
                    
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="control-label">Password</label>
                        <input type="password" name="password" id="password" value="" class="form-control form-control-sm password  @error('password') is-invalid @enderror" placeholder="Password" autocomplete="new-password">
                    
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12">
                        <label class="control-label">Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" value="" class="form-control form-control-sm password_confirmation  @error('password_confirmation') is-invalid @enderror" placeholder="Confirmation Password" autocomplete="new-password">
                    
                        @error('password_confirmation')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="form-group col-sm-12">                        
                        <button type="submit" class="btn btn-primary btn-block">
                            {{ __('Send Password Reset Link') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/additional-methods.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function(){       
            $('#form-signin').validate({
                ignore:[],
                errorClass:'text-danger',
                validClass:'text-success',
                errorPlacement: function(error, element){
                    error.insertAfter(element);
                },

                rules : {
                    'email' : {
                        required : true,
                        email:true
                    },
                    'password' : {
                        required : true,
                        minlength : 8,
                    },
                    'password_confirmation' : {
                        minlength : 8,
                        equalTo : "#password"
                    }
                },
                messages : {
                    'email' : {
                        required : 'ইমেইল বা ফোন নাম্বার লিখুন',
                    }
                }
            });
        });
    </script>
</body>
</html>
