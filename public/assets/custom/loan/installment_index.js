$(document).ready(function() {
    let table;
    getData();
    function getData (){
        if(table != null){
            table.fnDestroy();
        }
                table = $('.datatables-basic').dataTable({
                    serverSide: true,
                    processing:true,
                    ajax:{
                        url:allDataURL,
                        type:'GET',
                    },
                    columns:[
                        {data:'index', sorting:false},
                        {data:'emp_id'},
                        {data:'first_name'},
                        {data:'last_name'},
                        {data:'total_amount'},
                        {data:'installment_amount'},
                        {data:'remaining_amount'},
                        {data:'paid_amount'},
                        {data:'payment_date'},
                        {data:'confirmed_by'},
                        {data:'confirmed_at'},
                        {data:'attachment'},
                        {data:'status'},
                        {data:'action'},
                    ]
                })

    }
    $(document).on('click' , '.editBtn', function(e){
        let id  = $(this).attr('data-id');
        let amount  = $(this).attr('data-amount');
        $(document).find('input[name="id"]').val(id);
        $(document).find('input[name="amount"]').val(amount);

    })
    $("#updateForm").submit(function(e){
        isValid = true;
        validate('updateForm' ,e)
        if(isValid){
            e.preventDefault();
            $.ajax({
                url : updateURL,
                type:'POST',
                data:$("#updateForm").serialize(),
                success:function(res){
                    if(res.unauthorized){
                        toastr['error']("You do not have permission to update Loan Installment");
                        $("#editModal").modal('hide');
                        return false
                    }
                    else if(res.exceed){
                        toastr['error']("Installment amount cannot exceed remaining amount");
                        $("#editModal").modal('hide');
                    }
                    else if(res.success){
                        toastr['success']("Installment successfully updated");
                        $("#editModal").modal('hide');
                        getData();
                    }
                    else if(res.error == true){
                        toastr['error']("Error while updating installment");
                        return false;
                    }
                    else{
                        toastr['error'](res.error);
                        return false;
                    }
                }
            })
        }
    })
    $(document).on('click', '.changeStatus', function(e) {
        let id = $(this).data('id');
        let changeStatus = $(this);
        Swal.fire({
            title: "Are you sure?",
            text: "You sure you want to confirm it ? ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6C05A8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes' ,
            cancelButtonText: 'No'
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    url: statusURL + "/" + id,
                    type: 'Get',
                    success: function(res) {
                        if(res.unauthorized){
                            toastr['error']("You are not allowed to confirm loan installments ..!");
                            return false;
                        }
                        else if (res.success) {
                            toastr['success']('Loan installment Has Been Confirmed..!');
                            getData();
                        } else {
                            toastr['error']('Something went wrong..!');
                        }
                    }
                })
            }
        });


    });
});
