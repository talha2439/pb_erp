@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Create';
        $parentRoute = route('menusettings.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('menusettings.store', $menu->id);
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
        {{-- step 1 form --}}
        @include('Admin.forms.employees.step1')
        


    </div>
</div>




@push('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.js"></script>
    <script src="{{ asset('assets/custom/employee.js') }}"></script>
@endpush
@endsection
