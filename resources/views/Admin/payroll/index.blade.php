@extends('Admin.layout')
@section('title')
Payroll Information
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>Salary Slips / Payroll Information</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                 <h3>Salary Slips / Payroll Information</h3>
                <div class="d-flex justify-content-between">
                 <a class=" btn btn-primary text-white" style="width: max-content" type="a" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                     <i class="fe fe-filter"></i>
                 </a>  |   <a href="{{ route('payroll.create') }}" class="btn btn-info text-white"><i class="fe fe-plus"></i></a>
                  <div>

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
                              @include('Admin.payroll.partial.filter')
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
                        <th>Employee-ID</th>
                        <th>Name</th>
                        <th>Gross Salary</th>
                        <th>Absent Deduction</th>
                        <th>Total Absents</th>
                        <th>Total Lates</th>
                        <th>Total Early-out</th>
                        <th>Total Leaves</th>
                        <th>Total Off's / Holidays</th>
                        <th>Deduction Amount</th>
                        <th>Loan Amount</th>
                        <th>Bonus Amount</th>
                        <th>Allowance</th>
                        <th>Net Salary</th>
                        <th>Month / Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
    @push('js')
        <script src="{{ asset('assets/custom/payroll/payroll_index.js') }}"></script>
        <script>
            let allDataURL = "{{ route('payroll.data' , ['type' => 'index']) }}";
            let dataTable ;
            let department  = $(document).find("#department");
            let employee    = $(document).find("#employee");
            let month       = $(document).find("#month");
            let year        = $(document).find("#year");




        </script>
    @endpush
@endsection
