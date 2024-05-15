@php
$currentDate = \Carbon\Carbon::now();
$currentYear = $currentDate->year;
@endphp
<form action="" >

    <div class="row">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Department</label>
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
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Employee</label>
                <select name="employee" class="form-select select2" id="employee">
                    <option value="">-- Select Employee --</option>
                    @forelse ($employees as $emp )
                    <option value="{{ $emp->users->id }}">{{ $emp->first_name }} {{  $emp->last_name }}</option>
                    @empty
                        <option value="">No Employess </option>
                    @endforelse
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Date</label>
                <input type="text" name="date" class="form-control datepicker" id="" >
            </div>
        </div>
        <div class="col-md-4 mt-3">
            <div class="form-group">
                <label for="">Month</label>
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
                <label for="">Year</label>
                <select name="year" class="form-select select2" id="year">
                    <option value="">-- Select Year --</option>
                    @for ($i = 0 ; $i < 3 ; $i++)
                    <option value="{{ $currentYear + $i }}">{{ $currentYear + $i }}</option>
                    @endfor
                </select>
            </div>
        </div>
    </div>
    <div class="d-flex justify-content-end mt-3 mb-0">
        <button type="submit" class="btn btn-primary" id="searchBtn">Search</button>
    </div>

</form>
