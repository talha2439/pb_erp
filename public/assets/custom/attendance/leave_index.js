$(document).ready(function() {
getAllReports();
    // Filters
    let date         = $(document).find('#date');
    let leave_types  = $(document).find('#leave_types');
    let department   = $(document).find('#department');
    let employee     = $(document).find('#employee');
    let month        = $(document).find('#month');
    let year         = $(document).find('#year');
    let status       = $(document).find('select[name="status"]');
    let searchBtn  = $("#searchBtn")
    $(searchBtn).on('click' , function(e) {
        e.preventDefault();
        if(dataTable !== null){
            dataTable.fnDestroy();
        }
        getAllReports($(department).val(), $(employee).val(), $(date).val(), $(month).val(), $(year).val() , $(status).val() , $(leave_types).val());
    })

    function getAllReports(department=null, employee=null,date = null , month=null, year=null ,  status=null , leave_types = null){
        dataTable = $('.datatables-basic').dataTable({
        serverSide : true,
        processing : true,
        ajax:{
            url: allReportsURL ,
            type:'Get',
            data:{department: department, employee: employee, date: date , month: month , year: year, status:status  , leave_types : leave_types}
        }
        , "columns": [
                // Define your columns here
                { "data": "row_index" },
                { "data": "employee_id" },
                { "data": "employee_name"},
                { "data": "department"},
                { "data": "leave_type"},
                { "data": "duration"},
                { "data": "total_days"},
                { "data":'approved_days'},
                { "data":'status'},
                { "data":'applied_by'},
                { "data":'applied_at'},
                { "data":'approved_by'},
                { "data":'approved_at'},
                { "data": "action"},
                // Add more columns as needed
            ]
    });
    }


$(document).on('click', '.deleteDepart', function(e) {
    let id = $(this).data('id');
    let confirm = window.confirm('Are you sure you want to delete');
    if (confirm) {
        $.ajax({
            url: deleteUrl + "/" + id,
            type: 'Get',
            success: function(res) {
                if (res.unauthorized) {
                    toastr['error']('You are not authorized to delete department information..!');
                    return false;
                }
               else if (res.employee_exist) {
                    toastr['error']('Failed to delete department some employees are assigned with it delete them first..!');
                    return false;
                }
               else if (res.designation_exist) {
                    toastr['error']('Failed to delete department some designation are assigned with it delete them first !');
                    return false;
                }
              else  if (res.success) {
                    toastr['success']('Department Deleted successfully..!')
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    toastr['error']('Something went wrong..!');
                }
            }
        })
    }
});
$(document).ready(function(){
    $('.select2').select2({});

})
// Change Status
$(document).on('change' , "#status" , function(e){
    let status = $(this);
    if(status.val() == 'approved'){
        $(document).find('.date_range_container').show();
        $(document).find('.status_container').toggleClass('col-md-6 col-md-12');
        $(document).find('.remarks_container').hide();
        $(document).find("#date_range").attr('data-type' , 'required');
        $(document).find('#remarks').attr('data-type' , '');

        $(".datepicker").daterangepicker({
        opens: 'left',
        startDate:$(document).find("#from_date").val(),
        endDate:$(document).find("#to_date").val(),
         });
    }
    else if(status.val() == 'rejected'){
        $(document).find('.date_range_container').hide();
        $(document).find('.status_container').toggleClass('col-md-6 col-md-12');
        $(document).find('#remarks').attr('data-type' , 'required');
        $(document).find('#date_range').attr('data-type' , '');

        $(document).find('.remarks_container').show();
    }
    else{
        $(document).find('.remarks_container').hide();
        $(document).find('.date_range_container').hide();
        $(document).find('.status_container').removeClass('col-md-6');
        $(document).find('#remarks').attr('data-type' , '');
        $(document).find('#date_range').attr('data-type' , '');

    }
})
$(document).on('click', '.changeStatus' , function(e){
    e.preventDefault();
    let id = $(this).attr('data-id');
    $(document).find('input[name="id"]').val(id);
    $(document).find('#from_date').val($(this).attr('data-from'))
    $(document).find('#to_date').val($(this).attr('data-to'));

});
// Submitting Form

$("#changeStatus").submit(function(e){

    e.preventDefault();
    isValid = true;
    let inputs = $(document).find("#changeStatus").find('.form-control[data-type="required"]');

    $(inputs).each(function(){
        if($(this).val() == "" || $(this).val() == null ){
            e.preventDefault(); //
            toastr['error']($(this).attr('data-name')+"\n is required..!");
            isValid = false; //
            return false;

        }
    });
    if(isValid){
        let data = $(this).serialize();

        $.ajax({
            url: changeStatusURL,
            type: 'POST',
            data: $("#changeStatus").serialize(),
            success: function(res) {
                if (res.unauthorized) {
                    e.preventDefault();
                    $("#experienceModal").modal('hide');
                    toastr['error']('You are not authorized to change status..!');
                    return false;
                }
                else if (res.success) {
                    e.preventDefault();
                    $("#experienceModal").modal('hide');
                    toastr['success']('Application Status Changed successfully..!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    e.preventDefault();
                    $("#experienceModal").modal('hide');
                    toastr['error']('Something went wrong..!');
                }
            },
            error:function(res) {
                e.preventDefault();
                toastr['error'](res.error);
            }
        })
    }
});
    // View Details
    $(document).on('click' , '.viewDetails' , function(e){
        e.preventDefault();
        let id = $(this).attr('data-id');
        let modalBody  = $(document).find('#applicationModal').find('.modal-body');
        $.ajax({
            url :detailsURL + '/' + id,
            type:'GET',
            success:function(res){
                let applicationDetails = '';

                    var attachment = "";
                    if(res.data.application.attachment != "" || res.data.application.attachment != null){
                    attachment = `<div class="card-text col-md-4 col-12 col-sm-6 d-flex mt-2 mb-2 "><span >Attachment:</span> <div class="me-3" style="margin-left:10px">  <span class="blink blink-success"> <a class="text-white" target="_blank" href="${'../../images/leave_application/'+ res.data.application.attachment}">View</a>  <span> </div></span></div>`;
                }
                    var status = 'warning';
                    if(res.data.application.status == 'approved'){
                        status = 'success';
                    }
                    else if(res.data.application.status =='rejected'){
                        status = 'danger';
                    }
                    applicationDetails = `
                    <div class="card border rounded p-2 hv-50">
                                    <div class="card-header bg-dark text-white  mb-0 p-2 rounded-1 d-flex border-0">
                                        <div> <i class="fe fe-user fw-bold"></i> : <b> ${res.data.application.employees.first_name} ${res.data.application.employees.last_name}</b> </div>
                                        <div ><i class="fe fe-calendar underline "  style="margin-left:40px"></i> :  <b> ${res.data.application.from_date} - ${res.data.application.to_date}</b></div>
                                    </div><hr>
                                    <div class="card-body p-2">

                                        <div class="row mb-0 justify-content-between">
                                            <div class="card-text col-md-4 col-12  d-flex mb-2 mt-2"><div class="span" >Status: </div><div class="me-3" style="margin-left:10px">  <span class="blink blink-${status} "><b>${ res.data.application.status}</b> <span></div></span></div>
                                            ${attachment}
                                            <div class="card-text col-md-4 col-12  d-flex mt-2" style="white-space:nowrap"><span >Type:</span> <div class="me-3" style="margin-left:10px" >  <span class="blink blink-info "><b> ${res.data.application.leave_type} </b> <span></div></span></div>
                                            </div><br>
                                        <div class="card-text ml-2">
                                            <span> <b> <i class="fe fe-mail"></i> &nbsp;Application:</b></span><br>
                                        </div>
                                        <div class="card-text mb-2 p-2 border rounded-1" style="margin-top:10px ;min-height:300px; height:auto">
                                            <p>
                                               ${res.data.application.reason ?? ""}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                    `;
                   $(modalBody).html(applicationDetails);

            }
        })
    })

})
