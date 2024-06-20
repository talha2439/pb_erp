@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Create';
        $parentRoute = route('designations.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('designations.store', $designation->id);
        $parentButton = 'Update';
    }
@endphp
@section('content')
@section('title')
    {{ $title }} Designation
@endsection

<div class="row my-4">

    <div class="card-header mb-2">
        <h1>{{ $title }} Designation</h1>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST" id="designationForm" enctype="multipart/form-data">
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

                <div class="col-md-6 mt-3 ">
                    <div class="form-group">
                        <label for="name">Designation name <small class="text-danger">*</small></label>
                        <input type="text" name="name" placeholder="Enter designation name.."
                            class="form-control  mb-3">
                    </div>
                </div>



                <div class="col-md-12 d-flex justify-content-end ">
                    <a href="{{ route('designations.index') }}" class="btn btn-primary"
                        style="margin-right: 10px">Designation List</a>
                    <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
                </div>
            </div>

        </form>
    </div>
</div>
@push('js')

    <script src="{{ asset('assets/custom/designation.js') }}"></script>
    <script>
        let action = "{{ $action }}";
        let designationData = <?php echo isset($designation) && $designation ? json_encode($designation) : 0; ?>;
    </script>
@endpush
@endsection
