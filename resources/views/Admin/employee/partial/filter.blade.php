
<form id="filterEmployee" >

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Employee</label>
                <select name="employee" class="form-select select2" id="employee">
                    <option value="">-- Select Employee --</option>
                    @forelse ($employees as $emp )
                    <option value="{{ $emp->id }}">{{ $emp->first_name }} {{  $emp->last_name }}</option>
                    @empty
                        <option value="">No Employees </option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Department</label>
                <select name="department" class="form-select select2" id="department">
                    <option value="">-- Select Department --</option>
                    @forelse ($departments as $key =>$dept )
                    <option value="{{ $key }}">{{ $dept }} </option>
                    @empty
                        <option value="">No Departments </option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Designation</label>
                <select name="designation" class="form-select select2" id="designation">
                    <option value="">-- Select Designation --</option>
                    @forelse ($designations as $key =>  $design )
                    <option value="{{  $key  }}">{{ $design }} </option>
                    @empty
                        <option value="">No Designations </option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-md-4 mt-2">
            <div class="form-group">
                <label for="">Shifts</label>
                <select name="shift" class="form-select select2" id="shifts">
                    <option value="">-- Select Shifts --</option>
                    @forelse ($shifts as $key =>  $shift )
                    <option value="{{ $key }}">{{ $shift }} </option>
                    @empty
                        <option value="">No Shifts </option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-md-4  mt-2">
            <div class="form-group">
                <label for="">Status</label>
                <select name="status" class="form-select select2" id="status">
                    <option value="">-- Select Status --</option>
                    <option value="prohibition">Prohibition</option>
                    <option value="internship">Intership</option>
                    <option value="parmanent">Parmanent</option>
                    <option value="resigned">Resigned</option>
                </select>
            </div>
        </div>


    </div>
    <div class="d-flex justify-content-end mt-3 mb-0">
        <button type="submit" class="btn btn-primary" id="searchBtn">Search</button>
    </div>

</form>
