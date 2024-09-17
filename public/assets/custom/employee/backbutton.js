
$(document).ready(function () {
    $(document).on('click', '.back_button', function (e) {
        e.preventDefault();
        let titleattr = $(this).attr('title');
        if (titleattr === "step1") {
            $('#step1').fadeIn();
            $('.step_title').html(`<h3><strong class="text-primary ">Step 1 :</strong >  Personal Information </h3><hr>`);
            $("#step2Form").hide();
            $("#step3Form").hide();
        }
        if (titleattr === "step2") {
            editQualification();
            $('.step_title').html(`<h3><strong class="text-primary ">Step 2 :</strong >  Qualification Information </h3><hr>`);
            $('#step1').hide();
            $("#step2Form").fadeIn();
            $("#step3Form").hide();
        }
    })
    function updateQualification(){
        $.ajax({
            url: qualificationEdit + '/' + $('input[name="emp_id"]').val(),
            type: "GET",
            success: function (response) {
                let qualificationData = "";
                if (response.qualification.length > 0) {
                    $(response.qualification).each(function (index, value) {
                        let actionButton = `<div class="form-group "><button class="btn btn-primary mt-3" id="addMoreQualification"><i class="fe fe-plus"></i></button></div>`;
                        if (index >= 1) {
                            actionButton = `<div class="form-group "><button class="btn btn-danger mt-3 removeBtn" data-id="${value.id}"><i class="fe fe-trash"></i></button></div>`;
                        }
                        qualificationData += ` <div class="row p-2">
                    <div class="col-md-12" id="qualificationContainer">
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end ">

                                   ${actionButton}
                            </div>
                            <input type="hidden" name="qualification_id[]" value="${value.id}">
                            <input type="hidden" name="deleted_qualification[]" value="${value.id}">
                            <div class="col-md-3 mt-2 mb-3">
                                <div class="form-group">
                                    <label for="">Institute Name <span class="text-danger">( Required )</span></label>
                                   <input type="text" class="form-control" name="institute[]" value="${value.institute}" placeholder="Institute name">
                                </div>
                            </div>
                            <div class="col-md-3 mt-2 mb-3">
                                <div class="form-group">
                                    <label for="">Qualification <small class="text-danger" >( Required )</small></label>
                                    <input type="text" name="qualification[]" value="${value.qualification}" class="form-control" placeholder="Qualification">
                                </div>
                            </div>
                            <div class="col-md-3 mt-2 mb-3">
                                <div class="form-group">
                                    <label for="">Start Date <span class="text-danger">( Required )</span></label>
                                   <input type="date" class="form-control" name="start_date[]" value="${value.start_date}"  placeholder="Start Date">
                                </div>
                            </div>
                            <div class="col-md-3 mt-2 mb-3">
                                <div class="form-group">
                                    <label for="">End Date <span class="text-danger">( Required )</span></label>
                                   <input type="date" class="form-control" name="end_date[]" value="${value.end_date}" placeholder="End Date">
                                </div>
                            </div>
                            <div class="col-md-3 mt-2 mb-3">
                                <div class="form-group">
                                    <label for="">GPA <span class="text-secondary">( Optional )</span></label>
                                   <input type="number" class="form-control" name="gpa[]" value="${value.gpa}" placeholder="GPA">
                                </div>
                            </div>
                            <div class="col-md-3 mt-2 mb-3">
                                <div class="form-group">
                                    <label for="">Percentage <span class="text-secondary">( Optional )</span></label>
                                   <input type="number" class="form-control" name="percentage[]" value="${value.percentage}"  placeholder="Percentage">
                                </div>
                            </div>


                            <div class="col-md-3 mt-2 mb-3">
                                <div class="form-group">
                                    <label for="">Documents <small class="text-secondary">( Optional )</small></label>
                                    <input type="file" name="document[]" class="form-control documentFile" >
                                </div>
                            </div>

                        </div>
                    </div>
                    </div>
                   `
                    });

                    $(".step_2_formContainer").html(qualificationData);
                }

            }
        });
    }
})
