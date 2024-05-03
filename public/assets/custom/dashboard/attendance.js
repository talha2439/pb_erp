

let startTime;
var csrf_token = $('.csrf_token');
$(".checkInBtn").on('click', function (e) {
    startTime = new Date();
    checkIn('checkin');
    let checkInput = $('.checkInInput');
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
            if(res.success || res.marked){
                 toastr['success']("Attendance Marked successfully");
                 startCounter();
                 checkIn();
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

            $(this).hide();
            $('.checkInBtn').show();
            stopCounter();
            Swal.fire({
                    title:"Checkout Marked",
                    text:'Your checkout was marked',
                    icon:'success'
            });
        }
    })

});


function startCounter() {
    counterTimer =  setInterval(updateCounter, 1000);
}

function stopCounter(){
    clearInterval(counterTimer);
}

function updateCounter() {
    let currentTime = new Date();
    let elapsedTime = currentTime.getTime() - startTime.getTime();
    let hours = Math.floor(elapsedTime / (1000 * 60 * 60));
    let minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);
    $('.time-calulation').text(hours + " " + 'hr' + " " + minutes + " " + 'min' + " " + seconds + " " + "secs");

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

    if(type=='checkin'){
        $(".time").text(currentTimeString);
        $('.meridiem').text(meridiem);
        $('.checkInInput').val(currentTimeString+" "+meridiem);
    }
    else if(type == 'checkout'){
        $('.checkOutInput').val(currentTimeString+" "+meridiem);
    }
}

