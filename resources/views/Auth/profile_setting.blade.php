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
                                <img id="blah" class="avatar"
                                    src="{{ Auth::user()->image != null ? asset('images/UsersImages/' . Auth::user()->image) : asset('assets/img/profiles/avatar-07.jpg') }}"
                                    alt="profile-img">
                            </div>
                        </div>
                        <form id="formAccountSettings" method="POST"
                            action="{{ route('users.store', ['id' => $user->id, 'type' => 'profile']) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="img-upload">
                                <label class="btn btn-primary">
                                    Upload new picture <input type="file" name="image">
                                </label>

                                <p class="mt-1">Profile Image Should be minimum 152 * 152 Supported File format
                                    JPG,PNG,SVG</p>
                            </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-title">
                            <h5>General Information</h5>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="input-block mb-3">
                            <label>User Name <small class="text-danger">(*)</small></label>
                            <input type="text" value="{{ $user->username ?? '' }}" name="username" class="form-control"
                                placeholder="Enter User Name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="input-block mb-3">
                            <label>Full Name <small class="text-danger">(*)</small></label>
                            <input type="text" value="{{ $user->name ?? '' }}" name="name" class="form-control"
                                placeholder="Enter Full Name">
                        </div>
                    </div>
                    <div class="col-lg-12 col-12">
                        <div class="input-block mb-3">
                            <label>Email <small class="text-danger">(*)</small></label>
                            <input type="text" value="{{ $user->email ?? '' }}" name="email" class="form-control"
                                placeholder="Enter Email Address">
                        </div>
                    </div><hr>
                    <div class="col-lg-12">
                        <div class="form-title">
                            <h5>Bank Account Information</h5>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <input type="hidden" name="id" value="{{ $user->employees->id ?? "" }}" id="id">
                        <div class="input-block mb-3">
                            <label>Account Holder Name <small class="text-danger">(*)</small></label>
                            <input type="text" value="{{ $user->employees->bank_details->account_holder_name ?? '' }}" name="username" class="form-control"
                                placeholder="Enter User Name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="input-block mb-3">
                            <label>Bank Name <small class="text-danger">(*)</small></label>
                            <input type="text" value="{{ $user->employees->bank_details->name ?? '' }}" name="name" class="form-control"
                                placeholder="Enter Bank Name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="input-block mb-3">
                            <label>Branch Name <small class="text-danger">(*)</small></label>
                            <input type="text" value="{{ $user->employees->bank_details->branch_name ?? '' }}" name="name" class="form-control"
                                placeholder="Enter Branch Name">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="input-block mb-3">
                            <label>Account Number <small class="text-danger">(*)</small></label>
                            <input type="text" value="{{ $user->employees->bank_details->account_number ?? '' }}" name="name" class="form-control"
                                placeholder="Enter Account Number">
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="input-block mb-3">
                            <label>IBAN Number</label>
                            <input type="text" value="{{ $user->employees->bank_details->iban ?? '' }}" name="email" class="form-control"
                                placeholder="Enter IBAN Number">
                        </div>
                    </div>


                    <div class="col-lg-12">
                        <div class="btn-path text-end">
                            <a href="{{ route('auth.forget.password') }}" class="btn  text-white btn-warning shadow">Reset
                                Password</a>
                            <button type="submit" class="btn btn-primary shadow">Save Changes</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
