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
        <form action="" enctype="multipart/form-data">
            @csrf
            <div class="header-title">
                <h3><strong class="text-primary">
                        Step 1 :</strong> Personal Information</h3>
                <hr>
            </div>
            <div class="row p-3">
                <div class="col-md-12">
                    <div class="form-group"><label for="">Employee Image</label>
                        <input type="file" name="image" class="form-control">
                    </div>
                </div>
                {{-- Select employee --}}
                <div class="col-md-6 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Select Employee <span class="text-danger">*</span></label>
                        <select type="text" name="user_id" class="form-select select2">
                            <option value="">-- Select Employee --</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-md-6 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">First Name <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" placeholder="First Name">
                    </div>
                </div>
                <div class="col-md-6 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Last Name</label>
                        <input type="text" name="last_name" class="form-control" placeholder="Last Name">
                    </div>
                </div>
                <div class="col-md-6 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Personal Email</label>
                        <input type="text" name="personal_email" class="form-control"
                            placeholder="example@gmail.com">
                    </div>
                </div>
                <div class="col-md-12 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Date of Birth</label>
                        <input type="date" name="date_of_birth" class="form-control">
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Country</label>
                        <select name="country" class="form-select select2">
                            <option value="">-- Select Country --</option>
                            @foreach ($country as $items)
                                <option value="{{ $items->id }}">{{ $items->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">State</label>
                        <select name="state" class="form-select  select2">
                            <option value="">-- Select Country First --</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">City</label>
                        <select name="city" class="form-select select2">
                            <option value="">-- Select State First --</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-3 mt-1 mb-3">
                    <div class="form-group">
                        <label for="">Nationality</label>
                        <select name="nationality" class="form-select select2">
                            <option value="">-- Select Nationality --</option>
                            @foreach ($nationality as $items)
                                <option value="{{ $items->name }}">{{ $items->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Religion</label>
                        <select name="religion" class="form-select select2">
                            <option value="">-- Select Religion --</option>
                            <option value="Islam">Islam</option>
                            <option value="Christianity">Christianity</option>
                            <option value="Hinduism">Hinduism</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Gender </label>
                        <select name="gender" class="form-select select2">
                            <option value="">-- Select Gender --</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Blood Group </label>
                        <select name="blood_group" class="form-select select2">
                            <option value="">-- Select Blood Group --</option>
                            <option value="A+">A +</option>
                            <option value="A-">A -</option>
                            <option value="B+">B +</option>
                            <option value="B-">B -</option>
                            <option value="O+">O +</option>
                            <option value="O-">O -</option>
                            <option value="AB+">AB +</option>
                            <option value="AB-">AB -</option>

                        </select>
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Joining Date <span class="text-danger">*</span></label>
                        <input type="date" name="joining_date" class="form-control" placeholder="+92 123456789">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <label class="switch">
                        <input type="checkbox" class="switch-input" name="martial_status">
                        <span class="slider round"></span>
                    </label>&nbsp; <strong class="text-secondary mt-5">
                        Is Married ?
                    </strong>
                </div>

                <div class="col-md-12 mb-4 no_of_child " style="display: none">

                    <div class="form-group">
                        <label for="">Number of Children</label>
                        <input type="number"name="no_of_child" placeholder="Number of Children"
                            class="form-control">

                    </div>


                </div>
                <hr>
                <div class="col-md-12">
                    <h3 class="text-primary">Contact Information</h3>
                </div>

                <div class="col-md-4 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">CNIC Number <span class="text-danger">*</span></label>
                        <input type="text" name="cnic_number" class="form-control" placeholder="530005-50343-39">
                    </div>
                </div>
                <div class="col-md-4 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Personal Contact Number <span class="text-danger">*</span></label>
                        <input type="text" name="personal_contact" class="form-control"
                            placeholder="+92 123456789">
                    </div>
                </div>

                <div class="col-md-4 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Emergency Contact Number</label>
                        <input type="text" name="emergency_contact" class="form-control"
                            placeholder="+92 123456789">
                    </div>
                </div>

                <div class="col-md-12 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Permanent Address <span class="text-dangr">*</span></label>
                        <textarea type="text" cols="4" rows="4" name="permanent_address" class="form-control"
                            placeholder="Parment address"></textarea>
                    </div>
                </div>
                <div class="col-md-12 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Present Address</label>
                        <textarea type="text" cols="4" rows="4" name="present_address" class="form-control"
                            placeholder="Parment address"></textarea>

                    </div>
                </div>

                <div class="col-md-12 g-3">
                    <div class="d-flex float-end g-3">
                        <button class="btn btn-secondary me-2">Employees List</button>
                        <button class="btn btn-primary">Next</button>
                    </div>
                </div>
        </form>



    </div>
</div>




@push('js')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2({});
            $('input[name="martial_status"]').on('change' , function(e){

                e.preventDefault();

                if($(this).prop('checked') == true){
                    $('.no_of_child').fadeIn();
                }
                else{
                    $('.no_of_child').fadeOut();
                }
            })
        })
    </script>
@endpush
@endsection
