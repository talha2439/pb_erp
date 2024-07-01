@extends('Admin.layout')
@section('title')
    All Employees
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>Employees</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="row">
            <div class="d-flex col-md-12 justify-content-between">
                <h3>All Employees</h3>
                <div>
                    <a href="#" class="btn btn-primary text-white" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        <i class="fe fe-filter"></i>
                    </a> |
                    <a href="{{ route('employees.create') }}" class="btn btn-info text-white" ><i class="fe fe-plus"></i></a>

                </div>
            </div>
            <div class="col-md-12">
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item border-0">
                      <h2 class="accordion-header" id="headingThree">
                      </h2>
                      <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                        <div class="accordion-body">
                         @include('Admin.employee.partial.filter')
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
        </div>
        <div class="table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Employee-Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Designation</th>
                        <th>Employeement-Status</th>
                        <th>Salary</th>
                        <th>Documents</th>
                        <th>Qualification</th>
                        <th>Experience</th>
                        <th>All Details</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    </div>
    {{-- Modals Partials --}}
    @include('Admin.employee.popup.experience')
    @include('Admin.employee.popup.qualification')
    {{-- End of Modal Partial --}}
    @push('js')
        <script src="{{ asset('assets/custom/employee/employee_index.js') }}"></script>
        <script>
            let basePath = "{{ asset('') }}";
            let deleteUrl = "{{ route('employees.delete') }}";
            let getQualificationUrl = "{{ route('employees.get.qualification') }}";
            let getExperienceUrl = "{{ route('employees.get.experience') }}";
            let getAlldata       = "{{ route('employees.get.data' , ['type' => 'index']) }}";
        </script>
    @endpush
@endsection
