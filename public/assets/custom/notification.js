$(document).ready(function() {
    // checkNotifications();
    pushNotification();
    function checkNotifications(){
        $.ajax({
            type: 'GET',
            url: notificationURL,
            success: function(response){
                var leaveData = ""
                if(response.leave){
                    // Notification For Leaves
                    $(response.leave).each(function(index , value){
                       let image = "../../images/UsersImages/"+value.leave_application.employees.users.image;
                       leaveData +=  `<li class="notification-message">
                        <a href="profile.html">
                        <div class="d-flex">
                        <span class="avatar avatar-md active">
                        <img class="avatar-img rounded-circle" alt="avatar-img"
                        src="${image}">
                        </span>
                        <div class="media-body">
                        <p class="noti-details"><span class="noti-title">${value.leave_application.employees.first_name} ${value.leave_application.employees.last_name} </span>
                        <span class="noti-title">${value.subject}</span></p>
                        <div class="notification-btn">
                        <span class="btn btn-primary">Accept</span>
                        <span class="btn btn-outline-primary">Reject</span>
                        </div>
                        <p class="noti-time"><span class="notification-time">${value.created_at_formatted}</span></p>
                        </div>
                        </div>
                        </a>
                     </li>`;
                    })
                $(document).find('.notification-list').html(leaveData);
                    }
                else if(response.available == false){
                $(document).find('.notification-list').html('<span class="text-danger text-center">No  Notifications Available</span>');
                }
            }
        })
    }
    $(document).on('click', '.readed' , function(e) {

        e.preventDefault();
        let id  = $(this).attr('data-id');
        let row = $(this);
        $.ajax({
            url: markedURL + '/' + id,
            type: 'GET',
            success: function(response){
                if(response.success){
                    toastr['success']("Notification Marked..!");
                    $(row).closest('.main-div').remove();
                    return false;
                }
                else if(response.error){
                    toastr['error'](response.error);

                    return false;
                }
                else{
                    toastr['error']("An error occurred..! ");
                    return false;
                }
            }
        })
    })
    $(document).on('click', '.markall' , function(e) {

        e.preventDefault();

        $.ajax({
            url: markedallURL,
            type: 'GET',
            success: function(response){
                if(response.success){
                    toastr['success']("Notification Marked..!");
                    $(document).find('#notificationModal').modal('hide');
                    return false;
                }
                else if(response.error){
                    toastr['error'](response.error);

                    return false;
                }
                else{
                    toastr['error']("An error occurred..! ");
                    return false;
                }
            }
        })
    })
})


function pushNotification(){
    var pusher = new Pusher('0676cddee652caa7a948', {
        cluster: 'ap2'
      });

      var channel = pusher.subscribe('my-channel');
      channel.bind('notification', function(response) {
        console.log(response.post.data);
         let responseData = JSON.parse(response.post.data);
        let notificationData = "" ;
        if(response.post.type == "leaveApplication"){
            notificationData  +=` <li class="notification-message">
            <a href="profile.html">
                <div class="d-flex">
                    <span class="avatar avatar-md active">
                        <img class="avatar-img rounded-circle" alt="avatar-img"
                            src="../../assets/img/profiles/avatar-02.jpg">
                    </span>
                    <div class="media-body">
                        <p class="noti-details"><span class="noti-title">${responseData.employees.first_name} ${responseData.employees.last_name} </span><br>
                        <span class="noti-title">${response.post.subject}</span></p>
                        <div class="notification-btn">
                            <span class="btn btn-primary">Accept</span>
                            <span class="btn btn-outline-primary">Reject</span>
                        </div>
                        <p class="noti-time"><span class="notification-time">${response.post.created_at}</span></p>
                    </div>
                </div>
            </a>
        </li>`;
        }
         $(document).find('.notification-list').append(notificationData)
         toastMessage(response.post.subject , response.post.created_at);
      });
}
