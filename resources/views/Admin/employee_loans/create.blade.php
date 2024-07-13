@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Request';
        $parentRoute = route('employee_loans.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('employee_loans.store', $loans->id);
        $parentButton = 'Update';
    }
@endphp
@section('content')
@section('title')
    {{ $title }} Employee Loans
@endsection



    <div class="card-header mb-2">
        <h1>{{ $title }} Employee Loans</h1>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST" id="loanForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">
                
                @if(Auth::user()->role != 4)
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="name" >Employee name  (<small class="text-danger">*</small>)</label>
                        <select type="text" name="employee_id" data-type="required" data-name="Employee name" class="form-control select2 mt-1 mb-3">
                            <option value="">-- SELECT EMPLOYEE  --</option>
                            @foreach ($employees as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                    @endif
                <div class="@if(Auth::user()->role != 4)col-md-3 @else col-md-4 @endif   ">
                    <div class="form-group">
                        <label for="name">Loan Type  (<small class="text-danger">*</small>)</label>
                        <select type="text" name="loan_type_id" data-type="required" data-name="Loan type" class="form-control select2 mt-1 mb-3">
                        <option value="">-- SELECT LOAN TYPE --</option>
                        @foreach ($loan_types as $key => $item)
                            <option value="{{ $key }}">{{ $item }}</option>
                        @endforeach
                        </select>
                    </div>
                </div>
                <div class="@if(Auth::user()->role != 4)col-md-3 @else col-md-4 @endif">
                    <div class="form-group">
                        <label for="">Requested Amount (<small class="text-danger">*</small>)</label>
                    </div>
                    <input type="number" placeholder="Request Amount" name="requested_amount" id="requested_amount" class="form-control" data-type="required" data-name="Requested Amount">
                </div>
                <div class="@if(Auth::user()->role != 4)col-md-3 @else col-md-4 @endif">
                    <div class="form-group">
                        <label for="name">Installment Type  (<small class="text-danger">*</small>)</label>
                        <select type="text" name="repay_type" id="repay_type" data-type="required" data-name="Installment type" class="form-control select2 mt-1 mb-3">
                        <option value="">-- SELECT LOAN TYPE --</option>
                        <option value="monthly">Monthly</option>
                        <option value="salary">Salary Deduction</option>
                        <option value="duration">Duration wise</option>
                        </select>
                    </div>
                </div>



                <div class="col-md-6 mt-3 mb-1 duration_date" style="display: none">
                    <div class="form-group">
                        <label for="">Requested Date (<small class="text-danger">*</small>)</label>
                    </div>
                    <input type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d')}}" name="request_date" id="request_date" class="form-control" data-type="" data-name="Requested date">
                </div>
                <div class="col-md-6 mt-3 mb-1 duration_date" style="display: none">
                    <div class="form-group">
                        <label for="">Due Date (<small class="text-danger">*</small>)</label>
                    </div>
                    <input type="date" name="due_date" id="due_date" class="form-control" data-type="" data-name="Due date">
                </div>
                <div class="col-md-6 mt-3 mb-1 no_months "style="display:none">
                    <div class="form-group">
                        <label for="name">Number of Months (<small class="text-danger">*</small>)</label>
                        <input type="number" placeholder="Number of Months" name="total_month" id="total_month" class="form-control" data-type="" data-name="Number Months">

                    </div>
                </div>
                <div class="col-md-6 mt-3 mb-1 partial_container" style="display: none">
                    <div class="form-group">
                        <label for="name">Partial Payment (<small class="text-danger">*</small>)</label>
                        <input type="number" placeholder="Partial Amount" name="partial_amount" id="partial_amount" class="form-control" data-type="" data-name="Partial Amount">

                    </div>
                </div>

                <div class="col-md-12 mt-3 mb-2">
                    <div class="form-group">
                        <label for="name">Description / Reason (<small class="text-danger">*</small>)</label>
                        <textarea name="reason" id="" class="form-control" data-type="required" placeholder="Reason For Loan" data-name="Reason for Loan" cols="30" rows="10"></textarea>
                    </div>
                </div>


                <div class="col-md-12 d-flex justify-content-end mt-3">
                    <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
                </div>
            </div>

        </form>
    </div>

@push('js')
    <script src="{{ asset('assets/custom/loan/loan.js') }}"></script>
    <script>
        let deleteURl = "{{ route('employee_loans.delete') }}"
        let action = "{{ $action }}";
        let loanData = <?php echo isset($loans) && $loans ? json_encode($loans) : 0; ?>;
    </script>
@endpush
@endsection
