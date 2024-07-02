@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Create';
        $parentRoute = route('salary.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('salary.store', $salary->id);
        $parentButton = 'Update';
    }
@endphp
@section('content')
@section('title')
    {{ $title }} Salary information
@endsection

<div class="row my-4">

    <div class="card-header mb-2">
        <h1>{{ $title }} Salary information</h1>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST" id="salaryForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">

                <div class="col-md-12 mt-3">
                    <div class="form-group">
                        <label for="name">Employee name <small class="text-danger">*</small></label>
                            <select name="employee_id" data-type="required" data-name="Employee" id="employee_id" class="form-control select2 mb-2">
                                <option data-salary="" value="">-- Select Employee --</option>
                                @foreach ($employees as $item )
                                <option data-salary="{{ $item->salary }}" value="{{ $item->id }}">{{ $item->first_name }} {{ $item->last_name }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-md-6 mt-3 ">
                    <div class="form-group">
                        <label for="name">Gross Salary <small class="text-danger">*</small></label>
                        <input type="text"  data-type="required" data-name="Gross Salary" readonly name="gross_salary" id="grossSalary" readonly placeholder="Gross Salary.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-6 mt-3 ">
                    <div class="form-group">
                        <label for="name">Per Hour Amount <small class="text-danger">*</small></label>
                        <input type="text"  data-type="required" data-name="Amount per hour" readonly name="per_hour" id="perHour" placeholder="Per hour Amount.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Absent Deduction<small class="text-danger">*</small></label>
                        <input type="number" name="absent_deduction"  data-type="required" data-name="Absent Deduction" placeholder="Absent Deduction Amount.."
                            class="form-control  mb-3">
                    </div>
                </div>

                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Per Hour Deduction <small class="text-danger">*</small></label>
                        <input type="number" name="per_hour_deduction"  data-type="required" data-name="Amount Deduction per hour" placeholder="Deduction Amount.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-4 mt-3 ">
                    <div class="form-group">
                        <label for="name">Total allowance <small class="text-danger">*</small></label>
                        <input type="number" name="total_allowance"  data-type="required" data-name="Total Allowance" placeholder="Total Allowance.."
                            class="form-control  mb-3">
                    </div>
                </div>


                <div class="col-md-12 d-flex justify-content-end ">
                    <a href="{{ route('salary.index') }}" class="btn btn-primary"
                        style="margin-right: 10px">Salary List</a>
                    <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
                </div>
            </div>

        </form>
    </div>
</div>
@push('js')

    <script src="{{ asset('assets/custom/salary/salary.js') }}"></script>
    <script>

        let action = "{{ $action }}";
        let salaryData = <?php echo isset($salary) && $salary ? json_encode($salary) : 0; ?>;

    </script>
@endpush
@endsection
