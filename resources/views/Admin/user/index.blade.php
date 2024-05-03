@extends('Admin.layout')
@section('title')
    All Users
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>All Users</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>All Users</h3>
                <a href="{{ route('users.create') }}" class="btn btn-primary">Add Users</a>
            </div>
        </div>

        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>User Role</th>
                        @if (Auth::user()->role == 1)
                            <th>Password</th>
                            <th>Roles</th>
                        @endif
                        <th>Account - status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                @if (!empty($item->image))
                                    <img class="shadow rounded bordered"
                                        src="{{ asset('images/UsersImages/' . $item->image) }}"
                                        style="width: 40px; height:40px; object-fit:contain; border:1px solid rgba(119, 118, 118, 0.555) ;"
                                        alt="">
                                @else
                                    <img class="shadow rounded bordered" src="{{ asset('assets/img/no-image.png') }}"
                                        style="width: 40px; height:40px; object-fit:contain; border:1px solid rgba(119, 118, 118, 0.555) ;"
                                        alt="">
                                @endif
                            </td>
                            <td>
                                {{ $item->name }}
                            </td>
                            <td>
                                {{ $item->email }}
                            </td>
                            @php
                                 $role  = "";
                                if($item->role == 1){
                                    $role = 'Admin';
                                }
                                elseif ($item->role == 2) {
                                    $role = 'Manager';
                                }
                                elseif ($item->role == 3) {
                                    $role = 'HR';
                                }
                                elseif ($item->role == 4) {
                                    $role = 'Employee';
                                }


                            @endphp
                            <td>{{ $role }}</td>
                            @if (Auth::user()->role == 1)
                                <td>{{ $item->password_txt }}</td>
                                <td>
                                    <a href="{{ route('users.role', encrypt($item->id)) }}"
                                        class="btn btn-primary text-white" title="User Access Management"><i
                                            class='fe fe-lock'></i></a>
                                </td>
                            @endif
                            <td>
                                <label class="switch">
                                    <input type="checkbox" class="switch-input"name="active" data-id="{{ $item->id }}"
                                        @if ($item->email_verified_at != null) checked @endif>

                                    <span class="slider round"></span>
                                    <input type="hidden" id="csrftoken" value="{{ csrf_token() }}">

                                </label>&nbsp; <strong class="text-primary mt-3">
                                    @if ($item->email_verified_at == null)
                                        Un-verifeid
                                    @else
                                        Verified
                                    @endif
                                </strong>

                            </td>
                            <td>
                                <a class="btn btn-danger text-white deleteUser" data-id="{{ $item->id }}"> <i
                                        class="fe fe-trash"></i></a> |
                                <a class="btn btn-success text-white" href="{{ route('users.create', $item->id) }}"> <i
                                        class="fe fe-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @push('js')
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
        <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
        <script>
            $('.datatables-basic').dataTable({});

            let deleteUrl = "{{ route('users.delete') }}";
            let userActiveUrl = "{{ route('users.status') }}";
            $(document).on('click', '.deleteUser', function(e) {
                let id = $(this).data('id');
                let confirm = window.confirm('Are you sure you want to delete');
                if (confirm) {
                    $.ajax({
                        url: deleteUrl + "/" + id,
                        type: 'Get',
                        success: function(res) {
                            if (res.unauthorized) {
                                toastr['error']('You are not authorized to delete user information..!');
                                return false;
                            }
                            if (res.success) {
                                toastr['success']('User Deleted successfully..!')
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

            $(document).on('change', 'input[name="active"]', function(e) {
                e.preventDefault();
                let id = $(this).data('id');
                let status = $(this).is(':checked') ? 1 : 0;
                let currentCheck = $(this);
                $.ajax({
                    url: userActiveUrl + '/' + id,
                    type: "POST",
                    data: {
                        status: status,
                        _token: $("#csrftoken").val()
                    },
                    success: function(res) {
                        if (res.unauthorized) {
                            toastr['error']('You are not authorized to change this..!');
                            var previousStatus = currentCheck.prop('checked') ? true : false;
                            if (previousStatus) {
                                currentCheck.prop('checked', false);
                            } else {
                                currentCheck.prop('checked', true);
                            }
                            return false;
                        } else if (res.success) {
                            toastr['success']('User Status has been Changed successfully..!');
                        } else {
                            toastr['error']('Failed to change user status. Something went wrong..!');
                        }
                    }

                })
            })
        </script>
    @endpush
@endsection
