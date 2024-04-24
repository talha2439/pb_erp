@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Create';
        $parentRoute = route('departments.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('departments.store', $department->id);
        $parentButton = 'Update';
    }
@endphp
@section('content')
@section('title')
    {{ $title }} Department
@endsection

<div class="row my-4">

    <div class="card-header mb-2">
        <h1>{{ $title }} Department</h1>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST" id="departForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">

                <div class="col-md-12 ">
                    <div class="form-group">
                        <label for="name">Department name (<small class="text-danger">Must be
                                unique</small>)</label>
                        <input type="text" name="name" placeholder="Enter department name.."
                            class="form-control mt-3 mb-3">
                    </div>
                </div>



                <div class="col-md-12 d-flex justify-content-end ">
                    <a href="{{ route('departments.index') }}" class="btn btn-primary"
                        style="margin-right: 10px">Department List</a>
                    <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
                </div>
            </div>

        </form>
    </div>
</div>
@push('js')
    <script src="{{ asset('assets/custom/department.js') }}"></script>
    <script>
        let deleteURl = "{{ route('departments.delete') }}"
        let action = "{{ $action }}";
        let departdata = <?php echo isset($department) && $department ? json_encode($department) : 0; ?>;
    </script>
@endpush
@endsection
