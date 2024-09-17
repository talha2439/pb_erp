$(document).ready(function () {
    let username = $('input[name="username"]');
    let name = $('input[name="name"]');
    let role = $('select[name="role"]');
    let email = $('input[name="email"]');
    let userForm = $("#userForm");
    $(userForm).submit(function (e) {
        if (username.val() == "") {
            e.preventDefault();
            toastr['error']("Username is required..!");
            return false;
        }
        if (name.val() == "") {
            e.preventDefault();
            toastr['error']("Name is required..!");
            return false;
        }
        if (email.val() == "") {
            e.preventDefault();
            toastr['error']("Email is required..!");
            return false;
        }
        if (role.val() == "") {
            e.preventDefault();
            toastr['error']("User Role is required..!");
            return false;
        }
    });

    if (action == 'edit') {
        $(username).val(userData.username);
        $(name).val(userData.name);
        $(email).val(userData.email);
        $(role).val(userData.role);
        if (userData.email_verified_at) {
            $('input[name="active"').prop('checked', true);
        }
    }
});
