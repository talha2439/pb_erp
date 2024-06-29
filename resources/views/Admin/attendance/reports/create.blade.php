@extends('Admin.layout')
@php
    if($action == 'create'){
        $title = 'Mark';
        $parentRoute = route('attendance.store');
        $parentButton = 'Save';
    }
    else{
        $title = "Edit";
        $parentRoute = route('attendance.store' ,$attendance->id);
        $parentButton = 'Update';
    }
    @endphp
@section('content')
@section('title')
{{ $title }} Attendance
@endsection

<div class="row my-4">

    <div class="card-header mb-2">
        <div class="d-flex justify-content-between g-2">
            <h1>{{ $title }} Attendance </h1>
            <div>  <a href="{{ route('attendance.reports.all') }}" class="btn btn-primary btn-sm shadow"><i class="fe fe-menu"></i></a></div>
        </div>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST"  id="attendanceForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
        <div class="row">

        <div class="col-md-12 mb-3">
            <div class="form-group">
                <label for="profile">Employee (<small class="text-danger"> * </small>)</label>
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
                <label for="name">Check-In(<small class="text-danger">*</small>) </label>
                <input type="time"  data-type="required"  data-name ="Check in time " name="check_in" class="form-control  mb-3">
            </div>
        </div>
        <div class="col-md-6 from_container">
            <div class="form-group">
                <label for="name">Checkout (<small class="text-secondary">optional</small>) <small class="text-warning">Cannot be changed at marking attendance.</small> </label>
                <input type="time"  @if($action == 'create') readonly @endif name="check_out" class="form-control  mb-3">
            </div>
        </div>
        @if($action == 'edit')
        <div class="col-md-6 from_container">
            <div class="form-group">
                <label for="name">Date (<small class="text-danger">*</small>) </label>
                <input type="date"  data-type="required"  data-name ="Attendance  Date " placeholder="Date" name="date" class="form-control  mb-3">
            </div>
        </div>
        <div class="col-md-6 menu_container">
            <div class="form-group">
                <label for="name">Attendance Status (<small class="text-danger"> * </small>)</label>
                <select type="text" data-type="required"  data-name ="Attendance Status "name="attendance_status"  class="form-control mt-2 mb-3 select2">
                    <option value="">-- Select Attendance Status --</option>
                    <option value="present">Present</option>
                    <option value="absent">Absent</option>
                    <option value="leave">Leave</option>
                    <option value="off">Off</option>
                    </select>
            </div>
        </div>



        <div class="col-md-6 mb-2 to_date">
            <div class="form-group">
                <label for="name">Working Hours (<small class="text-danger">*</small>) </label>
                <input type="number" data-type="required" value="0" max="9"  data-name ="Work Hours " placeholder="Work Hours" name="working_hours" class="form-control  mb-3">
            </div>
        </div>
        <div class="col-md-6 mb-2 to_date">
            <div class="form-group">
                <label for="name">Working Minutes (<small class="text-danger">*</small>) </label>
                <input type="number" data-type="required" value="0"  data-name ="Work Minutes " placeholder="Work Minutes" name="working_minutes" class="form-control  mb-3">
            </div>
        </div>
        <div class="col-md-12 mb-3 menu_container">
            <div class="form-group">
                <label for="name">Work Status (<small class="text-danger"> * </small>)</label>
                <select type="text" data-type="required"  data-name ="Working Status "name="working_status"  class="form-control mt-2 mb-3 select2">
                    <option value="">-- Select Work Status --</option>
                    <option value="on-time">On Time</option>
                    <option value="absent">Absent</option>
                    <option value="leave">Leave</option>
                    <option value="late">Late</option>
                    <option value="off">Off</option>
                    <option value="late and early-out">Late and Early-out</option>
                    <option value="early-out">Early out</option>
                    <option value="early-in and early-out">Early-in & Early-out</option>
                    <option value="late-setting">Extra Hours</option>
                  </select>
            </div>
        </div>
        <div class="col-md-6 mb-3 extra_container" style="display: none">
            <div class="form-group">
                <label for="name">Extra Hours (<small class="text-danger"> * </small>)</label>
               <input type="number" class="form-control"  name="extra_hours" data-type="required"  data-name="Extra Working Hours" placeholder="Extra Hours">
            </div>
        </div>
        <div class="col-md-6 mb-3 extra_container" style="display: none">
            <div class="form-group">
                <label for="name">Extra Minutes (<small class="text-danger"> * </small>)</label>
               <input type="number" class="form-control" value="0" name="extra_minutes"  placeholder="Extra Minutes">
            </div>
        </div>
        @endif


<hr>

    <div class="col-md-12 d-flex justify-content-end ">
        <a href="{{ route('attendance.reports.all') }}" class="btn btn-primary" style="margin-right: 10px">Attendance Reports</a>
        <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
    </div>
</div>

        </form>
    </div>
</div>
@push('js')
<script src="{{ asset('assets/custom/attendance/attendance_create.js') }}"></script>
<script>
    let action          = "{{ $action }}";
    let attendance      = <?php echo isset($attendance) && $attendance ? json_encode($attendance) : 0 ;?>;
    let role            = "{{ Auth::user()->role }}";
</script>
@endpush
@endsection
