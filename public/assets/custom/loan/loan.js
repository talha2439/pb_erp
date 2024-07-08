$(document).ready(function(){
    let employee         = $('select[name="employee_id"]');
    let loan_type_id     = $('select[name="loan_type_id"]');
    let requested_amount = $('input[name="requested_amount"]');
    let requested_date   = $('input[name="requested_date"]');
    let due_date         = $('input[name="due_date"]');
    let reason           = $('textarea[name="reason"]');
    var isValid          = true;

    $("#loanForm").submit(function(e){
        isValid = true;
        
        validate("loanForm",  e);
        if(isValid){
            $("#submitBtn").prop('disabled',true);
            $("#submitBtn").text("Please wait...");

        }
    });
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
