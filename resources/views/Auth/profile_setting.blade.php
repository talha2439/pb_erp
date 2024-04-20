@extends('Admin.layout')
@section('title')
Account Setting
@endsection
@section('content')
<div class="col-xl-12 col-md-12">
    <div class="card">
    <div class="card-body w-100">
    <div class="content-page-header">
    <h5 class="setting-menu">Account Settings</h5>
    </div>
    <div class="row">
    <div class="profile-picture">
    <div class="upload-profile me-2">
    <div class="profile-img">
    <img id="blah" class="avatar" src="{{ Auth::user()->image != null ? asset('assets\images\userimages' . Auth::user()->image)  : asset('assets/img/profiles/avatar-07.jpg')}}" alt="profile-img">
    </div>
    </div>
    <form id="formAccountSettings" method="POST" action="{{ route('users.store',['id' =>  $user->id , 'type' => 'profile'] ) }}" enctype="multipart/form-data">
        @csrf
    <div class="img-upload">
    <label class="btn btn-primary">
    Upload new picture <input type="file">
    </label>

    <p class="mt-1">Profile Image Should be minimum 152 * 152 Supported File format JPG,PNG,SVG</p>
    </div>
    </div>
    <div class="col-lg-12">
    <div class="form-title">
    <h5>General Information</h5>
    </div>
    </div>
    <div class="col-lg-6 col-12">
    <div class="input-block mb-3">
    <label>User Name</label>
    <input type="text" value="{{ $user->username ?? "" }}" class="form-control" placeholder="Enter User Name">
    </div>
    </div>
    <div class="col-lg-6 col-12">
    <div class="input-block mb-3">
    <label>Full Name</label>
    <input type="text" value="{{ $user->name ?? "" }}" class="form-control" placeholder="Enter Full Name">
    </div>
    </div>
    <div class="col-lg-12 col-12">
    <div class="input-block mb-3">
    <label>Email</label>
    <input type="text" value="{{ $user->email ?? "" }}" class="form-control" placeholder="Enter Email Address">
    </div>
    </div>


    <div class="col-lg-12">
    <div class="btn-path text-end">
    <a href="{{ route('auth.forget.password') }}" class="btn  text-white btn-warning shadow">Reset Password</a>
    <button type="submit" class="btn btn-primary shadow">Save Changes</button>
    </div>
    </form>
    </div>
    </div>
    </div>
    </div>
    </div>
@endsection
