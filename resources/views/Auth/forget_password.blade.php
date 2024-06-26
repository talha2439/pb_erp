
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{ config('setting.site_name') }} - Forget Password</title>

    <link rel="shortcut icon" href="{{ config('setting.favicon')}}">

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
    <img class="img-fluid logo-dark mb-2" src="{{ config('setting.logo') }}" alt="Logo">
    <img class="img-fluid logo-light mb-2" src="{{ config('setting.favicon') }}" alt="Logo">
    <div class="loginbox">
    <div class="login-right">
    <div class="login-right-wrap">
    <h1>Forgot Password?</h1>
    <p class="account-subtitle class-reset">Enter your email to get a password reset link</p>
    <div class="mb-3 mt-4">
        <h5 class="text-center reset-message p-4" style="display: none">Your request for a password reset link has been sent to your email. Please check your inbox.</h5>
      </div>
    <form id="forgetform">
        @csrf
    <div class="input-block mb-3">
    <label class="form-control-label">Email Address</label>
    <input class="form-control" name="email" type="text">
    </div>
    <div class="input-block mb-0">
    <button class="btn btn-lg btn-primary w-100" type="submit" id="submitBtn">Send Verification</button>
    </div>
    </form>

    <div class="text-center dont-have">Remember your password? <a href="{{ route('auth.login') }}">Login</a></div>
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
    <script src="{{ asset('assets/custom/reset-password.js') }}"></script>
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

</body>
</html>
<script>
    let verifyRoute  = "{{ route('auth.verify.email'  , ['type'=>'forgetpassword']) }}";
</script>

