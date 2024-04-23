$(document).ready(function() {
    $('.select2').select2({});
    $('input[name="martial_status"]').on('change' , function(e){

        e.preventDefault();

        if($(this).prop('checked') == true){
            $('.no_of_child').fadeIn();
        }
        else{
            $('.no_of_child').fadeOut();
        }
    });


    // Step 1
    let step1form = $("#step1");
    $(step1form).submit(function(e){
        
    })
    // End of Step 1
})
