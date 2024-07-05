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
    $(document).on('input' ,'#total_lates,#total_early_outs' , function(e){
        e.preventDefault();
        calculateAbsents(parseInt($('#total_lates').val()) ,parseInt($('#total_early_outs').val()));
    })

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

    function calculateAbsents(totalLates, totalEarlyOuts) {
        let absentsInput = $('#total_absents');
        let currentAbsents = parseInt(absentsInput.val()) || 0;
        let lateAbsentsCount = Math.floor(totalLates / 2);
        let earlyAbsentsCount = Math.floor(totalEarlyOuts / 2);
        let maxAbsents = (lateAbsentsCount + earlyAbsentsCount);
        let totalAbsents = currentAbsents + maxAbsents;
        absentsInput.val(totalAbsents);
    }

});
