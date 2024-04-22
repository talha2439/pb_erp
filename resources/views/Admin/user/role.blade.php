@extends('Admin.layout')
@section('title')
    Users Access Managment Settings
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5> Name : {{ $user->name }} | Role : {{ $user->role == 1 ? 'Admin' : 'User' }}</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header p-2 mb-2">
            <div class="d-flex justify-content-between">
                <div></div>
                <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
            </div>
        </div>

        <div class="card-datatable table-responsive pt-0">


            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Menu</th>
                        <th>All</th>
                        <th>View</th>
                        <th>Create</th>
                        <th>Delete</th>
                        <th>Update</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($access as $item)
                        <tr>
                            @php
                                $checkMenuRole = \App\Models\MenuAccessManagment::where(
                                    'sub_menu_id',
                                    $item->id,
                                )->first();

                            @endphp
                            <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">
                            <input type="hidden" class="menuId" value="{{ $item->id }}">
                            <input type="hidden" id="userId" value="{{ $user->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $item->name }}
                                <small class="text-success">( {{ @$item->menu->name }} )</small>
                            </td>

                            <td>

                                <label class="switch">
                                    <input type="checkbox" name="access_status" title="all"
                                        class="switch-input access_status" data-id="{{ $item->id }}"
                                        @if (!@$checkMenuRole->has_all == 1 && empty($checkMenuRole)) disabled @endif
                                        @if (
                                            @$item->access->view_status == 1 &&
                                                @$item->access->create_status == 1 &&
                                                @$item->access->delete_status == 1 &&
                                                @$item->access->update_status == 1) checked @endif>

                                    <span class="slider round"></span>
                                    <input type="hidden" id="csrftoken" value="{{ csrf_token() }}">

                                </label>



                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="access_status" title="view"
                                        class="switch-input access_status" data-id="{{ $item->id }}"
                                        @if (!@$checkMenuRole->view_status == 1 || empty($checkMenuRole)) disabled @endif
                                        @if (@$item->access->view_status == 1) checked @endif>
                                    <span class="slider round"></span>
                                    <input type="hidden" id="csrftoken" value="{{ csrf_token() }}">
                                </label>

                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="access_status" title="create"
                                        class="switch-input access_status" data-id="{{ $item->id }}"
                                        @if (!@$checkMenuRole->create_status == 1 || empty($checkMenuRole)) disabled @endif
                                        @if (@$item->access->create_status == 1) checked @endif>
                                    <span class="slider round"></span>
                                    <input type="hidden" id="csrftoken" value="{{ csrf_token() }}">
                                </label>


                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="access_status" title="delete"
                                        class="switch-input access_status" data-id="{{ $item->id }}"
                                        @if (!@$checkMenuRole->delete_status == 1 || empty($checkMenuRole)) disabled @endif
                                        @if (@$item->access->delete_status == 1) checked @endif>
                                    <span class="slider round"></span>
                                    <input type="hidden" id="csrftoken" value="{{ csrf_token() }}">
                                </label>



                            </td>
                            <td>
                                <label class="switch">
                                    <input type="checkbox" name="access_status" title="update"
                                        class="switch-input access_status" data-id="{{ $item->id }}"
                                        @if (!@$checkMenuRole->update_status == 1 || empty($checkMenuRole)) disabled @endif
                                        @if (@$item->access->update_status == 1) checked @endif>
                                    <span class="slider round"></span>
                                    <input type="hidden" id="csrftoken" value="{{ csrf_token() }}">
                                </label>



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
        <script src="{{ asset('assets/custom/role-access.js') }}"></script>
        <script>
            $('.datatables-basic').dataTable({});
            let changeAccessStatus = "{{ route('users.change.access') }}";
        </script>
    @endpush
@endsection
