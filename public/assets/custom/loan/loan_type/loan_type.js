$(document).ready(function () {
    let name = $('input[name="name"]');
    let loanTypeForm = $('#loanTypeForm');
    $(loanTypeForm).submit(function (e) {
        if (name.val() == "") {
            e.preventDefault();
            toastr['error']("Loan Type is required..!");
            return false;
        }
    });
    if (action == 'edit') {
        $(name).val(loanTypeData.name);
    }
})
