$(document).ready(function () {
    let expContainer = $(document).find("#experienceContainer");
    var totalAdded = 0;
    $(document).on("click", "#addMoreExperience", function (e) {
        e.preventDefault();
        if(totalAdded < 3){
            let appenddata = `  <div class="row">
            <div class="col-md-12 d-flex justify-content-end ">

                    <div class="form-group ">
                     <button class="btn btn-danger removeExp mt-3" ><i class="fe fe-trash"></i></button>
                    </div>
                    <input  type="hidden" value="" name="exp_id[]" />

            </div>
            <div class="col-md-4 mt-2 mb-3">
                <div class="form-group">
                    <label for="">Company Name / Job Title <span class="text-danger">( Required )</span></label>
                   <input type="text" class="form-control" name="job_title[]" placeholder="Company Name / Title">
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
                <label for="">Designation / Position <small class="text-secondary" >( Optional )</small></label>
                <input type="text" name="designation[]" class="form-control" placeholder="Designation">

            </div>
        </div>
        <div class="col-md-4 mt-2 mb-3">
            <div class="form-group">
                <label for="">Salary  <small class="text-secondary">( Optional ) last salary from the previous job</small></label>
                <input type="number" value="0" placeholder="Last Salary from the previous Job" name="salary[]" class="form-control documentFile" >
            </div>
        </div>
        <div class="col-md-4 mt-2 mb-3">
            <div class="form-group">
                <label for="">Attachment  <small class="text-secondary">( Optional )</small></label>
                <input type="file" name="attachment[]" class="form-control documentFile" >
            </div>
        </div>

            <div class="col-md-12 mt-2 mb-3">
                <div class="form-group">
                    <label for="">Reason of Leaving <span class="text-secondary">( Optional )</span></label>
                   <textarea  cols="40"  rows="5" class="form-control" name="reason_for_leaving[]" placeholder="Reason for leaving previous job."></textarea>
                </div>
            </div>
            <div class="col-md-12 mt-2 mb-3">
                <div class="form-group">
                    <label for="">Job Description <span class="text-secondary">( Optional )</span></label>
                   <textarea  cols="40"  rows="5" class="form-control" name="description[]" placeholder="Brief description or information about previous job."></textarea>
                </div>
            </div>


        </div>`;
            $(expContainer).append(appenddata)
            totalAdded++;
        }

    });
    $(document).on('click', '.removeExp', function (e) {
        e.preventDefault();
        $(this).closest('.row').remove();
        totalAdded --;
        let id = $(this).data('id');
        if (id != undefined || id == '') {
            let confirm = window.confirm("Do you want to remove this?");
            if (confirm) {
                $.ajax({
                    url: deleteExperience + '/' + id,
                    type: "GET",
                    success: function (res) {
                        if (res.success) {
                            toastr['success']("Experience deleted successfully");
                            return false;
                        }
                        else if (res.unauthorized) {
                            toastr['error']("You are not authorized to delete this..!");
                            return false;
                        }
                        else if (res.error) {

                            toastr['error'](res.error);
                            return false;
                        }
                        else {
                            toastr['error']("Something went wrong..!");
                            return false;
                        }
                    }, error: function (xhr, status, error) {
                        e.preventDefault();
                        toastr["error"](xhr.responseJSON.message);
                        return false;
                    }
                })
            }
        }
    });
    // Validation For Form
    let expForm = $("#step3Form");
    let designation = $('input[name="designation[]"]');
    let salary = $('input[name="salary[]"]');
    let attachments = $('input[name="attachment[]"]');
    let description = $('textarea[name="description[]"]');
    let reasonforleaving = $('textarea[name="reason_for_leaving[]"]');
    let emp_id = $('input[name="emp_id"]');
    let csrf_token = $('input[name="csrf_token"]');
    let submitBtn = $('.step_3_next');
    $(submitBtn).on('click', function (e) {
        isValid = true;
        let jobTitle = $(document).find('input[name="job_title[]"]').map(function () {
            return $(this).val();
        }).get();
        if (jobTitle.some(jobTitle => jobTitle === "")) {
            e.preventDefault();
            toastr['error']("Job title or Company name is required");
            isValid = false;
            return false;
        }
        let start_date = $(document).find('input[name="exp_start_date[]"]').map(function () {
            return $(this).val();
        }).get();

        if (start_date.some(start_date => start_date === "")) {
            toastr['error']("Start Date  field is required..!");
            isValid = false;
            return false;
        }
        let end_date = $(document).find('input[name="exp_end_date[]"]').map(function () {
            return $(this).val();
        }).get();

        if (end_date.some(end_date => end_date === "")) {
            toastr['error']("End Date field is required..!");
            isValid = false;
            return false;
        }
        $(document).find('input[name="attachment[]"]').each(function (index, input) {
            let attachments = $(input).val();

            if (attachments !== "") {
                e.preventDefault();
                let ext = attachments.split('.').pop().toLowerCase();
                if ($.inArray(ext, ['pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx']) === -1) {
                    e.preventDefault();
                    toastr['error']("Only PDF, DOCX, DOC, PNG, JPG, and JPEG files are allowed..!");
                    isValid = false;
                    return false; // Stop further iteration
                }

                let fileSize = input.files[0].size;
                if (fileSize > 15 * (1024 * 1024)) {
                    e.preventDefault();
                    toastr["error"]("Attachment file size should be less than 15MB");
                    isValid = false;
                    return false; // Stop further iteration
                }


            }
        }
        );
        for (let i = 0; i < start_date.length; i++) {
            let start_dates = start_date[i];
            let end_dates = end_date[i];
            if (start_dates !== "" && end_dates !== "") {
                let start_date_obj = new Date(start_dates);
                let end_date_obj = new Date(end_dates);
                if (end_date_obj <= start_date_obj) {
                    toastr['error']("End Date of Experience should be after Start Date..!");
                    isValid = false;
                    return false;
                }
            }
        }

        if (isValid) {
            e.preventDefault();
            let formData = new FormData();
            let attachments = [];
            $(document).find('input[name="attachment[]"]').each(function (index, value) {
                let ifiles = value.files;
                for (let i = 0; i < ifiles.length; i++) {
                    let imageFile = ifiles[i];
                    attachments.push(imageFile);
                }
            });
            // Appending all attachments to the form
            for (let i = 0; i < attachments.length; i++) {
                formData.append('attachment[]', attachments[i]);
            }
            formData.append('data', expForm.serialize());
            formData.append('employee_id', $(emp_id).val());
            $.ajax({
                url: storeExperiencePost,
                data: formData,
                type: "POST",
                processData: false,
                contentType: false,
                headers: {
                    "X-CSRF-TOKEN": csrf_token.val()
                },
                success: function (res) {
                    if (res.success) {
                        e.preventDefault();
                        toastr.success("Employee Information has been saved successfully");

                        setTimeout(() => {
                            window.location.href = employeesListUrl;
                        }, 1000)

                    }
                    else if (res.unauthorized) {
                        e.preventDefault();
                        toastr.error("Failed to save Information , you are not allowed to save information about Employees");
                        return false;
                    }
                    else if (res.error) {
                        e.preventDefault();
                        toastr["error"](res.error);
                        return false;
                    }
                    else {
                        e.preventDefault();
                        toastr["error"]("An error occurred while saving experience information for employee");
                        return false;
                    }
                },
                error: function (xhr, status, error) {
                    e.preventDefault();
                    toastr["error"](xhr.responseJSON.message);
                    return false;
                }
            })
        }


    });


})
