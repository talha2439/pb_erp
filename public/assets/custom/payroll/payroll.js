$(document).ready(function(){
    $(document).on('change' , '#employee_id' , function(e){
        var currentDate = new Date();
        var currentMonth = currentDate.getMonth() + 1;
        var currentYear = currentDate.getFullYear();
        var totalDays = new Date(currentYear, currentMonth, 0).getDate();

        var selectedSalary = $(this).find(':selected').data('salary');
        var perHour  = (parseInt(selectedSalary) / totalDays ).toFixed(2);
        $("#grossSalary").val(selectedSalary);
        $("#absent_deduction").val(perHour);
    });

    $("#payrollForm").submit(function(e){
        isValid = true;
        validate("payrollForm" , e);
        if(isValid){
            toast['success']("Payroll has been saved...!");
        }

    });

});
