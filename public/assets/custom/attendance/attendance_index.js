$(document).ready(function() {
    let dataTable  = null ;

  $("#reportForm").submit(function(e){
    if($("#report_emp").val() == ""){
        e.preventDefault();
        toastr['error']("Please Select Employee!");
        return false;
    }
    if($("#report_month").val() == "" && $("#report_year").val() == "" ){
        e.preventDefault();
        toastr['error']("Please Select Month or Year!");
        return false;
    }
  })

getAllReports();
// Filters
let date       = $(document).find('.datepicker');
let department = $(document).find('#department');
let employee   = $(document).find('#employee');
let month      = $(document).find('#month');
let year       = $(document).find('#year');
let searchBtn  = $("#searchBtn")
$(searchBtn).on('click' , function(e) {
    e.preventDefault();
    if(dataTable !== null){
        dataTable.fnDestroy();
    }
    getAllReports($(department).val(), $(employee).val(), $(date).val(), $(month).val(), $(year).val());
})

$(".datepicker").daterangepicker({
        autoUpdateInput: true,
        label:"Please Select Date",
        locale: {
            cancelLabel: 'Clear'
        }

    });
function getAllReports(department=null, employee=null,daterange = null , month=null, year=null){
    dataTable = $('.datatables-basic').dataTable({
    serverSide : true,
    processing : true,
    ajax:{
        url: allReportsURL ,
        type:'Get',
        data:{department: department, employee: employee, daterange: daterange , month: month , year: year}
    }
    , "columns": [
            // Define your columns here
            { "data": "DT_RowIndex" },
            { "data": "employee_id" },
            { "data": "employee_name"},
            { "data": "department"},
            { "data": "date"},
            { "data": "attendance_status"},
            { "data": "checkin_checkout"},
            { "data":'working_hours'},
            { "data":'total_hours'},
            { "data":'extra_hours'},
            { "data":'working_status'},
            { "data": "action"},
            // Add more columns as needed
        ]
});
}

// Mark Holidays Code
$("#markHolidayForm").submit(function(e){
    isValid = true;
    validate('markHolidayForm' , e);
    if(isValid){
        e.preventDefault();
        // $("#submitBtnHoliday").prop('disabled',true);
        $("#submitBtnHoliday").text("Please wait...");
        $.ajax({
            url : holidaysURL ,
            type : 'POST',
            data:$("#markHolidayForm").serialize(),
            headers:{
                'X-CSRF-TOKEN': $("#csrf-token").val(),
            },
            success:function(res){
                if(res.unathorized){
                    toastr['error']('You are not authorized to mark Holidays..!');
                    $("#holidaysModal").modal('hide');
                    return false;
                }
                if(res.success){
                    toastr['success']("Holidays has been marked");
                     $("#submitBtnHoliday").prop('disabled',false);
                     $("#submitBtnHoliday").text("Mark Holidays");
                     $("#markHolidayForm")[0].reset();
                     setTimeout(()=>{
                        location.reload();
                     } , 1000)
                }
                else if(res.error == true){
                    toastr['error']("Failed to mark Holidays");
                    $("#submitBtnHoliday").prop('disabled',false);
                    $("#submitBtnHoliday").text("Mark Holidays");
                }
                else{
                    toastr['error'](res.error);
                    $("#submitBtnHoliday").prop('disabled',false);
                    $("#submitBtnHoliday").text("Mark Holidays");
                }
            }
        })
    }
})
function validate(formId , e){
    let inputs = $(document).find('#'+formId).find('.form-control[data-type="required"]');
    $(inputs).each(function(){
        if($(this).val() == ""){
            e.preventDefault(); //
            toastr['error']($(this).attr('data-name')+ " is required..!");
            isValid = false; //
            return false;
        }
    })
}
})
