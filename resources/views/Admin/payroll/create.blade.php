@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Create';
        $parentRoute = route('payroll.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('payroll.store', $payroll->id);
        $parentButton = 'Update';
    }
@endphp
@section('content')
@section('title')
    {{ $title }} Payroll information
@endsection



    <div class="card-header mb-2">
        <div class="d-flex justify-content-between g-2">
            <h1>{{ $title }} Payroll information </h1>
            <div>  <a href="{{ route('payroll.index') }}" class="btn btn-primary btn-sm shadow"><i class="fe fe-menu"></i></a></div>
        </div>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST" id="payrollForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">

                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="name">Employee name (<small class="text-danger">*</small>)</label>
                            <select name="employee_id" data-type="required" data-name="Employee" id="employee_id" class="form-control select2 mb-2">
                                <option data-salary="" value="">-- Select Employee --</option>
                                @foreach ($employees as $item )
                                <option data-salary="{{ $item->salary }}" value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Gross Salary (<small class="text-danger">*</small>)</label>
                        <input type="text"  data-type="required" data-name="Gross Salary" readonly name="gross_salary" id="grossSalary"  placeholder="Gross Salary.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Loan Amount </label>
                        <input type="text" value="0"  name="loan_amount" id="loan_amount"  placeholder="Loan Amount.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Bonus amount</label>
                        <input type="text"  value="0"   name="bonus_amount" id="bonus_amount"  placeholder="Bonus Amount.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Per Absent Deduction (<small class="text-danger">*</small>)</label>
                        <input type="text"   value="0"  data-type="required" data-name="Per Absent Deduction "  name="per_absents_deduction" id="absent_deduction"  placeholder="Per Absent Deduction.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Total Absents (<small class="text-danger">*</small>)</label>
                        <input type="number"  value="0"    name="total_absents" id="total_absents"  placeholder="Total Absents.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Total Leaves (<small class="text-danger">*</small>)</label>
                        <input type="number"  value="0"     name="total_leaves" id="total_leaves"  placeholder="Total leaves.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Total Off (<small class="text-danger">*</small>) <small>Holidays or Weekdays etc.</small></label>
                        <input type="number" readonly  value="0"   name="total_off" id="total_off"  placeholder="Total Off.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Total Lates (<small class="text-danger">*</small>)</label>
                        <input type="number"  value="0"    name="total_lates" id="total_lates"  placeholder="Total Lates.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Total Early Outs (<small class="text-danger">*</small>)</label>
                        <input type="number"  value="0"   name="total_early_outs" id="total_early_outs"  placeholder="Total Early Outs.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-12 d-flex justify-content-end ">
                    <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
                </div>
            </div>

        </form>
    </div>
@push('js')

    <script src="{{ asset('assets/custom/payroll/payroll.js') }}"></script>
    <script>

        let action = "{{ $action }}";
        let payrollData = <?php echo isset($payroll) && $payroll ? json_encode($payroll) : 0; ?>;

    </script>
@endpush
@endsection
