$(document).ready(function(){
    $(document).on('click', '.deleteLoanType', function(e) {
        let id = $(this).data('id');
        let row = $(this).closest('tr');
        Swal.fire({
            title: "Are you sure?",
            text: "You sure you want to remove it ? ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6C05A8',
            cancelButtonColor: '#d33',
            cancelButtonText: 'No',
            confirmButtonText: 'Yes'
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                url: deleteUrl + "/" + id,
                type: 'Get',
                success: function(res) {
                    if (res.unauthorized) {
                        toastr['error']('You are not authorized to delete Loan Types information..!');
                        return false;
                    }
                   else if (res.loan_exists) {
                        toastr['error']('Failed to delete Loan Type some Loans for Employees are assigned with it delete them first !');
                        return false;
                    }
                  else  if (res.success) {
                        toastr['success']('Loan Type Deleted successfully..!')
                        row.remove();
                    } else {
                        toastr['error']('Something went wrong..!');
                    }
                }
            })
                }
             });

    });

})
