$(document).ready(function () {
    let department = $('select[name="department"]');
    let name = $('input[name="name"]');
    $(department).select2();

    let designationForm = $('#designationForm');
    $(designationForm).submit(function (e) {
        if (department.val() == "") {
            e.preventDefault();
            toastr['error']("Department  is required..!");
            return false;
        }
        if (name.val() == "") {
            e.preventDefault();
            toastr['error']("Designation name is required..!");
            return false;
        }
    });
    if (action == 'edit') {
        $(name).val(designationData.name);
        $(department).val(designationData.department)
        $(department).trigger('change')
    }
})
