$(document).ready(function(){
    var isValid = true;
    $("#bankDetailsForm").submit(function(e){
        isValid  = true;
        validate("bankDetailsForm" , e);
        if(isValid){
            e.preventDefault();
            $("#submitBtn").prop('disabled',true);
            $("#submitBtn").text("Please wait...");
            $.ajax({
                url :storeURL,
                type:'POST',
                data: $("#bankDetailsForm").serialize(),
                headers:{
                    'X-CSRF-TOKEN' : $(document).find("#csrf-token").val()
                },
                success:function(res){
                    if(res.success){
                        toastr['success']("Employee Bank Details Saved!");
                        $("#submitBtn").prop('disabled',false);
                        $("#submitBtn").text("Save");
                        return false;
                    }
                    else if(res.error == true){
                        toastr['error']("Failed to Save Bank Details");
                        $("#submitBtn").prop('disabled',false);
                        $("#submitBtn").text("Save");
                        return false;
                    }
                    else{
                        toastr['success'](res.error);
                        $("#submitBtn").prop('disabled',false);
                        $("#submitBtn").text("Save");
                        return false;
                    }
                }
            })
        }

    })
    $("#account_number").on('input' , function(){
        maxLength('account_number' , 18);
    })
    $("#iban_number").on('input' , function(){
        maxLength('iban_number' , 34);
    })
    $("#employee_id").on('change' , function(e){
        e.preventDefault();
        let id  = $(this).val();
        $.ajax({
            url :bankDetailURL + '/' + id,
            type:'GET',
            success:function(res){
                if(res.data){
                    $("#id").val(res.data.employee_id);

                    $("#name").val(res.data.name);
                    $("#account_number").val(res.data.account_number);
                    $("#account_holder_name").val(res.data.account_holder_name);
                    $("#branch_name").val(res.data.branch_name);
                    $("#iban_number").val(res.data.iban);
                }
                else{
                    $("#id").val("");

                    $("#name").val("");
                    $("#account_number").val("");
                    $("#account_holder_name").val("");
                    $("#branch_name").val("");
                    $("#iban_number").val("");
                }
            }
        })
    })
   
    function validate(formId , e){
        let inputs = $(document).find('#'+formId).find('.form-control[data-type="required"]');
        $(inputs).each(function(){
            if($(this).val() == ""){
                e.preventDefault(); //
                toastr['error']($(this).attr('data-name')+ " is required..!");
                isValid = false; //
                return false;
            }
        })
    }
})

