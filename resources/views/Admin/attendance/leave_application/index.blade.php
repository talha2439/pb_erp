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
           <div class="d-flex">
            <button class=" btn btn-primary text-white" style="width: max-content" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                <i class="fe fe-filter"></i>
               </button> |
             <div>
                <a href="{{ route('leave.application.create') }}" class="btn btn-info text-white"><i class="fe fe-plus"></i></a>
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
@include('Admin.attendance.leave_application.partial.view_application')
@push('js')
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>

<script src="{{ asset('assets/js/moment.js') }}"></script>
<script src="{{ asset('assets/js/daterangepicker.js') }}"></script>
<script src="{{ asset('assets/custom/attendance/leave_index.js') }}"></script>
<script>


    let allReportsURL = "{{ route('leave.application.data') }}";
    let dataTable  = null ;
    let deleteUrl = "{{ route('leave.application.delete') }}";
    let changeStatusURL = "{{ Route('leave.application.status') }}";
    let detailsURL = "{{ route('leave.application.details') }}";
    let basePath  = "{{ asset('') }}";
</script>
@endpush
@endsection
