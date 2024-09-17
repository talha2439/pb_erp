@extends('Admin.layout')
@php
        $title = 'Create';
        $parentRoute = route('designations.store');
        $parentButton = 'Save';

@endphp
@section('content')
@section('title')
Loan Installment
@endsection



    <div class="card-header mb-2">
        <div class="d-flex justify-content-between g-2">
            <h1>Loan Installments </h1>
            <div>  <a href="{{ route('loan_installment.list') }}" class="btn btn-primary btn-sm shadow"><i class="fe fe-menu"></i></a></div>
        </div>
    </div>
    <div class="card p-3">
        @if(!empty($loan))
        <form action="{{ route('loan_installment.store') }}" method="POST" id="loanInstallmentForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">


                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <input type="hidden" name="loan_id" value="{{ $loan->id ?? ""}}">
                        <label for="name">Total Amount <small class="text-danger">*</small></label>
                        <input type="text" name=""  disabled value="{{ $loan->approved_amount ?? 0 }}" placeholder="Enter Paid amount.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Paid Amount <small class="text-danger">*</small></label>
                        <input type="text" name="" disabled value="{{ $loan->paid_amount ?? 0 }}" placeholder="Enter Paid amount.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Remaining Amount <small class="text-danger">*</small></label>
                        <input type="text" name="" disabled value="{{ $loan->remaining_amount ?? 0 }}" placeholder="Enter Remaining amount.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Installment Amount <small class="text-danger">*</small></label>
                        <input type="number" name="amount" data-type="required" data-name="Installment Amount" placeholder="Enter amount amount.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3">
                    <div class="form-group">
                        <label for="name">Payment Method <small class="text-danger">*</small></label>
                        <select name="paid_by" id="paid_by" data-type="required" data-name="Payment Method" class="form-control select2">
                            <option value="">-- SELECT PAYMENT METHOD --</option>
                            <option value="cash">Cash</option>
                            <option value="bank-transfer">Bank Transfer</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Attachment</label>
                        <input type="file" name="attachment"  placeholder="Enter amount amount.."
                            class="form-control  mb-3">
                    </div>
                </div>


                <div class="col-md-12 d-flex justify-content-end ">
                    <button class="btn btn-success" id="submitBtn" type="submit">Pay Loan</button>
                </div>
            </div>

        </form>
        @else
        <center><h3 class="border p-2 rounded text-success">No Payable Loans</h3></center>
        @endif
    </div>

@push('js')

    <script src="{{ asset('assets/custom/loan/installment.js') }}"></script>
@endpush
@endsection
