@php
$currentDate = \Carbon\Carbon::now();
$currentYear = $currentDate->year;
@endphp
<form action="" >

    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="department">Department</label>
                <select name="department" class="form-select select2" id="department">
                    <option value="">-- Select Department --</option>
                    @forelse ($departments as $dept )
                    <option value="{{ $dept->id }}">{{ $dept->name }} </option>
                    @empty
                        <option value="">No Departments </option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="employee">Employee</label>
                <select name="employee" class="form-select select2" id="employee">
                    <option value="">-- Select Employee --</option>
                    @forelse ($employees as $emp )
                    <option value="{{ $emp->id }}">{{ $emp->first_name }} {{  $emp->last_name }}</option>
                    @empty
                        <option value="">No Employess </option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="form-group">
                <label for="date">Applied Date</label>
                <input type="date" name="date" class="form-control" id="date" >
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="form-group">
                <label for="month">Month</label>
                <select name="month" class="form-select select2" id="month">
                    <option value="">-- Select Month --</option>
                    @for ($i = 0 ; $i < 12 ; $i++)
                    <option value="{{ $i + 1 }}">{{ $currentDate->firstOfMonth()->month($i + 1)->format('F') }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-md-4 mt-3">
            <div class="form-group">
                <label for="year">Year</label>
                <select name="year" class="form-select select2" id="year">
                    <option value="">-- Select Year --</option>
                    @for ($i = 0 ; $i < 3 ; $i++)
                    <option value="{{ $currentYear + $i }}">{{ $currentYear + $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="leave_types">Leave Type</label>
                <select name="leave_types" class="form-select select2" id="leave_types">
                    <option value="">-- Select Leave Type --</option>
                    <option value="Annual Leaves">Annual Leaves</option>
                    <option value="Sick Leaves">Sick Leaves</option>
                </select>
            </div>
        </div>
        <div class="col-md-6 mt-3">
            <div class="form-group">
                <label for="status">Status</label>
                <select name="status" class="form-select select2" id="status">
                    <option value="">-- Select Status --</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-3 mb-0">
        <button type="submit" class="btn btn-primary" id="searchBtn">Search</button>
    </div>

</form>
