@extends('Admin.layout')
@php
    if ($action == 'create') {
        $title = 'Create';
        $parentRoute = route('loan_type.store');
        $parentButton = 'Save';
    } else {
        $title = 'Edit';
        $parentRoute = route('loan_type.store', $loan_type->id);
        $parentButton = 'Update';
    }
@endphp
@section('content')
@section('title')
    {{ $title }} Loan Type
@endsection



    <div class="card-header mb-2">
        <h1>{{ $title }} Loan Type</h1>
    </div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST" id="loanTypeForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
            <div class="row">

                <div class="col-md-12 ">
                    <div class="form-group">
                        <label for="name">Loan Type  (<small class="text-danger">Must be
                            unique</small>)</label>
                        <input type="text" name="name" placeholder="Enter Loan Type.."
                            class="form-control mt-3 mb-3">
                    </div>
                </div>



                <div class="col-md-12 d-flex justify-content-end ">
                    <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
                </div>
            </div>

        </form>
    </div>

@push('js')
    <script src="{{ asset('assets/custom/loan/loan_type/loan_type.js') }}"></script>
    <script>
        let deleteURl = "{{ route('loan_type.delete') }}"
        let action = "{{ $action }}";
        let loanTypeData = <?php echo isset($loan_type) && $loan_type ? json_encode($loan_type) : 0; ?>;
    </script>
@endpush
@endsection
