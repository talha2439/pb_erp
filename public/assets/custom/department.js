$(document).ready(function () {
    let name = $('input[name="name"]');
    let departForm = $('#departForm');
    $(departForm).submit(function (e) {
        if (name.val() == "") {
            e.preventDefault();
            toastr['error']("Department name is required..!");
            return false;
        }
    });
    if (action == 'edit') {
        $(name).val(departdata.name);
    }
})
