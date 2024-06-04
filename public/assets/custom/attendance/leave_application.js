$(document).ready(function() {
    $(".select2").select2({});
    var isValid =  true ;
    $("#leaveApplicationForm").submit(function(e){
        let formInputs = $(this).find('.form-control');
        formInputs.each(function(){
            let toDate = $(this).closest('.from_container').siblings('.to_date').find('.form-control[data-length="greater"]');
            if($(this).attr('data-type') == 'required' && $(this).val() == '') {
                e.preventDefault();
                toastr['error']($(this).attr('data-name')+' is Required..!');
                isValid = false;
                return false;
            }
            // Condition for date validiton
            else if($(this).attr('data-length') == 'required' && $(this).val() != '' &&  toDate.val() !="") {
                var from_date = new Date($(this).val());
                var to_date = new Date($(toDate).val());
                if(to_date <= from_date  ){
                    e.preventDefault();
                    toastr['error']($(this).attr('data-name')+' Must be less then  ' + toDate.attr('data-name'));
                    isValid = false;
                    return false;
                }
            }
        });
        if(isValid){

        }

    })
});
