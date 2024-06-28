$(document).ready(function () {

    let formStep2 = $("#step2Form");
    let addMoreBtn = $("#addMoreQualification")
    let qualificationContainer = $("#qualificationContainer");
    let save2Button = $(".step_2_next");
    let emp_id = $("input[name='emp_id']");
    let csrfToken = $('input[name="csrf_token"]');
    var totalAdded = 0;
    $(document).on('click', '#addMoreQualification', function (e) {
        e.preventDefault();
        if (totalAdded < 3) {
            let qualificationAppend = `<div class="row p-2">
            <hr><div class="col-md-12 d-flex justify-content-end ">

                    <div class="form-group ">
                     <button class="btn btn-danger mt-3 removeBtn" ><i class="fe fe-trash"></i></button>
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
            `;
            $(".step_2_formContainer").append(qualificationAppend);
            totalAdded++;

        }

    });
    // Removing the Row
    $(document).on('click', '.removeBtn', function (e) {
        e.preventDefault();
        totalAdded--;

        let id = $(this).data('id');
        if (id != undefined || id == '') {
            Swal.fire({
                title: "Are you sure?",
                text: "You sure you want to remove it ? ",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#6C05A8',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((res) => {
                if (res.isConfirmed) {
                    $(this).closest('.row').remove();
                    $.ajax({
                        url: deleteQualification + '/' + id,
                        type: "GET",
                        success: function (res) {
                            if (res.success) {

                                toastr['success']("Qualification deleted successfully");
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
            })

        }
        else {
            $(this).closest('.row').remove();
        }
    })
    // Adding Data and Validations
    $(save2Button).on('click', function (e) {

        e.preventDefault();
        let saveButton = $(this);
        let isValid = true;
        let institute = $(document).find('input[name="institute[]"]').map(function () {
            return $(this).val();
        }).get();

        if (institute.some(institute => institute === "")) {
            toastr['error']("Institute is required..!");
            isValid = false;
            return false;
        }
        let qualification = $(document).find('input[name="qualification[]"]').map(function () {
            return $(this).val();
        }).get();

        if (qualification.some(qualification => qualification === "")) {
            toastr['error']("Qualification field is required..!");
            isValid = false;
            return false;
        }
        let start_date = $(document).find('input[name="start_date[]"]').map(function () {
            return $(this).val();
        }).get();

        if (start_date.some(start_date => start_date === "")) {
            toastr['error']("Start Date of Qualification field is required..!");
            isValid = false;
            return false;
        }
        let end_date = $(document).find('input[name="end_date[]"]').map(function () {
            return $(this).val();
        }).get();

        if (end_date.some(end_date => end_date === "")) {
            toastr['error']("End Date of Qualification field is required..!");
            isValid = false;
            return false;
        }
        $('input[name="document[]"]').each(function (index, input) {
            let documents = $(input).val();

            if (documents !== "") {
                let ext = documents.split('.').pop().toLowerCase();
                if ($.inArray(ext, ['pdf', 'png', 'jpg', 'jpeg', 'doc', 'docx']) === -1) {
                    toastr['error']("Only PDF, DOCX, DOC, PNG, JPG, and JPEG files are allowed..!");
                    isValid = false;
                    return false;
                }

                let fileSize = input.files[0].size;
                if (fileSize > 15 * (1024 * 1024)) {
                    e.preventDefault();
                    toastr["error"]("Document file size should be less than 15MB");
                    isValid = false;
                    return false;
                }

                if (!isValid) {
                    return false;
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
                    toastr['error']("End Date of Qualification should be after Start Date..!");
                    isValid = false;
                    return false;
                }
            }
        }
        if (isValid) {
            e.preventDefault();
            $(document).find('.saveBtn').text("Please wait...")
            $(document).find('.saveBtn').attr("disabled", true)
            let formData = new FormData();
            let imageFiles = [];
            $("input[name='document[]']").each(function (index, element) {
                let ifiles = element.files;
                for (let i = 0; i < ifiles.length; i++) {
                    let imageFile = ifiles[i];
                    imageFiles.push(imageFile);
                }
            })

            for (let i = 0; i < imageFiles.length; i++) {
                formData.append('document[]', imageFiles[i]);
            }
            formData.append('data', formStep2.serialize());
            formData.append('employee_id', $(emp_id).val());
            $.ajax({
                url: qualificationPost + "/" + emp_id.val(),
                'type': 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.val()
                },
                success: function (response) {
                    if (response.success) {
                        e.preventDefault();
                        $(document).find('.saveBtn[title="Save"]').text("Save")
                        $(document).find('.saveBtn[title="Save and Next"]').text("Save & Next")
                        $(document).find('.saveBtn[title="Submit"]').text("Submit")
                        $(document).find('.saveBtn').attr("disabled", false)
                      
                        editQualification();
                        if (saveButton.attr('title') == "Save and Next") {
                            editExperience();
                            $('.step_title').html(`<h3><strong class="text-primary ">Step 3 :</strong >  Experience Information</h3><hr>`);
                            $("#step1").hide();
                            $(formStep2).hide();
                            $("#step3Form").show();
                        }
                    }
                    else if (response.unauthorized) {
                        e.preventDefault();
                        $(document).find('.saveBtn[title="Save"]').text("Save")
                        $(document).find('.saveBtn[title="Save and Next"]').text("Save & Next")
                        $(document).find('.saveBtn[title="Submit"]').text("Submit")
                        $(document).find('.saveBtn').attr("disabled", false)
                        toastr.error("Failed to save Information , you are not allowed to save information about Employees");
                        return false;
                    }
                    else if (response.error) {
                        e.preventDefault();
                        $(document).find('.saveBtn[title="Save"]').text("Save")
                        $(document).find('.saveBtn[title="Save and Next"]').text("Save & Next")
                        $(document).find('.saveBtn[title="Submit"]').text("Submit")
                        $(document).find('.saveBtn').attr("disabled", false)
                        toastr["error"](response.error);
                        return false;
                    }
                    else {
                        e.preventDefault();
                        $(document).find('.saveBtn[title="Save"]').text("Save")
                        $(document).find('.saveBtn[title="Save and Next"]').text("Save & Next")
                        $(document).find('.saveBtn[title="Submit"]').text("Submit")
                        $(document).find('.saveBtn').attr("disabled", false)
                        toastr["error"]("An error occurred while saving qualification information for employee");
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

    })



});
