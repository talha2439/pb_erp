$(document).ready(function () {
    let shiftform   = $("#shiftform");
    let department  = $('select[name="department"]');
    let name        = $('input[name="name"]');
    let start_time  = $('input[name="start_time"]');
    let end_time    = $('input[name="end_time"]');
    let days        = $('.btn-check');
    $(department).select2();
    // Checkbox validation
    var checkDays = $('.btn-check:checked').not('[value="all"]').length;
    $(days).on('change', function(e){
        if($(this).prop('checked') == false && $(this).val() != "all"){
            checkDays -- ;
            return false ;
        }
        if($(this).val() == "all"){
            $(days).not('[value="all"]').prop('checked', false);
            checkDays = 1;
            return false ;
        }
        else{
            if (checkDays >= 7 && $(this).val() !== "all") {
            $('.btn-check[value="all"]').prop('checked', true); // Check "all" checkbox
            $('.btn-check').not('[value="all"]').prop('checked', false); // Uncheck other checkboxes
            checkDays = 0 ;
        } else {
            // If any other checkbox is checked will uncheck all other checkboxes
            if (checkDays > 0 && $(this).val() !== "all") {
                $('.btn-check[value="all"]').prop('checked', false);

            }
        }
        checkDays ++ ;

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
