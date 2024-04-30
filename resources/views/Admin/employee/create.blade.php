@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Create';
        $parentRoute = route('employees.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('employees.store');
        $employeeId  =  $employee->id;
        $parentButton = 'Update';
    }
@endphp
@section('content')
@section('title')
    {{ $title }} Employees
@endsection
<style>
    .select2-container--default .select2-selection--single {
        background-color: #fff;
        border: 1px solid #aaaaaa7d !important;
        border-radius: 5px !important;
        padding: 4px !important;
        position: relative !important;
        top: 2px !important;
    }

    .select2-container .select2-selection--single {
        height: 38px !important;
    }

    .light-style .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 1.8rem !important;
    }

    .select2-container .select2-selection--single {

        height: 38px !important;

    }
</style>
<div class="row my-4">

    <div class="card-header mb-2">
        <h1>{{ $title }} Employee</h1>
    </div>
    <div class="card p-3">
        <div class="header-title step_title">
            <h3><strong class="text-primary ">
                    Step 1 :</strong> Personal Information</h3>
            <hr>
        </div>
        <input type="hidden" name="emp_id" value="{{ $employeeId ?? "" }}">
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">


        {{-- Step 3 from --}}
        @include('Admin.forms.employees.step3')
        {{-- Step 2 from --}}
        @include('Admin.forms.employees.step2')
        {{-- step 1 form --}}
        @include('Admin.forms.employees.step1')



    </div>
</div>




@push('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.js"></script>
    <script src="{{ asset('assets/plugins/masking/jquery.mask.min.js') }}"></script>
    <script src="{{ asset('assets/custom/employee/employee-step1.js') }}"></script>
    <script src="{{ asset('assets/custom/employee/employee-step2.js') }}"></script>
    <script src="{{ asset('assets/custom/employee/employee-step3.js') }}"></script>
    {{-- Edit Employee JS Links --}}
    <script src="{{ asset('assets/custom/employee/edit-employee-step1.js') }}"></script>
    <script src="{{ asset('assets/custom/employee/employee_update.js') }}"></script>
 
    {{-- Back button JS --}}
    <script src="{{ asset("assets/custom/employee/backbutton.js") }}"></script>
    <script>
        let stateURL = "{{ route('state.get') }}";
        let cityURL = "{{ route('city.get') }}";
        let action  = "{{ $action }}";
        let designationAndShiftURL = "{{ route('shift.designations') }}";
        let employeeStore          = "{{ $parentRoute }}";
        let qualificationPost      = "{{ route('employees.qualification.store') }}";
        let storeExperiencePost    = "{{ route('employees.experience.store') }}";
        let employeesListUrl       = "{{ route('employees.index') }}";
        let employeeData           = <?php echo isset($employee) && $employee ? json_encode($employee) : 0 ?>;
        let qualificationEdit      = "{{ route('employees.qualification.edit') }}";
        let deleteQualification    = "{{ route('employees.qualification.delete') }}";
        let deleteExperience       = "{{ route('employees.experience.delete') }}";
        let experienceEdit         = "{{ route('employees.experience.edit') }}";
        $(document).ready(function(){
            editQualification();
            editExperience();
        })
    </script>
@endpush
@endsection
