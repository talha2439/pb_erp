@extends('Admin.layout')
@php
    if($action == 'create'){
        $title = 'Apply';
        $parentRoute = route('leave.application.store');
        $parentButton = 'Save';
    }
    else{
        $title = "Edit";
        $parentRoute = route('leave.application.store' ,$leave->id);
        $parentButton = 'Update';
    }
    @endphp
@section('content')
@section('title')
{{ $title }} Leave Application
@endsection

<div class="row my-4">

    <div class="card-header mb-2">
        <div class="d-flex justify-content-between g-2">
            <h1>{{ $title }} Leave Application</h1>
            <div>  <a href="{{ route('leave.application.index') }}" class="btn btn-primary btn-sm shadow"><i class="fe fe-menu"></i></a></div>
        </div>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST"  id="leaveApplicationForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
        <div class="row">
           <div class="col-md-12 mb-3">
        <div class="form-group">
            <label for="profile">Employee (<small class="text-danger"> Required </small>)</label>
            <select type="text" data-type="required"  data-name ="Employee name " name="employee_id" placeholder="Enter Select employee!" class="form-control mt-3 mb-3 select2">
              <option value="">-- Select Employee --</option>
              @foreach($employees as $item)
              <option value="{{ $item->id }}">{{ $item->first_name }}</option>
              @endforeach
            </select>
        </div>
    </div>

    <div class="col-md-6 from_container">
        <div class="form-group">
            <label for="name">From (<small class="text-danger">Required</small>) </label>
            <input type="date" data-length='required' data-type="required"  data-name ="Application Start Date " name="from_date" class="form-control  mb-3">
        </div>
    </div>
    <div class="col-md-6 to_date">
        <div class="form-group">
            <label for="name">To (<small class="text-danger">Required</small>) </label>
            <input type="date" data-length='greater'  data-type="required"  data-name ="Application End Date " name="to_date" class="form-control  mb-3">
        </div>
    </div>
    <div class="col-md-6 menu_container">
        <div class="form-group">
            <label for="name">Leave Type (<small class="text-danger"> Required </small>)</label>
            <select type="text" data-type="required"  data-name ="Leave Type "name="leave_type" placeholder="Enter Select employee!" class="form-control mt-2 mb-3 select2">
                <option value="">-- Select Leave Type --</option>
                <option value="1">Annual leave</option>
                <option value="2">Sick Leave</option>
              </select>
        </div>
    </div>
    <div class="col-md-6 menu_container">
        <div class="form-group">
            <label for="name">Attachment (<small class="text-secondary">optional</small>) </label>
            <input type="file" name="attachment" class="form-control  mb-3">
        </div>
    </div>
    <div class="col-md-12 menu_container">
        <div class="form-group">
            <label for="name">Reason (<small class="text-danger">Required</small>)</label>
            <textarea type="text" data-type="required"  data-name ="Reason for Leave " name="reason" placeholder="Enter Reason for leave..!" rows="10" class="form-control mb-3"></textarea>
        </div>
    </div>

<hr>

    <div class="col-md-12 d-flex justify-content-end ">
        <a href="{{ route('leave.application.index') }}" class="btn btn-primary" style="margin-right: 10px">Leave List</a>
        <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
    </div>
</div>

        </form>
    </div>
</div>
@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.js"></script>
<script src="{{ asset('assets/custom/attendance/leave_application.js') }}"></script>
<script>
    let action          = "{{ $action }}";
    let userData        = <?php echo isset($leave) && $leave ? json_encode($leave) : 0 ;?>;
</script>
@endpush
@endsection
