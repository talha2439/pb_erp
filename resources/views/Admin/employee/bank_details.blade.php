@extends('Admin.layout')
@php

        $title = 'Save';
        $parentRoute = route('employees.bank_details.store');
        $parentButton = 'Save';

@endphp
@section('content')
@section('title')
    Employee Bank Details
@endsection



    <div class="card-header mb-2">
        <h1> Employee Bank Details</h1>
    </div>
    <div class="card p-3">
        <form  method="POST" id="bankDetailsForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">

                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label for="name">Employee (<small class="text-danger">*</small>)</label>
                        <select  data-type="required" class="form-control mt-2 mb-3 select2" data-type="required" data-name="Employee name"  name="employee_id" id="employee_id">
                            <option value="">-- SELECT EMPLOYEE --</option>
                            @foreach($employees as $key =>$item)
                            <option value="{{ $item->id }}">{{ $item->first_name .' '. $item->last_name }}</option>
                            @endforeach
                        </select>
                    </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="name">Account holder name (<small class="text-danger">*</small>)</label>
                        <input type="text" name="account_holder_name" id="account_holder_name"  data-type="required" data-name="Account Holder name" placeholder="Enter Account holder.."
                            class="form-control mt-3 mb-3">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Bank Name (<small class="text-danger">*</small>)</label>
                        <input type="text" name="name"   id="name"  data-type="required" data-name="Bank name" placeholder="Enter Bank name.."
                            class="form-control mt-3 mb-3">
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Branch Name (<small class="text-secondary">Optional</small>)</label>
                        <input type="text" name="branch_name" id="branch_name" placeholder="Enter Branch Name.."
                            class="form-control mt-3 mb-3">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">Account Number (<small class="text-danger">*</small>)</label>
                        <input type="text" name="account_number" id="account_number" data-type="required" data-name="Account Number" placeholder="Enter Account number.."
                            class="form-control mt-3 mb-3">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="name">IBAN Number (<small class="text-secondary">Optional</small>)</label>
                        <input type="text" id="iban_number" name="iban" placeholder="Enter IBAN number.."
                            class="form-control mt-3 mb-3">
                    </div>
                </div>





                <div class="col-md-12 d-flex justify-content-end ">

                    <button class="btn btn-success" type="submit" id="submitBtn">{{ $parentButton }}</button>
                </div>
            </div>

        </form>
    </div>

@push('js')
    <script src="{{ asset('assets/custom/employee/bank_details.js') }}"></script>
    <script>
        let bankDetailURL = "{{ route('employees.employee_bank_details') }}";
        let storeURL      =  "{{ $parentRoute }}";
    </script>
@endpush
@endsection
