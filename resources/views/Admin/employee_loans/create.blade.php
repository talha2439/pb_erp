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
        <div class="d-flex justify-content-between g-2">
            <h1>{{ $title }} Employee Loans</h1>
            <div>  <a href="{{ route('employee_loans.index') }}" class="btn btn-primary btn-sm shadow"><i class="fe fe-menu"></i></a></div>
        </div>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST" id="loanForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">

                <div class="col-md-6 ">
                    <div class="form-group">
                        @if(Auth::user()->role != 4)
                        <label for="name" >Employee name  (<small class="text-danger">*</small>)</label>
                        <select type="text" name="employee_id" data-type="required" data-name="Employee name" class="form-control select2 mt-1 mb-3">
                            <option value="">-- SELECT EMPLOYEE  --</option>
                            @foreach ($employees as $id => $name)
                                <option value="{{ $id }}">{{ $name }}</option>
                            @endforeach
                            </select>
                        @else
                        <input type="hidden" name="employee_id" value="{{ Auth::user()->id }}">
                        @endif
                    </div>
                </div>
                <div class="col-md-6 ">
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
                <div class="col-md-4 mt-3 mb-1">
                    <div class="form-group">
                        <label for="">Requested Amount (<small class="text-danger">*</small>)</label>
                    </div>
                    <input type="number" placeholder="Request Amount" name="requested_amount" id="" class="form-control" data-type="required" data-name="Requested Amount">
                </div>

                <div class="col-md-4 mt-3 mb-1">
                    <div class="form-group">
                        <label for="">Requested Date (<small class="text-danger">*</small>)</label>
                    </div>
                    <input type="date" value="{{ \Carbon\Carbon::now()->format('Y-m-d')}}" name="request_date" id="" class="form-control" data-type="required" data-name="Requested date">
                </div>
                <div class="col-md-4 mt-3 mb-1">
                    <div class="form-group">
                        <label for="">Due Date (<small class="text-danger">*</small>)</label>
                    </div>
                    <input type="date" name="due_date" id="" class="form-control" data-type="required" data-name="Due date">
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
