@extends('Admin.layout')
@section('title')
    All Employees
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>Employees</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>All Employees</h3>
                <div>
                    <a href="{{ route('employees.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i></a>
                </div>
            </div>
        </div>
        <div class="table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Employee-Id</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Employeement-Status</th>
                        <th>Salary</th>
                        <th>Qualification</th>
                        <th>Experience</th>
                        <th>All Details</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employee as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $item->emp_uniq_id }}
                            </td>

                            <td>
                                {{ $item->first_name }}
                            </td>
                            <td>
                                {{ $item->last_name }}
                            </td>
                            <td>
                                {{ $item->personal_email }}
                            </td>
                            <td>
                                @if ($item->employment_status == 'prohibition')
                                    <center>
                                        <div class="bg-warning text-white fw-bold p-1 shadow-sm text-center "
                                            style="font-size: 10px ;width:65px; border-radius:4px; border:1px solid rgba(212, 132, 11, 0.322)">
                                            Probition</div>
                                    </center>
                                @elseif ($item->employment_status == 'parmanent')
                                    <center>
                                        <div class="bg-success text-white fw-bold p-1 shadow-sm text-center "
                                            style="font-size: 10px ;width:65px; border-radius:4px; border:1px solid rgba(3, 80, 35, 0.349)">
                                            Permanent</div>
                                    </center>
                                @elseif ($item->employment_status == 'internship')
                                    <center>
                                        <div class="bg-info text-white fw-bold p-1 shadow-sm text-center "
                                            style="font-size: 10px ;width:65px; border-radius:4px; border:1px solid rgba(3, 39, 80, 0.192)">
                                            Internship</div>
                                    </center>
                                @else
                                    <center>
                                        <div class="bg-danger text-white fw-bold p-1  shadow-sm text-center "
                                            style="font-size: 10px ;width:75px; border-radius:4px; border:1px solid rgba(80, 3, 3, 0.288)">
                                            Resigned</div>
                                    </center>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-between g-3  p-2">
                                    <input style="border:none; width:60px" class="salary" readonly type="password"
                                        value="{{ $item->salary }}">
                                    <button class="fa fa-eye eye_icon"
                                        style="background: none;border:none; position:relative;bottom:2px"
                                        data-type="show"></button>
                                </div>
                            </td>
                            <td>
                                <center>
                                    <a class="btn btn-info text-white btn-sm showQualification"
                                        data-id="{{ $item->id }}" data-bs-toggle="modal"
                                        data-bs-target="#qualificationModal">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </a>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a class="btn btn-warning text-white btn-sm showExperience" data-bs-toggle="modal"
                                        data-bs-target="#experienceModal"data-id="{{ $item->id }}"
                                        data-id="{{ $item->id }}">
                                        <i class="fa-solid fa-square-poll-horizontal"></i>
                                    </a>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a href="{{ route('employees.details', encrypt($item->id)) }}"
                                        class="btn btn-primary text-white btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </center>
                            </td>

                            <td>
                                <a class="btn btn-danger text-white deleteEmployee" data-id="{{ $item->id }}"> <i
                                        class="fe fe-trash"></i></a> | <a class="btn btn-success text-white"
                                    href="{{ route('employees.create', $item->id) }}"> <i class="fe fe-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    </div>
    {{-- Modals Partials --}}
    @include('Admin.employee.popup.experience')
    @include('Admin.employee.popup.qualification')
    {{-- End of Modal Partial --}}
    @push('js')
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
        <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
        <script>
            let basePath = "{{ asset('') }}";
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

            })
            $('.datatables-basic').dataTable({});

            let deleteUrl = "{{ route('employees.delete') }}";

            $(document).on('click', '.deleteEmployee', function(e) {
                let id = $(this).data('id');
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
                                if (res.success) {
                                    toastr['success'](
                                        'Employee information has been  Deleted successfully..!'
                                        )
                                    setTimeout(() => {
                                        window.location.reload();
                                    }, 1500);
                                } else {
                                    toastr['error']('Something went wrong..!');
                                }
                            }
                        })
                    }
                });


            });
            let getQualificationUrl = "{{ route('employees.get.qualification') }}";
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
                                    qualificationData += `
                                <tr>
                                <td>${key + 1}</td>
                                <td>${val.institute}</td>
                                <td>${val.qualification}</td>
                                <td>${val.start_date}</td>
                                <td>${val.end_date}</td>
                                <td>${val.gpa}</td>
                                <td>${val.percentage}%</td>
                                <td><a  ${val.document ? '' : 'disabled="true"'} href="${val.document ? docspath : '#'}" class="btn btn-primary text-white btn-sm" ><i class="fa fa-download"></i></a ></td>
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
            })
            let getExperienceUrl = "{{ route('employees.get.experience') }}";
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
                                <td><a  ${val.attachment ? '' : 'disabled="true"'} href="${val.attachment ? docspath : '#'}" class="btn btn-primary text-white btn-sm" ><i class="fa fa-download"></i></a ></td>
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
        </script>
    @endpush
@endsection
