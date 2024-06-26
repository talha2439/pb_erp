$(document).ready(function() {
    var isValid = true;
    $(document).on('change' ,"#favicon , #logo , #light_logo" , function(e){
        let allowed = ['jpg', 'png', 'jpeg'];
        let file = $(this)[0].files[0];
        let fileName = file.name;
        let fileParts = fileName.split('.');
        let extension = fileParts[fileParts.length - 1]; // Get the last part after splitting by '.'
        validateFile(extension ,  allowed);
    })
    $("#settingForm").submit(function(e){
        validate('settingForm' , e);
       
    })








     function validateFile(extension , allowedExtensions){

        if (allowedExtensions.indexOf(extension.toLowerCase()) === -1) {
            toastr.error("File extension not allowed! Supported Extensions: " + allowedExtensions.join(', '));
            isValid = false;
            $("#submitBtn").prop('disabled', true);
        } else {
            $("#submitBtn").prop('disabled', false);
        }
        }
    function validate(formId , e ){
        let inputs = $(document).find('#' + formId).find('.form-control[data-type="required"]');
        $(inputs).each(function(){
            if($(this).val() == "" || $(this).val() == undefined) {
                e.preventDefault(); //
                toastr['error']($(this).attr('data-name')+"\n is required..!");
                return false;
            }
        })
    }



});
