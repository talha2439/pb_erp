@php
$currentDate = \Carbon\Carbon::now();
$currentYear = $currentDate->year;
@endphp
<form action="" id="filterFrom">
    @csrf
    <div class="row">
        <div class="col-md-3 form-group">
            <label for="">Department</label>
            <select name="department" id="department" class="form-control select2">
                <option value="">-- SELECT DEPARTMENT --</option>
                @foreach ($departments as $key => $value )
                    <option value="{{ $key }}">{{ $value }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3 form-group">
            <label for="">Employee</label>
            <select name="employee" id="employee" class="form-control select2">
                <option value="">-- SELECT EMPLOYEE --</option>
                @foreach ($employees as $index => $emp )
                <option value="{{ $index }}">{{ $emp }}</option>
            @endforeach
            </select>
        </div>
        <div class="col-md-3 form-group">
            <label for="">Month</label>
            <select name="month" id="month" class="form-control select2">
                <option value="">-- SELECT MONTH --</option>
                @for ($i = 0 ; $i < 12 ; $i++)
                <option value="{{ $i + 1 }}">{{ $currentDate->firstOfMonth()->month($i + 1)->format('F') }}</option>
                @endfor
            </select>
        </div>
        <div class="col-md-3 form-group">
            <label for="">Year</label>
            <select name="year" id="year" class="form-control select2">
                <option value="">-- SELECT YEAR --</option>
                @for ($i = 0 ; $i < 3 ; $i++)
                <option value="{{ $currentYear + $i }}">{{ $currentYear + $i }}</option>
                @endfor
            </select>
        </div>
        <div class="mt-3 col-md-12 d-flex justify-content-end">
            <button type="submit" id="searchBtn" class="btn btn-primary">Search</button>
        </div>

    </div>
</form>
