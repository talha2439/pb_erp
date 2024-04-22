@extends('Admin.layout')
@php
    if($action == 'create'){
        $title = 'Create';
        $parentRoute = route('users.store');
        $parentButton = 'Save';
    }
    else{
        $title = "Edit";
        $parentRoute = route('users.store' ,$user->id);
        $parentButton = 'Update';
    }
    @endphp
@section('content')
@section('title')
{{ $title }} Users
@endsection

<div class="row my-4">

    <div class="card-header mb-2"><h1>{{ $title }} Users</h1></div>
    <div class="card p-3">
        <form action="{{ $parentRoute }}" method="POST"  id="userForm" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ csrf_token() }}" id="csrf-token">
        <div class="row">
           <div class="col-md-12">
        <div class="form-group">
            <label for="profile">User Profile (<small> Optional </small>)</label>
            <input type="file" name="image" class="form-control mt-3 mb-3">
        </div>
    </div>
    <div class="col-md-6 menu_container">
        <div class="form-group">
            <label for="name">User name (<small class="text-danger">Must be unique</small>)</label>
            <input type="text" name="username" placeholder="Enter User name for user..!" class="form-control mt-3 mb-3">
        </div>
    </div>
    <div class="col-md-6 menu_container">
        <div class="form-group">
            <label for="name">Full name (<small class="text-danger">Required</small>) </label>
            <input type="text" name="name" placeholder="Enter Full name for user..!" class="form-control mt-3 mb-3">
        </div>
    </div>
    <div class="col-md-6 menu_container">
        <div class="form-group">
            <label for="name">Email address (<small class="text-danger">Required</small>)</label>
            <input type="text" name="email" placeholder="Enter Email for user..!" class="form-control mt-3 mb-3">
        </div>
    </div>
    <div class="col-md-6 menu_container">
        <div class="form-group">
            <label for="name">User Role (<small class="text-danger">Required</small>) | <small>( For Example: Admin , HR etc)</small></label>
            <select type="text" name="role" placeholder="Enter Email for user..!" class="form-select mt-3 mb-3">
                <option value="">Select User Role</option>
                <option value="2">Manager</option>
                <option value="3">HR ( Human Resource )</option>
                <option value="0">Employee</option>
                <option value="1">Admin</option>
                <option value="4">Basic User</option>

            </select>
        </div>
    </div>

    <div class="col-md-12 mb-3">
            <label class="switch">
                <input type="checkbox" class="switch-input" name="active">
                <span class="slider round"></span>
            </label>&nbsp; <strong class="text-primary mt-3">
                Verified User ?
            </strong>
    </div><hr>

    <div class="col-md-12 d-flex justify-content-end ">
        <a href="{{ route('users.index') }}" class="btn btn-primary" style="margin-right: 10px">Users List</a>
        <button class="btn btn-success" type="submit">{{ $parentButton }}</button>
    </div>
</div>

        </form>
    </div>
</div>
@push('js')
<script src="{{ asset('assets/custom/users.js') }}"></script>
<script>
    let baseUrl = "{{ asset("") }}";
    let StoreMenuRoute = "{{ route('users.store') }}";
    let menuIndexUrl   = "{{ route('users.index') }}";
    let checkUserURL   = "{{ route('users.check') }}";
    let action         = "{{ $action }}";
    let userData      = <?php echo isset($user) && $user ? json_encode($user) : 0 ;?>;
</script>
@endpush
@endsection
