$(document).ready(function () {
    $(".select2").select2({});
    // Country , State , City Cascading Dropdown
    let employee = $('select[name="user_id"]');
    let first_name = $('input[name="first_name"]');
    let personal_email = $('input[name="personal_email"]');
    let department = $('select[name="department"]');
    let designation = $('select[name="designation"]');
    let joining_date = $('input[name="joining_date"]');
    let shift = $('select[name="shift"]');
    let country = $('select[name="country"]');
    let state = $('select[name="state"]');
    let city = $('select[name="city"]');
    let gender = $('select[name="gender"]');
    let cnic = $("input[name='cnic_number']");
    let personalNumber = $('input[name="personal_contact"]');
    let emergency_number = $('input[name="emergency_contact"]');
    let permanent_address = $('textarea[name="permanent_address"]');
    let present_address = $('textarea[name="present_address"]');
    let check_permanent = $(".same_permanent");
    let martial_status = $('input[name="martial_status"]');
    let date_of_birth = $('input[name="date_of_birth"]');
    let image = $('input[name="image"]');
    let csrfToken = $('input[name="csrf_token"]');
    let empId = $('input[name="emp_id"]');
    // Form Input Variables Ended here
    var isrequiredcnic = false;
    $(date_of_birth).on("change", function (e) {
        e.preventDefault();
        let dob = new Date(date_of_birth.val()).getFullYear();
        let currentDate = new Date().getFullYear();
        TotalYears = currentDate - dob;
        if (TotalYears >= 18) {
            isrequiredcnic = true;
            $(".requiredCnic").show();
            $(".unrequired").hide();
        }
        else {
            isrequiredcnic = false;
            $(".requiredCnic").hide();
            $(".unrequired").show();
        }
    });
    $(date_of_birth).on("keypress", function (e) {
        e.preventDefault();
        let dob = new Date(date_of_birth.val()).getFullYear();
        let currentDate = new Date().getFullYear();
        TotalYears = currentDate - dob;
        if (TotalYears >= 18) {
            isrequiredcnic = true;
            $(".requiredCnic").show();
            $(".unrequired").hide();
        }
        else {
            isrequiredcnic = false;
            $(".requiredCnic").hide();
            $(".unrequired").show();
        }
    });
    $(martial_status).on("change", function (e) {
        e.preventDefault();

        if ($(this).prop("checked") == true) {
            $(".no_of_child").fadeIn();
        } else {
            $(".no_of_child").fadeOut();
        }
    });
    // Shift And Designations
    $(department).on("change", function (e) {
        e.preventDefault();
        let id = $(this).val();
        $.ajax({
            url: designationAndShiftURL + "/" + id,
            type: "Get",
            success: function (data) {
                let shiftData = '<option value="">-- Select Shift --</option>';
                let designationData =
                    '<option value="">-- Select  Designation --</option>';
                if (data.shift != null && data.shift != undefined) {
                    shiftData = '<option value="">-- Select Shift --</option>';
                    $(data.shift).each(function (index, value) {
                        shiftData += `<option value="${value.id}">${value.name} | ${value.start_time} - ${value.end_time}</option>`;
                    });
                }
                if (data.designation != null && data.designation != undefined) {
                    designationData =
                        '<option value="">-- Select Designation --</option>';
                    $(data.designation).each(function (index, value) {
                        designationData += `<option value="${value.id}">${value.name}</option>`;
                    });
                }

                shift.html(shiftData);
                designation.html(designationData);
            },
        });
    });
    // State Select
    $(country).on("change", function (e) {
        e.preventDefault();
        let id = $(this).val();
        $.ajax({
            url: stateURL + "/" + id,
            type: "Get",
            success: function (data) {
                let stateData = '<option value="">-- Select State --</option>';
                if (data.length > 0) {
                    $(data).each(function (index, val) {
                        stateData += `<option value="${val.id}">${val.name}</option>`;
                    });
                } else {
                    stateData = '<option value="">-- Select State --</option>';
                }
                $(state).html(stateData);
            },
        });
    });
    // City Select
    $(state).on("change", function (e) {
        e.preventDefault();
        let id = $(this).val();
        $.ajax({
            url: cityURL + "/" + id,
            type: "Get",
            success: function (data) {
                let cityData = '<option value="">-- Select City --</option>';
                if (data.length > 0) {
                    $(data).each(function (index, val) {
                        cityData += `<option value="${val.id}">${val.name}</option>`;
                    });
                } else {
                    cityData = '<option value="">-- Select State --</option>';
                }
                $(city).html(cityData);
            },
        });
    });
    // CNIC MASKING and PHONE
    $(cnic).mask("00000-0000000-0");
    $(personalNumber).mask("( +92 ) 0000000000");
    $(emergency_number).mask("( +92 ) 0000000000");
    //  Same as Parmenent Address
    $(check_permanent).on("change", function () {
        if ($(this).prop("checked") == true) {
            $(present_address).val(permanent_address.val());
            $(present_address).prop("readonly", true);
        } else {
            $(present_address).val("");
            $(present_address).prop("readonly", false);
        }
    });
    $(permanent_address).on("keyup", function (e) {
        if ($(check_permanent).prop("checked") == true) {
            $(present_address).val($(this).val());
            $(present_address).prop("readonly", true);
        }
    });
    // Step 1
    let step1form = $("#step1");
    let step1save = $(".step_1_next");
    $(step1save).on("click", function (e) {

        e.preventDefault();
        let button = $(this);
        let isValid = true;
        let title = $(this).attr("title");
        if ($(employee).val() == "") {
            e.preventDefault();
            toastr["error"]("Please Select Employee's from User List");
            isValid = false;
            return false;
        } else if ($(first_name).val() == "") {
            e.preventDefault();
            toastr["error"]("Enter Employee's first name");
            isValid = false;
            return false;
        } else if ($(personal_email).val() == "") {
            e.preventDefault();
            toastr["error"]("Enter Employee's personal email");
            isValid = false;
            return false;
        } else if ($(date_of_birth).val() == "") {
            e.preventDefault();
            toastr["error"]("Enter Employee's Date of Birth");
            isValid = false;
            return false;
        } else if ($(department).val() == "") {
            e.preventDefault();
            toastr["error"]("Department is required");
            isValid = false;
            return false;
        } else if ($(designation).val() == "") {
            e.preventDefault();
            toastr["error"]("Designation is required");
            isValid = false;
            return false;
        } else if ($(gender).val() == "") {
            e.preventDefault();
            toastr["error"]("Gender is required");
            isValid = false;
            return false;
        } else if ($(joining_date).val() == "") {
            e.preventDefault();
            toastr["error"]("Enter Employee's Joining Date");
            isValid = false;
            return false;
        }

        if (isrequiredcnic == true) {
            if ($(cnic).val() == "") {
                e.preventDefault();
                toastr["error"]("Enter Employee's CNIC Number");
                isValid = false;
                return false;
            }
        }
        if ($(personalNumber).val() == "") {
            e.preventDefault();
            toastr["error"]("Enter Employee's Personal Number");
            isValid = false;
            return false;
        }
        if ($(permanent_address).val() == "") {
            e.preventDefault();
            toastr["error"]("Enter Employee's Permanent Address");
            isValid = false;
            return false;
        }
        if (isValid) {
            e.preventDefault();
            let formData = new FormData();

            if (image.val() !== "") {
                let imageData = image[0].files[0];
                formData.append("image", imageData);
            }
            formData.append('data', step1form.serialize());
            $.ajax({
                url: employeeStore,
                type: 'post',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken.val() // Pass the CSRF token in the request headers
                },
                success: function (response) {
                    if (response.success) {
                        e.preventDefault();
                        toastr.success("Employee Personal Information has been saved successfully");
                        if (button.attr('title') == 'Save and Next') {
                            $(empId).val(response.emp_id);
                            $('.step_title').html(`<h3><strong class="text-primary ">Step 2 :</strong >  Qualification Information </h3><hr>`);
                            $(step1form).hide();
                            $("#step2Form").show();
                        }

                    }
                    else if (response.unauthorized) {
                        e.preventDefault();
                        toastr.error("Failed to save Information , you are not allowed to save information about Employees");
                        return false;
                    }
                    else if (response.error) {
                        e.preventDefault();
                        toastr["error"](response.error);
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

    // End of Step 1
});
