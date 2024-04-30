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
                <a href="{{ route('employees.create') }}" class="btn btn-primary">Add Employee</a>
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
                        <th>View More</th>
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
                                            style="font-size: 10px ;width:65px; border-radius:4px; border:1px solid rgba(80, 3, 3, 0.288)">
                                            Notice period</div>
                                    </center>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex justify-content-between g-3   p-2">
                                    <span><input style="border:none; width:60px" class="salary" readonly type="password"
                                            value="{{ $item->salary }}"></span>
                                    <button class="fa fa-eye eye_icon"
                                        style="background: none;border:none; position:relative;bottom:2px"
                                        data-type="show"></button>
                                </div>
                            </td>
                            <td>
                                <center>
                                    <a class="btn btn-info text-white btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a class="btn btn-info text-white btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </center>
                            </td>
                            <td>
                                <center>
                                    <a class="btn btn-info text-white btn-sm">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                </center>
                            </td>

                            <td>
                                <a class="btn btn-danger text-white deleteEmployee" data-id="{{ $item->id }}"> <i
                                        class="fe fe-trash"></i></a> | <a class="btn btn-success text-white"
                                    href="{{ route('employees.restore', $item->id) }}"> <i class="fa fa-undo"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    </div>
    @push('js')
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
        <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
        <script>
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


            let deleteUrl = "{{ route('employees.destroy') }}";

            $(document).on('click', '.deleteEmployee', function(e) {
                let id = $(this).data('id');

                let confirm = window.confirm('Are you sure you want to delete');
                if (confirm) {
                    $.ajax({
                        url: deleteUrl + "/" + id,
                        type: 'Get',
                        success: function(res) {
                            if (res.success) {
                                toastr['success']('Employee information has been  Deleted successfully..!')
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
        </script>
    @endpush
@endsection
