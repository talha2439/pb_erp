$(document).ready(function(){
    let table;
    let designation   = $(document).find('#designation');
    let department    = $(document).find('#department');
    let employee      = $(document).find('#employee');
    let shifts        = $(document).find('#shifts');
    let status        = $(document).find('#status');
    $(document).on('submit','#filterEmployee' , function(e){
        e.preventDefault();
        if(table !== null){
            table.fnDestroy();
        }
        getAllData($(employee).val(),$(department).val(), $(status).val(), $(shifts).val(), $(designation).val());
    });


    getAllData();
    function getAllData(employee_id = null , department = null , status = null , shifts = null , designation){
            table =   $('.datatables-basic').dataTable({
                processing:true,
                ajax:{url: getAlldata, type:"GET", data:{
                    employee_id : employee_id,
                    department : department,
                    status : status,
                    shifts : shifts ,
                    designation : designation,
                }} , columns:[
                    {data:'row_index' , order:false},
                    {data:'employee_id' },
                    {data:'first_name'},
                    {data:'last_name'},
                    {data:'email'},
                    {data:'department'},
                    {data:'designation'},
                    {data:'status'},
                    {data:'salary'},
                    {data:'document'},
                    {data:'qualification'},
                    {data:'experience'},
                    {data:'details'},
                    {data:'action'},
                ]
            });

    }
    $(document).on('click', '.eye_icon', function(e) {
        e.preventDefault();
        if ($(this).data('type') == "show") {
            $(this).toggleClass('fa-eye-slash fa-eye');
            $(this).closest('.d-flex').find('.salary').attr('type', 'text');
            $(this).data('type', 'hide');
        } else {
            $(this).closest('.d-flex').find('.salary').attr('type', 'password');
            $(this).toggleClass('fa-eye-slash fa-eye');
            $(this).data('type', 'show');
        }

    });
    // Delete

    $(document).on('click', '.deleteEmployee', function(e) {
        let id = $(this).data('id');
        let row = $(this).closest('tr');
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
                                'Employee information has been  Deleted successfully..!'
                                )
                                $(row).remove()
                        } else {
                            toastr['error']('Something went wrong..!');
                        }
                    }
                })
            }
        });


    });
    // Qualification show
    $(document).on('click', '.showQualification', function(e) {
        let id = $(this).data('id');
        $.ajax({
            url: getQualificationUrl + '/' + id,
            type: 'Get',
            success: function(res) {
                let qualificationData = "";
                if (res.success) {
                    if (res.data.length > 0) {
                        $(res.data).each(function(key, val) {
                            let docspath = "../images/employee_qualification/" + val
                                .document;
                                console.log(docspath)
                            qualificationData += `
                        <tr>
                        <td>${key + 1}</td>
                        <td>${val.institute}</td>
                        <td>${val.qualification}</td>
                        <td>${val.start_date}</td>
                        <td>${val.end_date}</td>
                        <td>${val.gpa}</td>
                        <td>${val.percentage}%</td>
                        <td><a  ${val.document ? '' : 'disabled="true"'} download href="${val.document ? docspath : '#'}" class="btn btn-primary text-white btn-sm" ><i class="fa fa-download"></i></a ></td>
                        </tr>
                        `;
                        })
                    } else if (res.data.length == 0) {
                        qualificationData =
                            "<tr><td colspan='3' class='text-center text-danger'>No Qualification Information Found</td></tr>";
                    }
                    $("#qualificationData").html(qualificationData)
                }
            }
        })
    });
    // experience show
    $(document).on('click', '.showExperience', function(e) {
        let id = $(this).data('id');
        $.ajax({
            url: getExperienceUrl + '/' + id,
            type: 'Get',
            success: function(res) {
                let experienceData = "";
                if (res.success) {
                    if (res.data.length > 0) {
                        $(res.data).each(function(key, val) {
                            let docspath = "../images/emp_experience_attachment/" + val
                                .attachment;
                            experienceData += `
                        <tr>
                        <td>${key + 1}</td>
                        <td>${val.job_title}</td>
                        <td>${val.designation}</td>
                        <td>${val.start_date}</td>
                        <td>${val.end_date}</td>
                        <td>${val.salary}</td>
                        <td><a  ${val.attachment ? '' : 'disabled="true"'} download href="${val.attachment ? docspath : '#'}" class="btn btn-primary text-white btn-sm" ><i class="fa fa-download"></i></a ></td>
                        </tr>
                        `;
                        })
                    } else if (res.data.length == 0) {
                        experienceData =
                            "<tr><td colspan='3' class='text-center text-danger'>No Experience Information Found</td></tr>";
                    }
                    $("#experienceData").html(experienceData)
                }
            }
        })
    })
})
