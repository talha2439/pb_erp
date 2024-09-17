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
           <div class="col-md-12 d-flex flex-wrap justify-content-center justify-content-md-between">
            <h3 class="mt-2">Employee's Attendance Report</h3>
            <div class="d-flex justify-content-between mt-2" >
                <div class=" ms-2 me-2">
                    <a href="#" class="btn btn-warning text-white" title="Public Holidays Mark" data-bs-toggle="modal"
                data-bs-target="#holidaysModal">
                    <i class="fe fe-calendar"></i>
                </a>
                </div>
                <div class="me-2">
                    <a href="#" class="btn btn-info text-white" data-bs-toggle="collapse" data-bs-target="#collapseReport" aria-expanded="false" aria-controls="collapseReport">
                        <i class="fe fe-printer"></i>
                    </a>
                </div>
               <div class="me-2">
                <button class=" btn btn-primary text-white" style="width: max-content" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    <i class="fe fe-filter"></i>
                   </button>
               </div>
                 <div class="me-2">
                    <a  class="btn btn-dark text-white" title="Mark Attendance" href="{{ route('attendance.create') }}">
                        <i class="fe fe-clipboard"></i>
                    </a>
                 </div>
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
@include('Admin.attendance.reports.partial.holidays_popup')
@push('js')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/custom/attendance/attendance_index.js') }}"></script>
<script>
    let allReportsURL = "{{ route('attendance.reports.data') }}";
    let holidaysURL   = "{{ route('attendance.mark_holidays') }}"
</script>
@endpush
@endsection
