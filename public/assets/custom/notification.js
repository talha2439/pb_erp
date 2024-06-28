$(document).ready(function() {
    // checkNotifications();
    pushNotification();


    $(document).on('click', '.markall' , function(e) {

        e.preventDefault();

        $.ajax({
            url: markedallURL,
            type: 'GET',
            success: function(response){
                if(response.success){
                    $(document).find('.notification-list').html("<li><center>No Notifications Available</center></li>");
                    let badge = ` <i class="fe fe-bell"></i>`;
                    $(document).find('.notificationbadge').html(badge);
                    return false;
                }
              
            }
        })
    })
    $(document).on('click', '.marknotification' , function(e) {

        e.preventDefault();
        let row = $(this).closest('li');
        let id  = $(this).attr('data-id');
        $.ajax({
            url: markedURL +'/'+id,
            type: 'GET',
            success: function(response){
                if(response.success){
                    $(row).remove();
                    getNotifcations()
                    return false;
                }

            }
        })
    })
    $(document).on('click', '.clearAll' , function(e) {

        e.preventDefault();

        $.ajax({
            url: removeAllNotifications,
            type: 'GET',
            success: function(response){
                if(response.success){
                    $(document).find('.notification-list').html("<li><center>No Notifications Available</center></li>");
                    let badge = ` <i class="fe fe-bell"></i>`;
                    $(document).find('.notificationbadge').html(badge);
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
        getNotifcations();
       let badge = ` <i class="fe fe-bell"></i>
            <span class="badge rounded-pill"></span>`

         $(document).find('.notificationbadge').html(badge)
         toastMessage(response.post.subject , response.post.created_at);
      });
}

function getNotifcations(){
    $.ajax({
        url : notificationURL ,
        type: 'GET',
        success: function(res){
            if(res.data.length > 0) {
                let notificationData = "" ;
                $(res.data).each(function(index, value){
                    notificationData  +=`
                    <li class="notification-message">
                                                <a class="marknotification" data-id="${value.id}" href="${value.route}">
                                                <div class="d-flex">
                                                <div class="media-body">
                                                <p class="noti-details "><span class="noti-title h6">${value.subject} </span><br>
                                                <p class="noti-time"><span class="notification-time">${value.created_at_formatted} </span></p>
                                                </div>
                                                </div>
                    </a>
                    </li>
                    `;
                })
            $(document).find('.notification-list').html(notificationData)
            }
            else{
            $(document).find('.notification-list').html("<li><center>No Notifications Available</center></li>");
            let badge = ` <i class="fe fe-bell"></i>`;
            $(document).find('.notificationbadge').html(badge)
            }

        }
    })
}

