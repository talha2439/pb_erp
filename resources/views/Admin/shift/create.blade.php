@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Create';
        $parentRoute = route('shifts.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('shifts.store', $shift->id);
        $parentButton = 'Update';
    }
@endphp
@section('content')
@section('title')
    {{ $title }} Shift
@endsection

<div class="row my-4">

    <div class="card-header mb-2">
        <h1>{{ $title }} Shift</h1>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST" id="shiftform" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="name">Department name <small class="text-danger">*</small></label>

                            <select name="department" id="" class="form-select">
                                <option value="">-- Select Department --</option>
                                @foreach ($department as $item )
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                    </div>
                </div>

                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="name">Shift name <small class="text-danger">*</small></label>
                        <input type="text" name="name" placeholder="Enter designation name.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="name">Shift Start Time <small class="text-danger">*</small></label>
                        <input type="time" name="start_time" placeholder="Enter designation name.."
                            class="form-control  mb-3">
                    </div>
                </div>
                <div class="col-md-6 mt-3">
                    <div class="form-group">
                        <label for="name">Shift End Time <small class="text-danger">*</small></label>
                        <input type="time" name="end_time" placeholder="Enter designation name.."
                            class="form-control  mb-3">
                    </div>
                </div>

                <div class="col-md-12 mt-3 mb-3">
                    <div class="form-group">
                        <label for="name">Select Days <small class="text-danger">*</small></label><br>
                        <div class="btn-group" role="group" aria-label="Basic checkbox toggle button group">
                            <input type="checkbox" class="btn-check" name="days[]" id="All" value="all" autocomplete="off">
                            <label class="btn btn-outline-primary" for="All">All</label>

                            <input type="checkbox" class="btn-check" name="days[]" id="monday" value="monday" autocomplete="off">
                            <label class="btn btn-outline-primary" for="monday">Monday</label>

                            <input type="checkbox" class="btn-check" id="Tuesday" name="days[]" value="tuesday" autocomplete="off">
                            <label class="btn btn-outline-primary" for="Tuesday">Tuesday</label>

                            <input type="checkbox" class="btn-check" id="Wednesday" name="days[]" value="wednesday" autocomplete="off">
                            <label class="btn btn-outline-primary" for="Wednesday">Wednesday</label>

                            <input type="checkbox" class="btn-check" id="thursday" name="days[]" value="thursday" autocomplete="off">
                            <label class="btn btn-outline-primary" for="thursday">Thursday</label>

                            <input type="checkbox" class="btn-check" id="friday" name="days[]" value="friday" autocomplete="off">
                            <label class="btn btn-outline-primary" for="friday">Friday</label>

                            <input type="checkbox" class="btn-check" id="saturday" name="days[]" value="saturday" autocomplete="off">
                            <label class="btn btn-outline-primary" for="saturday">Saturday</label>

                            <input type="checkbox" class="btn-check" id="sunday" name="days[]" value="sunday" autocomplete="off">
                            <label class="btn btn-outline-primary" for="sunday">Sunday</label>

                          </div>
                    </div>
                </div>



                <div class="col-md-12 d-flex justify-content-end ">
                    <a href="{{ route('shifts.index') }}" class="btn btn-primary"
                        style="margin-right: 10px">Shift List</a>
                    <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
                </div>
            </div>

        </form>
    </div>
</div>
@push('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.js"></script>
    <script src="{{ asset('assets/custom/shift.js') }}"></script>
    <script>
        let action = "{{ $action }}";
        let shiftData = <?php echo isset($shift) && $shift ? json_encode($shift) : 0; ?>;
    </script>
@endpush
@endsection
