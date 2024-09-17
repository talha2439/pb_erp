$(document).ready(function(){
$(document).on('click', '#searchBtn', function(e){
                e.preventDefault();
                getTableData(department.val(), employee.val(), month.val(), year.val());
            })
            getTableData();
            function getTableData(department = null , employee = null , month = null , year = null) {
                if(dataTable != null){
                    dataTable.fnDestroy();
                }
                dataTable  = $('.datatables-basic').dataTable({
                serverSide:true,
                processing: true,
                ajax:{ url:allDataURL , data:{department_id : department , employee_id : employee , month : month , year : year}},
                columns:[
                    {data:'row_index' , ordering:false},
                    {data:'employee_id'},
                    {data:'name'},
                    {data:'gross_salary'},
                    {data:'absent_deduction'},
                    {data:'total_absents'},
                    {data:'total_lates'},
                    {data:'total_early_outs'},
                    {data:'total_leaves'},
                    {data:"total_off"},
                    {data:"total_deduction"},
                    {data:"loan_amount"},
                    {data:"bonus_amount"},
                    {data:"allowance"},
                    {data:"net_salary"},
                    {data:"month_year"},
                    {data:"action"},

                ]

            });
            }
});
