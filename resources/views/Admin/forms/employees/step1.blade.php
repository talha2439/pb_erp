
<form id="step1" enctype="multipart/form-data"
>
    @csrf
   
    <div class="row p-3">
        <div class="col-md-12">
            <div class="form-group"><label for="">Employee Image <small class="text-secondary">( Optional )</small></label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>
        {{-- Select employee --}}
        <div class="col-md-6 mt-2 mb-3">
            <div class="form-group">
                <label for="">Select Employee <span class="text-danger">( Required )</span></label>
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
                <label for="">First Name <span class="text-danger">( Required )</span></label>
                <input type="text" name="first_name" class="form-control" placeholder="First Name">
            </div>
        </div>
        <div class="col-md-6 mt-2 mb-3">
            <div class="form-group">
                <label for="">Last Name <small class="text-secondary">( Optional )</small></label>
                <input type="text" name="last_name" class="form-control" placeholder="Last Name">
            </div>
        </div>
        <div class="col-md-6 mt-2 mb-3">
            <div class="form-group">
                <label for="">Personal Email <span class="text-danger"> ( Required )</span></label>
                <input type="text" name="personal_email" class="form-control" placeholder="example@gmail.com">
            </div>
        </div>
        <div class="col-md-12 mt-2 mb-3">
            <div class="form-group">
                <label for="">Date of Birth <small class="text-danger">( Required )</small></label>
                <input type="date" name="date_of_birth" class="form-control">
            </div>
        </div>
        <div class="col-md-4 mt-2 mb-3">
            <div class="form-group">
                <label for="">Department <small class="text-danger">( Required )</small></label>
                <select name="department" class="form-select select2">
                    <option value="">-- Select Department --</option>
                    @foreach ($department as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4 mt-2 mb-3">
            <div class="form-group">
                <label for="">Designation <small class="text-danger">( Required )</small></label>
                <select name="designation" class="form-select select2">
                    <option value="">-- Select Department First --</option>
                </select>
            </div>
        </div>
        <div class="col-md-4 mt-2 mb-3">
            <div class="form-group">
                <label for="">Shift and Timing <small class="text-secondary">( Optional )</small></label>
                <select name="shift" class="form-select select2">
                    <option value="">-- Select Designation First --</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 mt-2 mb-3">
            <div class="form-group">
                <label for="">Country <small class="text-secondary">( Optional )</small></label>
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
                <label for="">State <small class="text-secondary">( Optional )</small></label>
                <select name="state" class="form-select  select2">
                    <option value="">-- Select Country First --</option>
                </select>
            </div>
        </div>
        <div class="col-md-3 mt-2 mb-3">
            <div class="form-group">
                <label for="">City <small class="text-secondary">( Optional )</small></label>
                <select name="city" class="form-select select2">
                    <option value="">-- Select State First --</option>
                </select>
            </div>
        </div>

        <div class="col-md-3 mt-1 mb-3">
            <div class="form-group">
                <label for="">Nationality <small class="text-secondary">( Optional )</small></label>
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
                <label for="">Religion <small class="text-secondary">( Optional )</small></label>
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
                <label for="">Gender <small class="text-danger">( Required )</small></label>
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
                <label for="">Blood Group <small class="text-secondary">( Optional )</small> </label>
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
                <label for="">Joining Date <span class="text-danger">( Required )</span></label>
                <input type="date" name="joining_date" class="form-control" placeholder="+92 123456789">
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <label class="switch">
                <input type="checkbox" class="switch-input" name="martial_status">
                <span class="slider round"></span>
            </label>&nbsp; <strong class="text-secondary mt-5">
                Is Married ? <small class="text-secondary">( Optional )</small>
            </strong>
        </div>

        <div class="col-md-12 mb-4 no_of_child " style="display: none">

            <div class="form-group">
                <label for="">Number of Children</label>
                <input type="number"name="no_of_child" placeholder="Number of Children" class="form-control">

            </div>


        </div>
        <hr>
        <div class="col-md-12">
            <h3 class="text-primary">Contact Information</h3>
        </div>

        <div class="col-md-4 mt-2 mb-3">
            <div class="form-group">
                <label for="">CNIC Number <span class="text-secondary unrequired" >( Optional )</span><span class="text-danger requiredCnic" style="display: none">( Required )</span></label>
                <input type="text" name="cnic_number" class="form-control" placeholder="00000-0000000-0">
            </div>
        </div>
        <div class="col-md-4 mt-2 mb-3">
            <div class="form-group">
                <label for="">Personal Contact  <span class="text-danger">( Required )</span></label>
                <input type="text" name="personal_contact" class="form-control" placeholder="( +92 ) 0000000000">
            </div>
        </div>

        <div class="col-md-4 mt-2 mb-3">
            <div class="form-group">
                <label for="">Emergency Contact  <small class="text-secondary">( Optional )</small></label>
                <input type="text" name="emergency_contact" class="form-control"
                    placeholder="( +92 ) 0000000000">
            </div>
        </div>

        <div class="col-md-12 mt-2 mb-3">
            <div class="form-group">
                <label for="">Permanent Address <span class="text-danger">( Required )</span></label>
                <textarea type="text" cols="4" rows="4" name="permanent_address" class="form-control"
                    placeholder="Parment address"></textarea>
            </div>
        </div>
        <div class="col-md-12 mb-3">
            <label class="switch">
                <input type="checkbox" class="switch-input same_permanent">
                <span class="slider round"></span>
            </label>&nbsp; <strong class="text-secondary mt-5">
                Same as Permanent Address ? <small class="text-secondary">( Optional )</small>
            </strong>
        </div>
        <div class="col-md-12 mt-2 mb-3">
            <div class="form-group">
                <label for="">Present Address</label>
                <textarea type="text" cols="4" rows="4" name="present_address" class="form-control"
                 ></textarea>

            </div>
        </div>

        <div class="col-md-12 g-3">
            <div class="d-flex float-end g-3">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary me-2">Employees List</a>
                <button class="btn btn-success me-2 step_1_next" title="Save" id="step1save">Save </button>
                <button class="btn btn-primary step_1_next" title="Save and Next">Save & Next</button>
            </div>
        </div>
</form>
