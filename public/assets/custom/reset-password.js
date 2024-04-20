$(document).ready(function(){
    let email       = $('input[name="email"]');
    let forgetForm  = $("#forgetform");
    let submitBtn    = $('#submitBtn');
    $(forgetForm).submit(function(e){
        isValid = true ;
        if($(email).val() == ""){
            e.preventDefault();
            isValid = false ;
            toastr['error']("Email field is required..!");
            return false;
        }
        if($(email).val() ==""){
            e.preventDefault();
            isValid = false ;
            toastr['error']("Email field is required..!");
            return false;
        }
        else if($(email).val() != "" && !$(email).val().match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)){
            e.preventDefault();
            isValid = false ;
            toastr['error']("Please enter a valid email!");
            return false;
        }
        if(isValid){
            e.preventDefault();
            $(submitBtn).text('Please wait...');
            $(submitBtn).prop('disabled', true);
            $.ajax({
                url : verifyRoute  ,
                type: "POST",
                data : forgetForm.serialize(),
                success:function(res){
                    if(res.invalid){
                        e.preventDefault();
                        toastr['error']("No records found for the associated email!");
                        $(submitBtn).text('Resend Email...');
                        $(submitBtn).prop('disabled', false);
                        return false;
                    }
                    else if(res.success){
                        e.preventDefault();
                        toastr['success']("A verification link has been sent to your email!");
                        $(submitBtn).text('Email Sent...');
                        $("#forgetform").hide();
                        $('.class-reset').hide();
                        $(".reset-message").fadeIn();
                        $(submitBtn).prop('disabled', true);
                    }
                    else{
                        e.preventDefault();
                        toastr['error']("Failed to send email something went wrong!");
                        $(submitBtn).text('Resend Email...');
                        $(submitBtn).prop('disabled', false);
                        return false;
                    }
                },
                error:function(err){
                    e.preventDefault();
                    $(submitBtn).text('Resend Email...');
                    $(submitBtn).prop('disabled', false);
                    toastr['error']("Something went wrong!");
                }
            });
        }



    });
});
