<form id="reportForm" target="_blank"  action="{{ route('employee.attendance.pdf') }}" method="POST">
    @csrf
    <div class="row g-2">
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Employee <small class="text-danger">*</small></label>
                <select name="employee_id" id="report_emp" class="form-control select2">
                    <option value="">-- SELECT EMPLOYEE --</option>
                        @foreach ($employees as $item )
                            <option value="{{ $item->id }}">{{ ucfirst($item->first_name) }} | ID : {{ $item->emp_uniq_id }}   </option>
                        @endforeach
                </select>
            </div>
        </div>
        <div class="col-md-4">
            <div class="form-group">
                <label for="">Month <small class="text-danger">*</small></label>
                <select name="month" id="report_month" class="form-control select2">
                    <option value="">-- SELECT MONTH --</option>
                    @for ($i = 0 ; $i < 12 ; $i++)
                    <option @if($currentDate->now()->format('F') == $currentDate->firstOfMonth()->month($i + 1 )->format('F')) selected  value="{{ $currentDate->now()->format('n') }}"  @else value="{{ $i + 1 }}" @endif>{{ $currentDate->firstOfMonth()->month($i + 1)->format('F') }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group">
                <label for="">YEAR <small class="text-danger">*</small></label>
                <select name="year" id="report_year" class="form-control select2">
                    <option value="">-- SELECT YEAR --</option>
                    @for ($i = 0 ; $i < 3 ; $i++)
                    <option value="{{ $currentYear + $i }}" @if($currentDate->now()->format('Y') == ($currentYear + $i )) selected @endif>{{ $currentYear + $i }}</option>
                    @endfor
                </select>
            </div>
        </div>

        <br><div class="col-md-12 mt-3 d-flex justify-content-end">
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Generate</button>
            </div>

        </div>
    </div>

</form>
