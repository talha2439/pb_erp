$(document).ready(function(){
    let workingStatus = $('select[name="working_status"]');
    let checkIn  = $(document).find('input[name="check_in"]');
    let checkOut = $(document).find('input[name="check_out"]');
    if($("#attendance_status").val() == 'present'){
        checkIn.attr('data-type','required');
    }
    else{
        checkIn.attr('data-type','');
    }
    $('#attendance_status').on('input'  , function(){
        if($(this).val() == 'present'){
            checkIn.attr('data-type','required');
        }
        else{
            checkIn.attr('data-type','');
        }
        statusChange($(this));
    });
    $('select[name="working_status"]' ).on('input' , function(){
        workingStatusChange('#attendance_status' ,$(this));
        if($("#attendance_status").val() == 'present'){
            checkIn.attr('data-type','required');
        }
        else{
            checkIn.attr('data-type','');
        }
    });


    showextra();

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
        if($(this).val() == "" || $(this).val() == null  ){
            e.preventDefault(); //
            toastr['error']($(this).attr('data-name')+"\n is required..!");
            isValid = false; //
            return false;

        }
    });
    if(isValid){

    }
});


$(document).on('input','input[name="check_out"]',function(){
    showextra($(this).val());
})
if(action == 'edit'){
    $("select[name='employee_id']").val(attendance.users.employees.id);
    $("select[name='employee_id']").trigger("change");
    console.log(attendance.check_out);
    $('input[name="check_in"]').val(attendance.check_in == 'empty' ? '' :parseTimeHHmmToSFormat(attendance.check_in));
    $('input[name="check_out"]').val(attendance.check_out == 'empty' ? '' : parseTimeHHmmToSFormat(attendance.check_out));

    $('input[name="date"]').val(attendance.date);
    $("select[name='attendance_status']").val(attendance.attendance_status);
    $("select[name='attendance_status']").trigger("change");
    $("select[name='working_status']").val(attendance.working_status);
    $("select[name='working_status']").trigger("change");
    $('input[name="working_hours"]').val(0) ;
    if($(attendance.check_out != 'empty'&& attendance.check_in != 'empty')){
        if(attendance.working_hours.includes('hours')){
            $('input[name="working_hours"]').val((attendance.working_hours.split('hours')[0] || 0)) ;
            workingMins = attendance.working_hours.split('hours')[1].split('minutes')[0].split(' ')[1];
        }

        $('input[name="working_minutes"]').val(workingMins);
        if(attendance.extra_hours){
        $(document).find('input[name="extra_hours"]').val(attendance.extra_hours.split('hours')[0] || 0);
        $(document).find('input[name="extra_minutes"]').val(attendance.extra_hours.split('hours')[1].split('minutes')[0].split(' ')[1] || 0);
        }
    }
}

function CalculateTime(checkIn, checkOut) {

    if(checkIn && checkOut){
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
            $(document).find('input[name="working_hours"]').val(hours ?? 0);
            $(document).find('select[name="working_status"]').val('on-time').trigger('change');
            $(document).find('input[name="extra_hours"]').val(0);
            $(document).find('input[name="extra_minutes"]').val(0);
        }
    }
    }

}

function parseTime(timeStr) {
    let [time, period] = timeStr.split(' ');
    let [hours, minutes] = time.split(':').map(Number);
    return [hours, minutes, period];
}

// Date Validation
function showextra(value = null)
{
    if(value!=null && value != "" || action == 'edit'){
    $(document).find('input[name="date"]').attr('data-type','required');
    $(document).find('select[name="attendance_status"]').attr('data-type','required');
    $(document).find('input[name="working_hours"]').attr('data-type','required');
    $(document).find('select[name="working_status"]').attr('data-type','required');

        $(document).find('.extra-container').fadeIn();
    }
    else{
    $(document).find('input[name="date"]').attr('data-type','');
        $(document).find('select[name="attendance_status"]').attr('data-type','');
        $(document).find('input[name="working_hours"]').attr('data-type','');
        $(document).find('select[name="working_status"]').attr('data-type','');
        $(document).find('.extra-container').fadeOut();
    }
}
$(document).on('input','.attendance_date',function(e){
    e.preventDefault();
    let current_date = new Date();
    let selected_date = new Date($(this).val());
    if(current_date < selected_date){
        toastr['error']("Attendance date can't exceed current date");
        $('#submitBtn').prop('disabled',true);
    }else{
        $('#submitBtn').prop('disabled',false);
    }
})
function workingStatusChange(attendanceStatus , working_status){
    if($(working_status).val() == 'on-time' || $(working_status).val() == 'late' || $(working_status).val() == 'early-out' || $(working_status).val()=='late and early-out' ||
     $(workingStatus).val() == 'early-in and early-out' || $(working_status).val() == 'late-setting' ){
        $(attendanceStatus).val('present');

        if($(workingStatus).val() == 'late-setting'){
            CalculateTime(checkIn.val(),checkOut.val())
            $(workingStatus).val('late-setting');
            $(workingStatus).trigger('change');
        }
        else{
            $('input[name="extra_hours"]').val(0);
            $('input[name="extra_minutes"]').val(0);
        }

    }
    else if($(working_status).val() == 'absent'){
        $(document).find('input[name="working_hours"]').val('0');
        $(document).find('input[name="check_in"]').val('');
        $(document).find('input[name="check_out"]').val('');
        $(attendanceStatus).val('absent');
    }
    else if($(working_status).val() == 'leave'){
        $(document).find('input[name="working_hours"]').val('0');
        $(document).find('input[name="check_in"]').val('');
        $(document).find('input[name="check_out"]').val('');
        $(attendanceStatus).val('leave');
    }
    else if($(working_status).val() == 'off'){
        $(document).find('input[name="working_hours"]').val('0');
        $(document).find('input[name="check_in"]').val('');
        $(document).find('input[name="check_out"]').val('');
        $(attendanceStatus).val('off');
    }
    $(attendanceStatus).trigger('change');
}
function statusChange(attendance_status){
    if($(attendance_status).val() == 'present'){
        $(workingStatus).val('on-time');
        CalculateTime(checkIn.val(),checkOut.val())

         if(workingStatus == 'late-setting'){
            CalculateTime(checkIn.val(),checkOut.val())
            $(workingStatus).val('late-setting');
            $(workingStatus).trigger('change');
        }
    }
    else if($(attendance_status).val() == 'absent'){
        $(document).find('input[name="working_hours"]').val('0');
        $(document).find('input[name="check_in"]').val('');
        $(document).find('input[name="check_out"]').val('');
        $(workingStatus).val('absent');
    }
    else if($(attendance_status).val() == 'leave'){
        $(document).find('input[name="working_hours"]').val('0');
        $(document).find('input[name="check_in"]').val('');
        $(document).find('input[name="check_out"]').val('');
        $(workingStatus).val('leave');
    }
    else if($(attendance_status).val() == 'off'){
        $(document).find('input[name="working_hours"]').val('0');
        $(document).find('input[name="check_in"]').val('');
        $(document).find('input[name="check_out"]').val('');
        $(workingStatus).val('off');
    }
    $(workingStatus).trigger('change');

}
function parseTimeHHmmToSFormat(timeHHmm) {
    // Split the time string into hours and minutes
if(timeHHmm){

    var parts = timeHHmm.split(':');
    var hours = parseInt(parts[0], 10);
    var minutes = parseInt(parts[1], 10);

    // Check if the time is in PM and adjust hours accordingly
    if (timeHHmm.indexOf('PM') !== -1 && hours < 12) {
        hours += 12;
    }

    // Construct a date object with today's date and the adjusted time
    var today = new Date();
    today.setHours(hours);
    today.setMinutes(minutes);

    // Format the date object into "s" format
    var formattedTime = ('0' + today.getHours()).slice(-2) + ':' + ('0' + today.getMinutes()).slice(-2);

    return formattedTime;
}
}

})
