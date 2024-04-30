$(document).ready(function () {
    let image = $("input[name=image]");
    let mediaType = $("select[name=media_type]");
    let sliderForm = $("#sliderForm");

    // Form Validations
    $(sliderForm).submit(function (e) {

        if (action == "create") {
            if (image.val() == "") {
                e.preventDefault();
                toastr['error']("Media Image is required");
                return false;
            }
            var allowedType = ['image/png', 'image/jpeg', 'image/jpg', 'image/avif'];
            var fileType = image[0].files[0].type;
            if (!allowedType.includes(fileType)) {
                e.preventDefault();
                toastr['error']("Invalid Media File Type , Supported Types: " + allowedType);
                return false;
            }
            // File size validation
            var maxFileSize = 10;
            var fileSize = image[0].files[0].size / (1024 * 1024);
            console.log(fileSize)
            if (fileSize > maxFileSize) {
                e.preventDefault();
                toastr['error']("Invalid Media File Size , Max File Size: " + maxFileSize + "MB");
                return false;
            }
        }
        if (mediaType.val() == "") {
            e.preventDefault();
            toastr['error']("Media Type is required");
            return false;
        }

    })
    if (action == "edit") {
        $(mediaType).val(mediadata.media_type);

    }
})
