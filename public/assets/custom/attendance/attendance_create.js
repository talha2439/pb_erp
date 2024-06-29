$(document).ready(function(){
    let checkIn  = $(document).find('input[name="check_in"]');
    let checkOut = $(document).find('input[name="check_out"]');
    CalculateTime(checkIn.val(),checkOut.val())
    $(document).on('input', 'input[name="check_out"] , input[name="check_in"] ', function(e) {
        CalculateTime(checkIn.val(), checkOut.val());
    });
$(document).on('change' , 'select[name="working_status"]',  function(e){
    if($(this).val() == 'late-setting'){
        $(document).find('.extra_container').fadeIn();
    }
    else{
        $(document).find('.extra_container').fadeOut();
    }
});
$(document).on('input' , 'input[name="extra_minutes"]',function(){
    if(parseInt($(this).val()) > 59){
            $(this).val(0);
            let extraHours = parseInt($('input[name="extra_hours"]').val());
            extraHours = parseInt(extraHours) + 1;
            $('input[name="extra_hours"]').val(extraHours)
    }
    if($(this).val() <= 0){
        $(this).val(0);
    }
});
$(document).on('input', 'input[name="working_hours"], input[name="working_minutes"]', function(e) {
    let workingHours = $('input[name="working_hours"]');
    let workingMinutes = $('input[name="working_minutes"]');

    if (parseInt(workingHours.val()) < 0) {
        workingHours.val(0);
    }

    if (parseInt(workingMinutes.val()) < 0) {
        workingMinutes.val(0);
    }

    let hours = parseInt(workingHours.val());
    let minutes = parseInt(workingMinutes.val());

    if (hours == 9 && minutes > 0) {
        $('select[name="working_status"]').val('late-setting');
        $('select[name="working_status"]').trigger('change');
        workingHours.val(9);
        let extraMinutes = minutes ;
        let extraMinutesTotal = parseInt($('input[name="extra_minutes"]').val(extraMinutes) || 0) || 0;
        if (extraMinutes > 59) {
            workingMinutes.val(0);
            $('input[name="extra_minutes"]').val(0)
            workingMinutes.prop('readonly', true);
            let extraHours = parseInt($('input[name="extra_hours"]').val());
            extraHours = parseInt(extraHours) + 1;
            $('input[name="extra_hours"]').val(extraHours)
        }

    }
    else if(workingMinutes.val() == 0 ){
        workingMinutes.prop('readonly', false);
        if(minutes >= 60){
            workingMinutes.val(0);
            let hoursNew = parseInt($(workingHours).val());
            hoursNew = parseInt(hoursNew) + 1;
            workingHours.val(hoursNew);

        }
        $('input[name="extra_hours"]').val(0);
        $('input[name="extra_minutes"]').val(0)
        $('select[name="working_status"]').val('on-time');
        $('select[name="working_status"]').trigger('change');
    }
    else if(hours < 9 ){
        workingMinutes.prop('readonly', false);
        if(minutes >= 60){
            workingMinutes.val(0);
            let hoursNew = parseInt($(workingHours).val());
            hoursNew = parseInt(hoursNew) + 1;
            workingHours.val(hoursNew);

        }
        $('input[name="extra_hours"]').val(0);
        $('input[name="extra_minutes"]').val(0)
        $('select[name="working_status"]').val('on-time');
        $('select[name="working_status"]').trigger('change');
    }

});

$("#attendanceForm").submit(function(e){
    isValid = true;
    let inputs = $(document).find("#attendanceForm").find('.form-control[data-type="required"]');

    $(inputs).each(function(){
        if($(this).val() == "" || $(this).val() == null ){
            e.preventDefault(); //
            toastr['error']($(this).attr('data-name')+"\n is required..!");
            isValid = false; //
            return false;

        }
    });
    if(isValid){

    }
});




if(action == 'edit'){
    $("select[name='employee_id']").val(attendance.users.employees.id);
    $("select[name='employee_id']").trigger("change");
    $('input[name="check_in"]').val(attendance.check_in);
    $('input[name="check_out"]').val(attendance.check_out);
    $('input[name="date"]').val(attendance.date);
    $("select[name='attendance_status']").val(attendance.attendance_status);
    $("select[name='attendance_status']").trigger("change");
    $("select[name='working_status']").val(attendance.working_status);
    $("select[name='working_status']").trigger("change");
    $('input[name="working_hours"]').val(attendance.working_hours.split('hours')[0] ?? 0);
    let workingMins = attendance.working_hours.split('hours')[1].split('minutes')[0].split(' ')[1];
    $('input[name="working_minutes"]').val(workingMins);
    $(document).find('input[name="extra_hours"]').val(attendance.extra_hours.split('hours')[0] ?? 0);
    $(document).find('input[name="extra_minutes"]').val(attendance.extra_hours.split('hours')[1].split('minutes')[0].split(' ')[1] ?? 0);
}

function CalculateTime(checkIn, checkOut) {
    let [checkInHour, checkInMinute, checkInPeriod] = parseTime(checkIn);
    let [checkOutHour, checkOutMinute, checkOutPeriod] = parseTime(checkOut);
    if (checkInPeriod === 'PM' && checkInHour !== 12) {
        checkInHour += 12;
    }
    if (checkOutPeriod === 'PM' && checkOutHour !== 12) {
        checkOutHour += 12;
    }
    if (checkOutPeriod === 'AM' && checkOutHour === 12) {
        checkOutHour = 0;
    }
    let checkInTotalMinutes = checkInHour * 60 + checkInMinute;
    let checkOutTotalMinutes = checkOutHour * 60 + checkOutMinute;
    let differenceMinutes = checkOutTotalMinutes - checkInTotalMinutes;
    if (differenceMinutes < 0) {
        differenceMinutes += 24 * 60;
    }
    if (differenceMinutes < 60) {
        $(document).find('input[name="working_minutes"]').val(differenceMinutes > 0 ? differenceMinutes : 0);
        $(document).find('input[name="working_hours"]').val(0);
    } else {
        let hours = Math.floor(differenceMinutes / 60);
        let minutes = differenceMinutes % 60;
        if (hours > 9) {
            let extrahours = hours - 9;
            $(document).find('select[name="working_status"]').val('late-setting').trigger('change');
            $(document).find('input[name="working_minutes"]').val(0);
            $(document).find('input[name="working_hours"]').val(9); // Set standard 9 hours
            $(document).find('input[name="extra_hours"]').val(extrahours);
            $(document).find('input[name="extra_minutes"]').val(minutes > 0 ? minutes : 0);
        } else {
            $(document).find('input[name="working_minutes"]').val(minutes > 0 ? minutes : 0);
            $(document).find('input[name="working_hours"]').val(hours);
            $(document).find('select[name="working_status"]').val('on-time').trigger('change');
            $(document).find('input[name="extra_hours"]').val(0);
            $(document).find('input[name="extra_minutes"]').val(0);
        }
    }
}

function parseTime(timeStr) {
    let [time, period] = timeStr.split(' ');
    let [hours, minutes] = time.split(':').map(Number);
    return [hours, minutes, period];
}



})
