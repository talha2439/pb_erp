
<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg"
    data-sidebar-image="none">


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title> {{ config('setting.site_name') }} - Forget Password</title>

    <link rel="shortcut icon" href="{{ config('setting.favicon') }}">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css">


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
    <img class="img-fluid logo-light mb-2" src="{{ asset('assets/img/logo2-white.png') }}" alt="Logo">
    <div class="loginbox">
    <div class="login-right">
    <div class="login-right-wrap">

    <h1 class="mb-2">Reset Password </h1>
    <p class="mb-4 text-center" >Enter Your New password for the mail : <br><span class="fw-bold">{{ $email }}</span></p>

    <form  id="resetPasswordForm">
        @csrf
    <input type="hidden" name="email" value="{{ $email }}">

    <div class="input-block mb-3">
    <label class="form-control-label">New Password</label>
    <input type="text" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
    <span class="fas fa-eye toggle-password"></span>

</div>
    <div class="input-block mb-3">
    <label class="form-control-label">Confirm Password</label>
    <input type="text" id="confirm-password" class="form-control" name="confirm-password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
    <span class="fas fa-eye toggle-password"></span>

</div>
    <div class="input-block mb-0">
    <button class="btn btn-lg btn-primary w-100" type="submit" id="submitBtn">Reset Password</button>
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
    $(document).ready(function(){
        let submitForm         = $("#resetPasswordForm");
        let password           = $("#password");
        let confirmPassword    = $("#confirm-password");
        let resetPassUrl       = "{{ route('password.reset') }}";
        let loginRoute         = "{{ route('auth.login') }}";
        $(submitForm).submit(function(e){
            let  isValid  = true;
            if($(password).val() == ""){
                e.preventDefault();
                isValid  = false;
                toastr['error']("Please provide a new password");
                return false;
            }
            if($(confirmPassword).val() == ""){
                e.preventDefault();
                isValid  = false;
                toastr['error']("Confirm Password is required");
                return false;
            }
            if($(password).val() != "" && $(confirmPassword).val() != "" && $(password).val() != $(confirmPassword).val())
            {
                e.preventDefault();
                isValid  = false;
                toastr['error']("Password and confirm password do not match");
                return false;
            }
            if(isValid){
                e.preventDefault();
                $.ajax({
                    url  : resetPassUrl,
                    type : "POST",
                    data : $(this).serialize(),
                    success : function(res){
                        if(res.success){
                            e.preventDefault();
                            toastr['success']("Password has been reset successfully");
                            setTimeout(() => {
                                window.location.href = loginRoute;
                            }, 1000);
                        }
                        else{
                            e.preventDefault();
                            toastr['error']("Something went wrong");
                            return false;
                        }
                    },
                    error:function(err){
                        e.preventDefault();
                        toastr['error']("Something went wrong");
                        return false;
                    }
                })
            }
        });


    });
</script>

