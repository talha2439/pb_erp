function toastMessage(message , toastDate){
    
    $('.badge-toastr').fadeIn();
    $(document).find('.badge-toastr').find('.toastMessage').text(message);
    $(document).find('.badge-toastr').find('.toastDate').text(toastDate);
        setTimeout(() => {
        $('.badge-toastr').fadeOut();
    }  , 2300);
}
