$(document).ready(function(){
    var isValid = true;
$('.datatables-basic').dataTable({});
$(document).on('click', '.deleteLoan', function(e) {
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
                    toastr['error']('You are not authorized to delete Loan information..!');
                    return false;
                }

                else  if (res.success) {
                        toastr['success']('Loan Information Deleted successfully..!')
                        row.remove();
                    } else {
                        toastr['error']('Something went wrong..!');
                    }
            }
        })
            }
         });

});

 //  Loan Status Change
    $(document).on('change','select[name="status"]', function(e){
        e.preventDefault();
        if($(this).val() == 'approved'){
            $(document).find('.approved_amount').fadeIn();
            $(document).find('.approved_amount').attr('data-type' ,'required');
        }
        else{
            $(document).find('.approved_amount').fadeOut();
            $(document).find('.approved_amount').attr('data-type' ,'');

        }
    })
    $(document).on('click' , '.statusChange' , function(e){
        let id = $(document).find('.id').val($(this).attr('data-id'));
        let status  = $(this).attr('data-status');
        if(status == 'approved' || status == 'paid'){
            $(document).find('#status').html(
                '<option value="">-- SELECT STATUS --</option><option value="paid">Amount Paid </option><option value="rejected">Reject</option>'
            );
        }
        else{
            $(document).find('#status').html(
                '<option value="">-- SELECT STATUS --</option> <option value="approved">Approve</option><option value="rejected">Reject</option>'
            );
        }
    })
    $(document).on('click' , '.amountPay' , function(e){
        let id = $(document).find('.payId').val($(this).attr('data-id'));

    })
    $('#loanStatusForm' ).submit(function(e){
        e.preventDefault();
        let data = $("#loanStatusForm").serialize();
        $.ajax({
            url: statusUrl,
            type: 'POST',
            data: data ,
            headers:{
                'X-CSRF-TOKEN':$(document).find('#csrf-token').val(),
            },
            success: function(res) {
                if (res.unauthorized) {
                    toastr['error']('You are not authorized to change Loan status..!');
                    return false;
                }
                if (res.exceed) {
                    toastr['error']('Loan Approved Amount cannot  Exceed the requested amount..!');
                    return false;
                }

                else  if (res.success) {
                        toastr['success']('Loan Status Changed successfully..!')
                        location.reload();
                    } else {
                        toastr['error']('Something went wrong..!');
                    }
            }
        })
    })
    $('#loanInstallmentForm' ).submit( function(e){
        isValid = true;
        validate("loanInstallmentForm",  e);
        if(isValid == true){
        e.preventDefault();
        console.log(payLoanUrl);

        let data = $("#loanInstallmentForm").serialize();
        $.ajax({
            url: payLoanUrl,
            type: 'POST',
            data: data ,
            headers:{
                'X-CSRF-TOKEN':$('#csrf-token').val(),
            },
            success: function(res) {
                if (res.unauthorized) {
                    toastr['error']('You are not authorized to pay Loan ..!');
                    return false;
                }
                if (res.exceed) {
                    toastr['error']('Paid Installment amount cannot Exceed the remaining amount..!');
                    return false;
                }

                else  if (res.success) {
                        toastr['success']('Loan Installment has been Paid successfully..!')
                        location.reload();
                    } else {
                        toastr['error']('Something went wrong..!');
                    }
            }
        })}
    })
    function validate(formId , e){
        let inputs = $(document).find('#'+formId).find('.form-control[data-type="required"]');
        $(inputs).each(function(){
            if($(this).val() == ""){
                e.preventDefault(); //
                toastr['error']($(this).attr('data-name')+ " is required..!");
                isValid = false; //
                return false;
            }
        })
    }
})
