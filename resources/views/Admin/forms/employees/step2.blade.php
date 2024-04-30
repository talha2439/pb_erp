
<form id="step2Form" enctype="multipart/form-data" style="display: none" >
    <div class="step_2_formContainer">
    <div class="row  p-3">

        <div class="col-md-12" id="qualificationContainer">
            <div class="row">
                <div class="col-md-12 d-flex justify-content-end ">

                        <div class="form-group ">
                         <button class="btn btn-primary mt-3" id="addMoreQualification"><i class="fe fe-plus"></i></button>
                        </div>

                </div>

                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Institute Name <span class="text-danger">( Required )</span></label>
                       <input type="text" class="form-control" name="institute[]" placeholder="Institute name">
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Qualification <small class="text-danger" >( Required )</small></label>
                        <input type="text" name="qualification[]" class="form-control" placeholder="Qualification">
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Start Date <span class="text-danger">( Required )</span></label>
                       <input type="date" class="form-control" name="start_date[]" placeholder="Start Date">
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">End Date <span class="text-danger">( Required )</span></label>
                       <input type="date" class="form-control" name="end_date[]" placeholder="End Date">
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">GPA <span class="text-secondary">( Optional )</span></label>
                       <input type="number" class="form-control" name="gpa[]" placeholder="GPA">
                    </div>
                </div>
                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Percentage <span class="text-secondary">( Optional )</span></label>
                       <input type="number" class="form-control" name="percentage[]" placeholder="Percentage">
                    </div>
                </div>


                <div class="col-md-3 mt-2 mb-3">
                    <div class="form-group">
                        <label for="">Documents <small class="text-secondary">( Optional )</small></label>
                        <input type="file" name="document[]" class="form-control documentFile" >
                    </div>
                </div>

            </div>
        </div>












        </div>
    </div>
        <div class="col-md-12 g-3">
            <div class="d-flex float-end g-3">
                <a href="{{ route('employees.index') }}" class="btn btn-secondary me-2">Employees List</a>
                <button class="btn btn-warning text-white me-2 back_button" title="step1"  data-id="{{ $employeeId ?? "" }}" >Back </button>
                <button class="btn btn-success me-2 step_2_next" title="Save" >Save </button>
                <button class="btn btn-primary step_2_next" title="Save and Next">Save & Next</button>
            </div>
        </div>
</form>

