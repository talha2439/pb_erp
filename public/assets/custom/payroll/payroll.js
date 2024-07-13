$(document).ready(function(){

    $(document).on('change' , '#employee_id' , function(e){
        var currentDate = new Date();
        var currentMonth = currentDate.getMonth() + 1;
        var currentYear = currentDate.getFullYear();
        var totalDays = new Date(currentYear, currentMonth, 0).getDate();

        var selectedSalary = $(this).find(':selected').data('salary');
        var selectedloanStatus = $(this).find(':selected').data('loan-status');
        var selectedpartailStatus = $(this).find(':selected').data('loan');
        if(selectedloanStatus == 'salary' || selectedloanStatus == 'monthly'){
             $("#loan_amount").val(selectedpartailStatus ?? 0);
        }
        else{
            $("#loan_amount").val(0);
        }
        var perHour  = (parseInt(selectedSalary) / totalDays ).toFixed(2);
        $("#grossSalary").val(selectedSalary);
        $("#absent_deduction").val(perHour);
    });

    $(document).on('input' ,'#total_absents,#total_leaves,#total_lates,#total_early_outs', function(e){
         validateDate(e);

    });

    $("#payrollForm").submit(function(e){
        isValid = true;
        validate("payrollForm" , e);
        if(isValid){
            toast['success']("Payroll has been saved...!");
        }

    });
    if(action  == 'edit'){
        $('#employee_id').val(payrollData.employee_id);
        $('#employee_id').trigger('change');
        $("#grossSalary").val(payrollData.gross_salary);
        $("#loan_amount").val(payrollData.loan_amount);
        $("#bonus_amount").val(payrollData.bonus_amount);
        $("#absent_deduction").val(payrollData.per_absents_deduction);
        $("#total_absents").val(payrollData.total_absents);
        $("#total_leaves").val(payrollData.total_leaves);
        $("#total_lates").val(payrollData.total_lates);
        $("#total_off").val(payrollData.total_off);
        $("#total_early_outs").val(payrollData.total_early_outs);
    }
    validateDate();
    function validateDate(e) {
        let date = new Date();
        let currentYear = date.getFullYear();
        let currentMonth = date.getMonth(); // Get current month (0-indexed)

        // Adjust to previous month
        if (currentMonth === 0) {
            currentMonth = 11; // December of previous year
            currentYear--;    // Adjust year accordingly
        } else {
            currentMonth--; // Previous month
        }

        let numDays = new Date(currentYear, currentMonth + 1, 0).getDate(); // Number of days in previous month
        let sundays = 0;

        for (let day = 1; day <= numDays; day++) {
            let previousMonthDate = new Date(currentYear, currentMonth, day);
            let dayOfWeek = previousMonthDate.getDay();

            if (dayOfWeek === 0) { // Sunday is 0, Saturday is 6
                sundays++;

            }
        }
        $("#total_off").val(sundays);
        // Removing
        numDays = (numDays  -  sundays);
        numDays = (numDays - (parseInt($('#total_leaves').val()) || 0)) ;
        numDays = (numDays - (parseInt($("#total_lates").val()) || 0));
        numDays = (numDays - (parseInt($("#total_early_outs").val()) || 0));
        numDays = ( numDays - (parseInt( $('#total_absents').val() || 0) ));
        if(numDays < 0){
            e.preventDefault();
            $('#total_lates').val(0)
            $('#total_early_outs').val(0)
            $('#total_leaves').val(0)
            $('#total_absents').val(0)
            toastr['error']("Total Absents , Leaves , Lates or early out should be equal or less then working days!");
            return false;
        }
        return true; // Return true if validation passes
    }





});
