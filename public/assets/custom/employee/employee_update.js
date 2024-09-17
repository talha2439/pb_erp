function  editQualification(){
    $.ajax({
        url: qualificationEdit + '/' + $('input[name="emp_id"]').val(),
        type: "GET",
        success: function (response) {
            let qualificationData = "";
            if (response.qualification.length > 0) {
                $(response.qualification).each(function (index, value) {
                    let actionButton = `<div class="form-group "><button class="btn btn-primary mt-3" id="addMoreQualification"><i class="fe fe-plus"></i></button></div>`;
                    if (index >= 1) {
                        actionButton = `<div class="form-group "><button class="btn btn-danger mt-3 removeBtn" data-id="${value.id}"><i class="fe fe-trash"></i></button></div>`;
                    }
                    qualificationData += ` <div class="row p-2">
                <div class="col-md-12" id="qualificationContainer">
                    <div class="row">
                        <div class="col-md-12 d-flex justify-content-end ">

                               ${actionButton}
                        </div>
                        <input type="hidden" name="qualification_id[]" value="${value.id}">
                        <input type="hidden" name="deleted_qualification[]" value="${value.id}">
                        <div class="col-md-3 mt-2 mb-3">
                            <div class="form-group">
                                <label for="">Institute Name <span class="text-danger">( Required )</span></label>
                               <input type="text" class="form-control" name="institute[]" value="${value.institute}" placeholder="Institute name">
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 mb-3">
                            <div class="form-group">
                                <label for="">Qualification <small class="text-danger" >( Required )</small></label>
                                <input type="text" name="qualification[]" value="${value.qualification}" class="form-control" placeholder="Qualification">
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 mb-3">
                            <div class="form-group">
                                <label for="">Start Date <span class="text-danger">( Required )</span></label>
                               <input type="date" class="form-control" name="start_date[]" value="${value.start_date}"  placeholder="Start Date">
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 mb-3">
                            <div class="form-group">
                                <label for="">End Date <span class="text-danger">( Required )</span></label>
                               <input type="date" class="form-control" name="end_date[]" value="${value.end_date}" placeholder="End Date">
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 mb-3">
                            <div class="form-group">
                                <label for="">GPA <span class="text-secondary">( Optional )</span></label>
                               <input type="number" class="form-control" name="gpa[]" value="${value.gpa}" placeholder="GPA">
                            </div>
                        </div>
                        <div class="col-md-3 mt-2 mb-3">
                            <div class="form-group">
                                <label for="">Percentage <span class="text-secondary">( Optional )</span></label>
                               <input type="number" class="form-control" name="percentage[]" value="${value.percentage}"  placeholder="Percentage">
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
               `
                });

                $(".step_2_formContainer").html(qualificationData);
            }

        }
    });
}
function editExperience(){
    $.ajax({
        url: experienceEdit + '/' + $('input[name="emp_id"]').val(),
        type: "GET",
        success: function (response) {
            let experienceData = "";
            if (response.experience.length > 0) {
                $(response.experience).each(function (index, value) {
                    let actionButton = `<div class="form-group "><button class="btn btn-primary mt-3" id="addMoreExperience"><i class="fe fe-plus"></i></button></div>`;
                    if (index >= 1) {
                        actionButton = `<div class="form-group "><button class="btn btn-danger mt-3 removeExp" data-id="${value.id}" ><i class="fe fe-trash"></i></button></div>`;
                    }
                    experienceData += `  <div class="row p-3">
                        <input  type="hidden" value="${value.id}" name="exp_id[]" />
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-end ">

                                        ${actionButton}
                                </div>
                                <div class="col-md-4 mt-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Company Name / Job Title <span class="text-danger">( Required
                                                )</span></label>
                                        <input type="text" class="form-control" value="${value.job_title}" name="job_title[]"
                                            placeholder="Company Name / Title">
                                    </div>
                                </div>

                                <div class="col-md-4 mt-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Start Date <span class="text-danger">( Required )</span></label>
                                        <input type="date" class="form-control" value="${value.start_date}" name="exp_start_date[]" placeholder="Start Date">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2 mb-3">
                                    <div class="form-group">
                                        <label for="">End Date <span class="text-danger">( Required )</span></label>
                                        <input type="date" class="form-control" value="${value.end_date}" name="exp_end_date[]" placeholder="End Date">
                                    </div>
                                </div>

                                <div class="col-md-4 mt-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Designation / Position <small class="text-secondary">( Optional
                                                )</small></label>
                                        <input type="text" name="designation[]" value="${value.designation}" class="form-control" placeholder="Designation">

                                    </div>
                                </div>
                                <div class="col-md-4 mt-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Salary <small class="text-secondary">( Optional ) last salary from the
                                                previous job</small></label>
                                        <input type="number" value="${value.salary}" placeholder="Last Salary from the previous Job" name="salary[]"
                                            class="form-control documentFile">
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Attachment <small class="text-secondary">( Optional )</small></label>
                                        <input type="file"   placeholder="Last Salary from the previous Job" name="attachment[]"
                                            class="form-control documentFile">
                                    </div>
                                </div>


                                <div class="col-md-12 mt-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Reason of Leaving <span class="text-secondary">( Optional
                                                )</span></label>
                                        <textarea cols="40" value="${value.reason_for_leaving}" rows="5" class="form-control" name="reason_for_leaving[]"
                                            placeholder="Reason for leaving previous job.">${value.reason_for_leaving}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12 mt-2 mb-3">
                                    <div class="form-group">
                                        <label for="">Job Description <span class="text-secondary">( Optional
                                                )</span></label>
                                        <textarea cols="40" value="${value.description}" rows="5" class="form-control" name="description[]"
                                            placeholder="Brief description or information about previous job.">${value.description}</textarea>
                                    </div>
                                </div>


                            </div>
                        </div>


                   `
                });

                $("#experienceContainer").html(experienceData);
            }

        }
    });
}
