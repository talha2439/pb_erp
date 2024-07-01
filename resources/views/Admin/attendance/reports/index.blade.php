@extends('Admin.layout')
@section('title')
Employee's Attendance Report
@endsection
@php
$currentDate = \Carbon\Carbon::now();
$currentYear = $currentDate->year;
@endphp
@section('content')

<div class="page-header">
    <div class="content-page-header">
        <h5>Employee's Attendance Report</h5>
    </div>
</div>
<div class="card p-3">
    <div class="card-header mb-2">
        <div class="row">
           <div class="col-md-12 d-flex justify-content-between">
            <h3>Employee's Attendance Report</h3>
            <div>
                <a href="#" class="btn btn-info text-white" data-bs-toggle="collapse" data-bs-target="#collapseReport" aria-expanded="false" aria-controls="collapseReport">
                    <i class="fe fe-printer"></i>
                </a>
                <button class=" btn btn-primary text-white" style="width: max-content" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class="fe fe-filter"></i>
                   </button>
                   <a  class="btn btn-dark text-white" title="Mark Attendance" href="{{ route('attendance.create') }}">
                    <i class="fe fe-clipboard"></i>
                </a>
            </div>
           </div>

            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item border-0">
                      <h2 class="accordion-header" id="headingThree">
                      </h2>
                      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                         @include('Admin.attendance.reports.partial.filter')
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item border-0">
                      <h2 class="accordion-header" id="reportHeading">
                      </h2>
                      <div id="collapseReport" class="accordion-collapse collapse" aria-labelledby="reportHeading" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                         @include('Admin.attendance.reports.partial.report')
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
                    <th>Date</th>
                    <th>Attendance Status</th>
                    <th>Check in -  Checkout</th>
                    <th>Working hours</th>
                    <th>Total hours</th>
                    <th>Extra hours</th>
                    <th>Working Status</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

            </tbody>
        </table>
    </div>

</div>
@push('js')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script>
    $(document).ready(function() {

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
        $(".datepicker").daterangepicker({
            autoUpdateInput: false,
            label:"Please Select Date",
            locale: {
                cancelLabel: 'Clear'
            }

        });
    let allReportsURL = "{{ route('attendance.reports.data') }}";
    let dataTable  = null ;

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
    })

    


</script>

@endpush
@endsection
