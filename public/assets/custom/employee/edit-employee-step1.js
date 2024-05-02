$(document).ready(function () {
    if (action == "edit") {
        $('select[name="user_id"]').val(employeeData.user_id);
        $('select[name="user_id"]').trigger("change");
        $("input[name='first_name']").val(employeeData.first_name);
        $("input[name='last_name']").val(employeeData.last_name);
        $("input[name='personal_email']").val(employeeData.personal_email);
        $('select[name="employment_status"]').val(employeeData.employment_status);
        $('select[name="employment_status"]').trigger("change");
        $("input[name='date_of_birth']").val(employeeData.date_of_birth);
        $('select[name="department"]').val(employeeData.department);
        $('select[name="department"]').trigger("change");
        setTimeout(() => {
            $('select[name="designation"]').val(employeeData.designation);
            $('select[name="designation"]').trigger("change");
        }, 1000)
        setTimeout(() => {
            $('select[name="shift"]').val(employeeData.shift);
            $('select[name="shift"]').trigger("change");
        }, 1000)
        $('select[name="country"]').val(employeeData.country);
        $('select[name="country"]').trigger("change")
        setTimeout(() => {
            $('select[name="state"]').val(employeeData.state);
            $('select[name="state"]').trigger("change");
        }, 1000)
        setTimeout(() => {
            $('select[name="city"]').val(employeeData.city);
            $('select[name="city"]').trigger("change");
        }, 1600);
        $('select[name="nationality"]').val(employeeData.nationality);
        $('select[name="nationality"]').trigger("change")
        $('select[name="religion"]').val(employeeData.religion);
        $('select[name="religion"]').trigger("change")
        $('select[name="gender"]').val(employeeData.gender);
        $('select[name="gender"]').trigger("change");
        $('select[name="blood_group"]').val(employeeData.blood_group);
        $('select[name="blood_group"]').trigger("change");
        $('input[name="joining_date"]').val(employeeData.joining_date);
        if (employeeData.martial_status == 1) {
            $('input[name="martial_status"]').prop('checked', true);
            $('input[name="no_of_child"]').val(employeeData.no_of_child);
            $(".no_of_child").show();

        }
        $('input[name="salary"]').val(employeeData.salary);
        $('input[name="cnic_number"]').val(employeeData.cnic_number);
        $('input[name="personal_contact"]').val(employeeData.personal_contact);
        $('input[name="emergency_contact"]').val(employeeData.emergency_contact);
        $('textarea[name="permanent_address"]').val(employeeData.permanent_address);
        $('textarea[name="present_address"]').val(employeeData.present_address);
        if (employeeData.permanent_address == employeeData.present_address) {
            $('.same_permanent').prop('checked', true);
            $('textarea[name="present_address"]').prop('readonly', true);
        }
        if(employeeData.employment_status == "internship" || employeeData.employment_status == "prohibition"){
            $('.emp_dates').show();
            $('input[name="start_date"]').val(employeeData.start_date);
            $('input[name="end_date"]').val(employeeData.end_date);
        }
        else{
            

        }

    }
})
