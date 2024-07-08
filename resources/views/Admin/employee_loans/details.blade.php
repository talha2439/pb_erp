@extends('Admin.layout')
@section('title')
Employee Loan Details
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>Employee Loan Details</h5>
        </div>
    </div>
    <div class="card p-2">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>Employee Loan Details </h3>
                <div>
                    <a href="{{ route('employee_loans.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="card-body border rounded ">
            <div class="row">
                <div class="col-md-3 mt-3 mb-2">
                    <span>Employee Name</span>
                    <h5>{{ $loanDetails->employees->first_name . " ". $loanDetails->employees->last_name ?? '' }}</h5>
                </div>
                <div class="col-md-3 mt-3 mb-2">
                    <span>Employee Department</span>
                    <h5>{{ $loanDetails->employees->departments->name  ?? " "}}</h5>
                </div>
                <div class="col-md-3 mt-3 mb-2" >
                    <span>Employee Designation</span>
                    <h5>{{ $loanDetails->employees->designations->name ?? ""  }}</h5>
                </div>
                <div class="col-md-3 mt-3 mb-2">
                    <span>Employee Shift</span>
                    <h5>{{ $loanDetails->employees->shifts->name ?? ""  }}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mt-3 mb-2">
                    <span>Loan Type</span>
                    <h5>{{ $loanDetails->loan_types->name ?? '' }}</h5>
                </div>
                <div class="col-md-3 mt-3 mb-2">
                    <span>Status</span>
                    <h5>{{ ucfirst($loanDetails->status) ??'' }}</h5>
                </div>
                <div class="col-md-6"></div>
                <div class="col-md-6 mt-3 mb-2">
                    <span>Requested Date</span>
                    @php
                          $requested_date = \Carbon\Carbon::parse($loanDetails->request_date);
                          $due_date = \Carbon\Carbon::parse($loanDetails->due_date);
                    @endphp
                    <h5>{{ $requested_date->format('F d, Y') ??    '' }}</h5>
                </div>
                <div class="col-md-6 mt-3 mb-2">
                    <span>Due Date</span>

                    <h5>{{ $due_date->format('F d, Y') ??    '' }}</h5>
                </div>

            </div>
            <div class="row">
                <div class="col-md-3 mt-3 mb-2">
                    <span>Requested Amount</span>
                    <h5>{{  \Number::currency($loanDetails->requested_amount , 'PKR' , 'en_PK') }}</h5>
                </div>
                <div class="col-md-3 mt-3 mb-2">
                    <span>Approved Amount</span>

                    <h5>{{  \Number::currency($loanDetails->approved_amount , 'PKR' , 'en_PK') }}</h5>
                </div>
                <div class="col-md-3 mt-3 mb-2">
                    <span>Paid Amount</span>

                    <h5>{{   \Number::currency($loanDetails->paid_amount , 'PKR' , 'en_PK') }}</h5>
                </div>
                <div class="col-md-3 mt-3 mb-2">
                    <span>Remaining Amount</span>

                    <h5>{{  \Number::currency($loanDetails->remaining_amount , 'PKR' , 'en_PK') }}</h5>
                </div>
                <div class="col-md-12 border rounded mt-3 mb-3 p-2"  style="min-height: 300px">
                    <span class="fw-bold">Reason / Description</span>
                    <p>{{ $loanDetails->reason ?? ""}}</p>

                </div>
            </div>
            <div class="d-flex justify-content-end" >
                <a href="{{ route('employee_loans.index') }}" class="btn btn-primary">Loan List</a>
            </div>
        </div>
    </div>
@endsection
