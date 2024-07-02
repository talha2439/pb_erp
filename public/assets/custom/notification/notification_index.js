$(document).ready(function(){
    var table;
    generateTable();
    let isRead = $("#read_status");
    $(isRead).on('change', function(e){


          let readed = null ;
          if($(this).val() == "readed"){
           readed  = 1;
          }
          else if($(this).val() == 'unreaded'){
            readed = 0;
          }
          console.log(readed);

        if(table !== null){
            table.fnDestroy();
        }
        generateTable(readed);
    })
    $(document).on('click', '.deleteNotification' , function (e) {
        let id    = $(this).data('id');
        let row   = $(this).closest('tr');
        Swal.fire({
            title: "Are you sure?",
            text: "You sure you want to remove it ? ",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#6C05A8',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes' ,
            cancelButtonText: 'No'
        }).then((res) => {
            if (res.isConfirmed) {
                $.ajax({
                    url: deleteUrl + "/" + id,
                    type: 'Get',
                    success: function(res) {
                        if (res.success) {
                            toastr['success'](
                                'Notification has been  Deleted successfully..!'
                                )
                                $(row).remove();
                                if(table !== null){
                                    table.fnDestroy();
                                }
                                generateTable();

                        } else {
                            toastr['error']('Something went wrong..!');
                        }
                    }
                })
            }
        });

    });
    function generateTable(readed = null){
        table = $('.datatables-basic').dataTable({
            serverSide: true,
            processing:true,
            ajax:{
                url: allNotificationsURL,
                type:'GET',
                data: {readed : readed},
            },
            columns:[
                {data:'row_index', orderable:false},
                {data:'message' },
                {data:'created_at' },
                {data:'status' },
                {data:'action' },
            ]
        });
    }



});
