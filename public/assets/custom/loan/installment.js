$(document).ready(function(){
    var isValid = true;
    $("input[name='attachment']").on('change' , function(e){
        let allowed = ['pdf', 'png', 'jpeg' ,'jpg'];
        let file = $(this)[0].files[0];
        let fileName = file.name;
        let fileParts = fileName.split('.');
        let extension = fileParts[fileParts.length - 1]; // Get the last part after splitting by '.'
        if(!allowed.includes(extension)){
            toastr['error']("Invalid attachment file ! allowed are '" + allowed);
            $("#submitBtn").prop('disabled', true);
        }
        else{

            $("#submitBtn").prop('disabled', false);
        }
    })
    $("#loanInstallmentForm").submit(function(e){
        isValid = true;
        validate('loanInstallmentForm' ,e)
        if(isValid){
            $("#submitBtn").text('submitting...');
            $("#submitBtn").prop('disabled', true);
        }
    })



});
