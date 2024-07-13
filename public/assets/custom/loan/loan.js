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
            $('#date_of_payment').attr('data-type','required');
            $('#partial_amount').attr('data-type','required');
            $('#total_month').attr('data-type','required');
            $('.partial_container').removeClass('col-md-12');
            $('.duration_date').hide();
            $('.due_date_container').fadeIn();
            $('.no_months').removeClass('col-md-6');
            $('.partial_container').removeClass('col-md-6');

        }
        else if ($(this).val() == 'salary'){
            $('.no_months').fadeIn();
            $('.partial_container').fadeIn();
            $('#partial_amount').attr('data-type','required');
            $('#total_month').attr('data-type','required');
            $('#request_date').attr('data-type','');
            $('.duration_date').hide();
            $('.due_date_container').hide();
            $('#date_of_payment').attr('data-type','');
            $('#due_date').attr('data-type','');
            $('.due_date_container').attr('data-type','');
            $('.no_months').addClass('col-md-6');
            $('.partial_container').addClass('col-md-6');
        }
        else if($(this).val() == 'duration'){
            $("#total_month").val(0)
            $("#requested_amount").val(0)
            $('.partial_container').hide();
            $('.duration_date').fadeIn();
            $('#date_of_payment').attr('data-type','');
            $('.no_months').hide();
            $('#partial_amount').attr('data-type','');
            $('#total_month').attr('data-type','');
            $('#request_date').attr('data-type','required');
            $('#due_date').attr('data-type','required');
            $('.no_months').removeClass('col-md-6');
            $('.partial_container').removeClass('col-md-6');
            $('.due_date_container').hide();

        }

    });
    // Calculate Partial
    $("#total_month , #requested_amount").on('input', function(e){
        let totalMonth = parseInt($("#total_month").val());
        // if(totalMonth > 12){
        //     $("#total_month").val(12);
        // }
        let requested_amount = parseInt($("#requested_amount").val());
        let partialAmount = parseFloat((requested_amount / totalMonth) || requested_amount ).toFixed(0);
        $("#partial_amount").val(partialAmount);
    });
    $("#date_of_payment").on('input', function(e){
      if(parseInt($(this).val()) > 9){
             $(this).val(9);
       }
    });


})
