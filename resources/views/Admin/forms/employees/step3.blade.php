<form id="step3Form" enctype="multipart/form-data" style="display: none" >

            <div class="col-md-12" id="experienceContainer">
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-end ">

                        <div class="form-group ">
                            <button class="btn btn-primary mt-3" id="addMoreExperience"><i
                                    class="fe fe-plus"></i></button>
                        </div>

                    </div>
                    <div class="col-md-4 mt-2 mb-3">
                        <div class="form-group">
                            <label for="">Company Name / Job Title <span class="text-danger">( Required
                                    )</span></label>
                            <input type="text" class="form-control" name="job_title[]"
                                placeholder="Company Name / Title">
                        </div>
                    </div>

                    <div class="col-md-4 mt-2 mb-3">
                        <div class="form-group">
                            <label for="">Start Date <span class="text-danger">( Required )</span></label>
                            <input type="date" class="form-control" name="exp_start_date[]" placeholder="Start Date">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mb-3">
                        <div class="form-group">
                            <label for="">End Date <span class="text-danger">( Required )</span></label>
                            <input type="date" class="form-control" name="exp_end_date[]" placeholder="End Date">
                        </div>
                    </div>

                    <div class="col-md-4 mt-2 mb-3">
                        <div class="form-group">
                            <label for="">Designation / Position <small class="text-secondary">( Optional
                                    )</small></label>
                            <input type="text" name="designation[]" class="form-control" placeholder="Designation">

                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mb-3">
                        <div class="form-group">
                            <label for="">Salary <small class="text-secondary">( Optional ) last salary from the
                                    previous job</small></label>
                            <input type="number" value="0" placeholder="Last Salary from the previous Job" name="salary[]"
                                class="form-control documentFile">
                        </div>
                    </div>
                    <div class="col-md-4 mt-2 mb-3">
                        <div class="form-group">
                            <label for="">Attachment <small class="text-secondary">( Optional )</small></label>
                            <input type="file" placeholder="Last Salary from the previous Job" name="attachment[]"
                                class="form-control documentFile">
                        </div>
                    </div>


                    <div class="col-md-12 mt-2 mb-3">
                        <div class="form-group">
                            <label for="">Reason of Leaving <span class="text-secondary">( Optional
                                    )</span></label>
                            <textarea cols="40" rows="5" class="form-control" name="reason_for_leaving[]"
                                placeholder="Reason for leaving previous job."></textarea>
                        </div>
                    </div>
                    <div class="col-md-12 mt-2 mb-3">
                        <div class="form-group">
                            <label for="">Job Description <span class="text-secondary">( Optional
                                    )</span></label>
                            <textarea cols="40" rows="5" class="form-control" name="description[]"
                                placeholder="Brief description or information about previous job."></textarea>
                        </div>
                    </div>


                </div>
            </div>



    <div class="col-md-12 g-3">
        <div class="d-flex float-end g-3">
            <a href="{{ route('employees.index') }}" class="btn btn-secondary me-2">Employees List</a>
            <button class="btn btn-warning text-white me-2 back_button" title="step2">Back </button>
            <button class="btn btn-primary step_3_next" title="Submit">Submit</button>
        </div>
    </div>
</form>
