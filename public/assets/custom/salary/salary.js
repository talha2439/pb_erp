$(document).ready(function(){
    // Calculating total Per hour amount
    $(document).on('change' , '#employee_id' , function(e){
        var selectedSalary = $(this).find(':selected').data('salary');
        var perHour  = (parseInt(selectedSalary) /( 9 * 30 )).toFixed(2);
        $("#grossSalary").val(selectedSalary);
        $("#perHour").val(perHour);
    });

    $('#salaryForm').submit(function(e){
        isValid = true;
        validate('salaryForm' ,e);
        if(isValid){
            // Your form submission code goes here...
            console.log('Form submitted successfully');
        }

    })
    function validate(formId  ,e){
        let inputs = $(document).find("#"+formId).find('.form-control[data-type="required"]');
        $(inputs).each(function(){
            if($(this).val() == "" || $(this).val() == null || $(this).val() == undefined ){
                e.preventDefault(); //
                toastr['error']($(this).attr('data-name')+"\n is required..!");
                isValid = false; //
                return false;
            }
        })
    }
});
