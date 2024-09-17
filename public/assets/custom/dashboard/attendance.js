

let startTime;
var counterTimer ;
var timeInput     =  $(".time_input");
var checkoutInput = $('.checkOutInput');
var csrf_token    = $('.csrf_token');
var checkInput    = $('.checkInInput');
$(".checkInBtn").on('click', function (e) {
    startTime = new Date();
    checkIn('checkin');
    $.ajax({
        url: attendanceCheckin,
        type:"POST",
        data:{
            check_in:checkInput.val()
        },
        headers:{
            "X-CSRF-Token": csrf_token.val()
        },
        success:function(res){
            if(res.marked){
                toastr['warning']("Attendance Already Marked!");
                $('.checkInBtn').hide();
                $('.checkoutBtn').show();
            }
            else if(res.success){
                 startCounter();
                 toastr['success']("Attendance Marked successfully");
                 $('.checkInBtn').hide();
                 $('.checkoutBtn').show();
            }
            else if(res.empty){
                e.preventDefault();
                toastr['error']("Failed to mark check in as you are not a valid staff member");
            }
            else{
                e.preventDefault();
                toastr['error'](res.error);
            }
        }
    })
});

$(".checkoutBtn").on('click', function () {
    checkBTn = $(this);
    Swal.fire({
        title:"Are you sure?",
        text: "You sure you want to check out ? ",
        icon:'warning',
        showCancelButton: true,
        confirmButtonColor: '#6C05A8',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes checkout',
        cancelButtonText: 'No'
    }).then((res) => {
        if(res.isConfirmed){
            checkIn('checkout');
            $.ajax({
                url : attendanceCheckout ,
                type:'POST',
                data:{
                check_out : checkoutInput.val(),
                timeElapsed : timeInput.val()
                },
                headers:{
                    "X-CSRF-Token": csrf_token.val()
                },
                success:function(response){

                 if(response.success){
                    $(checkBTn).hide();
                    $('.checkInBtn').show();
                    $('.checkInBtn').prop('disabled', true);
                    stopCounter();
                    Swal.fire({
                            title:"Checkout Marked",
                            text:'Your checkout was marked',
                            icon:'success'
                    });
                    $('.timer-container').html(`<p class="text-muted mb-0"><span class="text-danger me-1"><i
                    class="fa-regular fa-calendar-check"></i> Checked Out</span>&nbsp;</p>`);
                 }
                }
            })

        }
    })

});

function startCounter(type) {
    counterTimer =  type = "checkedin" ?  setInterval(updateTimer, 1000) :  setInterval(updateCounter, 1000);
}

function stopCounter() {
    clearInterval(counterTimer);
}

// Function to update the counter display
function updateCounter(hours, minutes, seconds) {
    $('.time-calulation').text(hours + " hr " + minutes + " min " + seconds + " secs");
}

// Function to update the timer based on the check-in time
function updateTimer() {
    let checkInTimer = checkInput.val();

    // Check if input is not empty
    if (checkInTimer != "") {
        let parts = checkInTimer.split(":");
        let checkInHours = parseInt(parts[0], 10);
        let checkInMinutes = parseInt(parts[1].split(" ")[0], 10);
        let currentTime = new Date();
        let period = parts[1].split(" ")[1];

        if (period === "PM" && checkInHours !== 12) {
            checkInHours += 12;
        }

        let currentCheckin = new Date();
        currentCheckin.setHours(checkInHours, checkInMinutes, 0, 0);

        let difference = currentTime - currentCheckin;
        let hoursElapsed = Math.floor(difference / (1000 * 60 * 60));
        let minutesElapsed = Math.floor((difference % (1000 * 60 * 60)) / (1000 * 60));
        let secondsElapsed = Math.floor((difference % (1000 * 60)) / 1000);

        // Update the counter display
        updateCounter(hoursElapsed, minutesElapsed, secondsElapsed);
    }
}

// Start the counter if input is not empty
if (checkInput.val() != "" && checkoutInput.val() == "" ) {
    startCounter('checkedin');
}

function checkIn(type) {
    var currentTime = new Date();
    var hours = currentTime.getHours();
    var minutes = currentTime.getMinutes();
    minutes = (minutes < 10 ? "0" : "") + minutes;
    var meridiem = (hours < 12) ? "AM" : "PM";
    hours = (hours > 12) ? hours - 12 : hours;
    hours = (hours == 0) ? 12 : hours;
    var currentTimeString = hours + ":" + minutes;

    if(type =='checkin'){
        $(".checkin-time").text(currentTimeString);
        $('.checkin-meridiem').text(meridiem);
        $('.checkInInput').val(currentTimeString+" "+meridiem);
    }
    if(type == 'checkout'){
        $('.checkOutInput').val(currentTimeString+" " + meridiem );
        $(".checkout-time").text(currentTimeString);
        $('.checkout-meridiem').text(meridiem);
    }
}

