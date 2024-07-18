<form id="filterForm">
    <div class="row">
        <div class="col-md-4 form-group">
            <label for="">Employee Name <small class="text-danger">*</small></label>
            <select name="employee_id" class="form-control select2" data-required="required" data-name="Employee name" id="employee_id">
                <option value="">-- SELECT EMPLOYEE --</option>
                @foreach ($employees as $key => $item )
                <option value="{{ $key }}">{{ $item }}</option>
        @endforeach
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="">Loan Type </label>
            <select name="loan_type" class="form-control select2" id="loan_type">
                <option value="">-- SELECT Loan Type --</option>
                @foreach ($loan_type as $key => $item )
                <option value="{{ $key }}">{{ $item }}</option>
                 @endforeach
            </select>
        </div>
        <div class="col-md-4 form-group">
            <label for="">Date Range </label>
            <input type="date" name="date_range" placeholder="Date Range " id="date_range" class="form-control">
        </div>

        <br> <div class="col-md-12 mt-2 d-flex justify-content-end">
            <button class="btn btn-primary">Submit</button>
        </div>
    </div>
</form>
