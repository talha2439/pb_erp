$(document).ready(function () {
    let accessStatusCheckbox = $('input[name="access_status"]');

    $(document).on('change', '.access_status', function (e) {
        let currentRow = $(this).closest('tr');
        let view_status = currentRow.find('.access_status[title="view"]').prop('checked') ? 1 : 0;
        let create_status = currentRow.find('.access_status[title="create"]').prop('checked') ? 1 : 0;
        let delete_status = currentRow.find('.access_status[title="delete"]').prop('checked') ? 1 : 0;
        let update_status = currentRow.find('.access_status[title="update"]').prop('checked') ? 1 : 0;
        let changedStatus = $(this);

        if (changedStatus.attr('title') == "view") {
            e.preventDefault();
            view_status = changedStatus.prop('checked') ? 1 : 0;
        }
        if (changedStatus.attr('title') == "create") {
            e.preventDefault();
            create_status = changedStatus.prop('checked') ? 1 : 0;
        }
        if (changedStatus.attr('title') == "delete") {
            e.preventDefault();
            delete_status = changedStatus.prop('checked') ? 1 : 0;
        }
        if (changedStatus.attr('title') == "update") {
            e.preventDefault();
            update_status = changedStatus.prop('checked') ? 1 : 0;
        }
        if (changedStatus.attr('title') == "all") {
            e.preventDefault();
            let checkAll = changedStatus.prop('checked');
            currentRow.find('.access_status').not('[title="all"]').prop('checked', checkAll);

            view_status = create_status = update_status = delete_status = checkAll ? 1 : 0;
            currentRow.find('.access_status[title="all"]').prop('checked', checkAll);
        }
        let allChecked = view_status && create_status && delete_status && update_status;
        currentRow.find('.access_status[title="all"]').prop('checked', allChecked);
        let has_all = currentRow.find('.access_status[title="all"]').prop('checked') ? 1 : 0;

        let menuId = currentRow.find('.menuId');
        let csrfToken = $('#csrf-token');
        let userId = $("#userId");
        $.ajax({
            url: changeAccessStatus + '/' + menuId.val(),
            type: 'POST',
            data: {
                '_token': csrfToken.val(), view_status: view_status, update_status: update_status, create_status: create_status, delete_status: delete_status, has_all: has_all
            },
            success: function (res) {
                if (res.unauthorized) {
                    e.preventDefault();
                    toastr['error']("You are not authorized to change access..!");
                    var previousStatus = changedStatus.prop('checked') ? true : false;
                    if (previousStatus) {
                        changedStatus.prop('checked', false);
                    }
                    else {
                        changedStatus.prop('checked', true);
                    }
                    return false;
                }
                if (res.success) {
                    toastr['success']("Access has been Changed..!");
                }
                else {
                    e.preventDefault();
                    toastr['error']("Failed to change access..!");
                    return false;
                }
            }
            ,
            error: function (jqXHR, textStatus, errorThrown) {
                e.preventDefault();
                toastr['error'](errorThrown);
                return false;
            }
        });


    })





});
