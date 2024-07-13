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
    // Repay Type
    let repayType = $(document).find('#repay_type');
    $(repayType).on('change', function(e){
        if($(this).val() == 'monthly'){
            $('.partial_container').fadeIn();
            $('.no_months').fadeIn();
            $('#request_date').attr('data-type','');
            $('#due_date').attr('data-type','');
            $('#partial_amount').attr('data-type','required');
            $('#total_month').attr('data-type','required');
            $('.partial_container').removeClass('col-md-12');
            $('.duration_date').hide();
        }
        else if ($(this).val() == 'salary'){
            $('.no_months').fadeIn();
            $('.partial_container').fadeIn();
            $('#partial_amount').attr('data-type','required');
            $('#total_month').attr('data-type','required');
            $('#request_date').attr('data-type','');
            $('.duration_date').hide();
            $('#due_date').attr('data-type','');
        }
        else if($(this).val() == 'duration'){
            $('.partial_container').hide();
            $('.duration_date').fadeIn();
            $('.no_months').hide();
            $('#partial_amount').attr('data-type','');
            $('#total_month').attr('data-type','');
            $('#request_date').attr('data-type','required');
            $('#due_date').attr('data-type','required');
        }
    });
    // Calculate Partial
    $("#total_month").on('input', function(e){
        let totalAmount = parseInt($(this).val());
        let requested_amount = parseInt($("#requested_amount").val());
        let partialAmount = parseFloat((requested_amount / totalAmount) || requested_amount ).toFixed(1);
        $("#partial_amount").val(partialAmount);
    });


})
