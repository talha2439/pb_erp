@extends('Admin.layout')
@section('title')
    Loan Installment List
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>  Loan Installment List</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="row">
            <div class="d-flex col-md-12 justify-content-between">
                <h3>  Loan Installment List</h3>
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
                        <th>Total Amount</th>
                        <th>Installment Amount</th>
                        <th>Remaining Amount</th>
                        <th>Paid Amount</th>
                        <th>Payment Date</th>
                        <th>Confirmed by</th>
                        <th>Confirmed at</th>
                        <th>Details</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

    </div>
    @include('Admin.employee_loans.installment.partial.edit_popup')
    @push('js')
    <script src="{{ asset('assets/custom/loan/installment_index.js') }}"></script>
        <script>
            let basePath         = "{{ asset('') }}";
            let allDataURL       = "{{ route('loan_installment.allData') }}";
            let statusURL        = "{{ route('loan_installment.status') }}";
            let updateURL        = "{{ route('loan_installment.update') }}";
        </script>
    @endpush
@endsection
