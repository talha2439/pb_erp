@extends('Admin.layout')
@section('title')
Employee's Leave Applications
@endsection
@section('content')

<div class="page-header">
    <div class="content-page-header">
        <h5>Employee's Leave Applications</h5>
    </div>
</div>
<div class="card p-3">
    <div class="card-header mb-2">
        <div class="row">
           <div class="col-md-12 d-flex justify-content-between">
            <h3>Employee's Leave Applications</h3>
            <button class=" btn btn-primary text-white" style="width: max-content" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="fe fe-filter"></i>
               </button>
           </div>

            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item border-0">
                      <h2 class="accordion-header" id="headingThree">
                      </h2>
                      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                         @include('Admin.attendance.leave_application.partial.filter')
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>

    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table table-bordered">
            <thead>
                <tr>

                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Leave Type</th>
                    <th>Leave Duration</th>
                    <th>Total Applied Days</th>
                    <th>Approved Days</th>
                    <th>Status</th>
                    <th>Applied By</th>
                    <th>Applied At</th>
                    <th>Approved By</th>
                    <th>Approved At</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>
@include('Admin.attendance.leave_application.partial.popup')
@push('js')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.js"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function() {

    let allReportsURL = "{{ route('leave.application.data') }}";
    let dataTable  = null ;

    getAllReports();
    // Filters
    let date       = $(document).find('#date');
    let leave_types       = $(document).find('#leave_types');
    let department = $(document).find('#department');
    let employee   = $(document).find('#employee');
    let month      = $(document).find('#month');
    let year       = $(document).find('#year');
    let status       = $(document).find('#status');
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
    })

    let deleteUrl = "{{ route('leave.application.delete') }}";
    let changeStatusURL = "{{ Route('leave.application.status') }}";
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
                        toastr['success']('Application Status Changed successfully..!')
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
    })
</script>
@endpush
@endsection
