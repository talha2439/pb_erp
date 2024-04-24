$(document).ready(function () {
    let shiftform   = $("#shiftform");
    let department  = $('select[name="department"]');
    let name        = $('input[name="name"]');
    let start_time  = $('input[name="start_time"]');
    let end_time    = $('input[name="end_time"]');
    let days        = $('.btn-check');
    $(department).select2();
    // Checkbox validation
    $(days).on('change', function(e){
        let checkDays = $('.btn-check:checked').length;
        if($(this).val() == "all"){
            $(days).not(this).prop('checked', false);
        }
        else{
            if (checkDays >= 7 && $(this).val() !== "all") {
            $('.btn-check[value="all"]').prop('checked', true); // Check "all" checkbox
            $('.btn-check').not('[value="all"]').prop('checked', false); // Uncheck other checkboxes
        } else {
            // If any other checkbox is checked, uncheck the "all" checkbox
            if (checkDays > 0 && $(this).val() !== "all") {
                $('.btn-check[value="all"]').prop('checked', false);
            }
        }
        }
    })


    // Validations
    $(shiftform).submit(function(e){

        if(department.val() == ""){
            e.preventDefault();
            toastr['error']("Department is required");
            return false;
        }
        else if(name.val() == ""){
            e.preventDefault();
            toastr['error']("Shift name is required");
            return false;
        }
        else if (start_time.val() == ""){
            e.preventDefault();
            toastr['error']("Start time is required");
            return false;
        }
        else if (end_time.val() == ""){
            e.preventDefault();
            toastr['error']("End time is required");
            return false;
        }
        else if( start_time.val() == end_time.val() ){
            e.preventDefault();
            toastr['error']("End time cannot be equal to start time");
            return false;
        }
        let selectedDays = days.filter(':checked').length;

        if (selectedDays === 0) {
            e.preventDefault();
            toastr['error']("At least one day for shift is required");
            return false;
        }
    });
    if(action == "edit"){
        $(department).val(shiftData.department);
        $(department).trigger("change");
        $(name).val(shiftData.name);
        $(start_time).val(shiftData.start_time);
        $(end_time).val(shiftData.end_time);
        $(days).each(function(){
            if(shiftData.days.includes($(this).val())){
                $(this).prop('checked', true);
            }
        })
    }
})
