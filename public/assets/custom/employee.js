$(document).ready(function () {
    $('.select2').select2({});
    // Country , State , City Cascading Dropdown
    let employee = $('select[name="employee_id"]');
    let first_name= $('input[name="first_name"]');
    let personal_email = $('input[name="personal_email"]');
    let designation = $('select[name="designation"]');
    let country = $('select[name="country"]');
    let state = $('select[name="state"]');
    let city = $('select[name="city"]');
    let cnic = $("input[name='cnic_number']");
    let personalNumber = $('input[name="personal_contact"]');
    let emergency_number = $('input[name="emergency_contact"]');
    let permanent_address = $('textarea[name="permanent_address"]');
    let present_address = $('textarea[name="present_address"]');
    let check_permanent = $('.same_permanent');
    let martial_status = $('input[name="martial_status"]')
    $(martial_status).on('change', function (e) {

        e.preventDefault();

        if ($(this).prop('checked') == true) {
            $('.no_of_child').fadeIn();
        }
        else {
            $('.no_of_child').fadeOut();
        }
    });
    // State Select
    $(country).on('change', function (e) {
        e.preventDefault();
        let id = $(this).val();
        $.ajax({
            url: stateURL + '/' + id,
            type: 'Get',
            success: function (data) {
                let stateData = '<option value="">-- Select State --</option>';
                if (data.length > 0) {
                    $(data).each(function (index, val) {
                        stateData += `<option value="${val.id}">${val.name}</option>`;
                    });
                }
                else {
                    stateData = '<option value="">-- Select State --</option>';
                }
                $(state).html(stateData);
            }
        });
    });
    // City Select
    $(state).on('change', function (e) {
        e.preventDefault();
        let id = $(this).val();
        $.ajax({
            url: cityURL + '/' + id,
            type: 'Get',
            success: function (data) {
                let cityData = '<option value="">-- Select City --</option>';
                if (data.length > 0) {
                    $(data).each(function (index, val) {
                        cityData += `<option value="${val.id}">${val.name}</option>`;
                    });
                }
                else {
                    cityData = '<option value="">-- Select State --</option>';
                }
                $(city).html(cityData);
            }
        });
    });
    // CNIC MASKING and PHONE
    $(cnic).mask('00000-0000000-0');
    $(personalNumber).mask('( +92 ) 0000000000');
    $(emergency_number).mask('( +92 ) 0000000000');
    //  Same as Parmenent Address
    $(check_permanent).on('change', function () {
        if ($(this).prop('checked') == true) {
            $(present_address).val(permanent_address.val());
            $(present_address).prop('readonly', true);

        }
        else {
            $(present_address).val("");
            $(present_address).prop('readonly', false);
        }
    });
    $(permanent_address).on('keyup', function (e) {
        if ($(check_permanent).prop('checked') == true) {
            $(present_address).val($(this).val());
            $(present_address).prop('readonly', true);
        }
    })
    // Step 1
    let step1form = $("#step1");
    let step1save = $("#step_1_next");
    $(step1save).on('click', function (e) {
        e.preventDefault();
        let isValid = true;
        let title = $(this).attr('title');
        if ($(employee).val() == "") {
            e.preventDefault();
            toastr['error']("Please Select Employee from User List");
            isValid = false;
            return false;
        }
        else if ($(first_name).val() == "") {
            e.preventDefault();
            toastr['error']("Enter Employee first name");
            isValid = false;
            return false;
        }

        else if ($(personal_email).val() == "") {
            e.preventDefault();
            toastr['error']("Enter Employee personal email");
            isValid = false;
            return false;
        }
        else if ($(joining_date).val() == "") {
            e.preventDefault();
            toastr['error']("Enter Employee Joining Date");
            isValid = false;
            return false;
        }

        else if ($(cnic).val() == "") {
            e.preventDefault();
            toastr['error']("Enter Employee CNIC Number");
            isValid = false;
            return false;
        }

        else if ($(personalNumber).val() == "") {
            e.preventDefault();
            toastr['error']("Enter Employee Personal Number");
            isValid = false;
            return false;
        }
        else if ($(present_address).val() == "") {
            e.preventDefault();
            toastr['error']("Enter Employee Present Address");
            isValid = false;
            return false;
        }
        if (isValid) {
            e.preventDefault();
            toastr['success']("Wokrin");
        }


    });

    // End of Step 1
})
