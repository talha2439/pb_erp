<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="{{ config('setting.meta_description') }}">
    <meta name="keywords"
        content="{{ config('setting.meta_keywords') }}">
    <meta name="title" content="{{ config('setting.meta_title') }}">

    <title>{{ config('setting.site_name') }} - Login</title>

    <link rel="shortcut icon" href="{{ config('setting.favicon') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toatr.css') }}">
    <script src="{{ asset('assets/js/layout.js') }}" type="text/javascript"></script>

</head>

<body>

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container">
                <img class="img-fluid logo-dark mb-2 logo-color" src="{{ config('setting.logo')}}" alt="Logo">
                <img class="img-fluid logo-light mb-2" src="{{ config('setting.favicon') }}" alt="Logo">
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Login</h1>
                            <p class="account-subtitle">Access to our dashboard</p>
                            <form id="login" action="{{ route('auth.authenticate') }}" method="POST">
                                @csrf
                                <div class="input-block mb-3">
                                    <label class="form-control-label">Email Address</label>
                                    <input type="text" name="email" placeholder="example@gmail.com" class="form-control">
                                </div>
                                <div class="input-block mb-3">
                                    <label class="form-control-label">Password</label>
                                    <div class="pass-group">
                                        <input type="password" name="password" placeholder="***********" class="form-control pass-input">
                                        <span class="fas fa-eye toggle-password"></span>
                                    </div>
                                </div>
                                <div class="input-block mb-3">
                                    <div class="row">
                                       <div class="col-6"></div>
                                        <div class="col-6 text-end">
                                            <a class="forgot-link" href="{{ route('auth.forget.password') }}">Forgot Password ?</a>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-lg  btn-primary w-100" type="submit">Login</button>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/js/theme-settings.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/greedynav.js') }}" type="text/javascript"></script>

    <script src="{{ asset('assets/js/script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js') }}"
       ></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js') }}"></script>
    @if (Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success') }}');
    </script>
    @endif
    @if (Session::has('error'))
    <script>
        toastr.error('{{ Session::get('error') }}');
    </script>
    @endif
    <script >
        $(document).ready(function(){
          $('#login').submit(function(e){
                if($('input[name="email"]').val() ==""){
                    e.preventDefault();
                    toastr['error']("Email is required!");
                    return false;
                }
                else if($('input[name="email"]').val() != "" && !$('input[name="email"]').val().match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)){
                    e.preventDefault();
                    toastr['error']("Please enter a valid email!");
                    return false;
                }
                else if($('input[name="password"]').val() == ""){
                    e.preventDefault();
                    toastr['error']("Password is required!");
                    return false;
                }

          });
        });
    </script>
</body>

</html>

