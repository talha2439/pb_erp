@extends('Admin.layout')
@section('title')
    Access Managment Users
@endsection
@section('content')
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 29.5px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #cccccc73 !important;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";

            left: 4px;
            bottom: 5px !important;
            background-color: white !important;
            -webkit-transition: .4s;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.301);
            transition: .4s;
        }

        input:checked+.slider {
            background-color: #4821f3 !important;
        }

        input:focus+.slider {
            box-shadow: 0 0 1px #4821f3 !important;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(30px);
            -ms-transform: translateX(30px);
            transform: translateX(30px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }
    </style>
    <div class="page-header">
        <div class="content-page-header">
            <h5>Menu Access Managment</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>All Sider Bar Menus</h3>
                <a href="{{ route('menusettings.index') }}" class="btn btn-primary">Menus List</a>
            </div>
        </div>


        <table class="datatables-basic table table-bordered">
            <thead>
                <tr>

                    <th>#</th>

                    <th>Menus</th>
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
                        <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">
                        <input type="hidden" class="menuId" value="{{ $item->id }}">

                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $item->name }}
                        </td>
                        <td>
                            <label class="switch switch-success">
                                <input type="checkbox" name="access_status" title="all" data-id="{{ $item->id }}"
                                    class="switch-input access_status" @if (
                                        @$item->menu_access->view_status == 1 &&
                                            @$item->menu_access->create_status == 1 &&
                                            @$item->menu_access->delete_status == 1 &&
                                            @$item->menu_access->update_status == 1) checked @endif />
                                <span class="slider round"></span>

                            </label>
                        </td>
                        <td>
                            <label class="switch switch-success">
                                <input type="checkbox" name="access_status" title="view" data-id="{{ $item->id }}"
                                    class="switch-input access_status" @if (@$item->menu_access->view_status == 1) checked @endif />
                                <span class="slider round"></span>

                                </span>

                            </label>
                        </td>
                        <td>
                            <label class="switch switch-success">
                                <input type="checkbox" name="access_status" title="create" data-id="{{ $item->id }}"
                                    class="switch-input access_status" @if (@$item->menu_access->create_status == 1) checked @endif />
                                <span class="slider round"></span>


                            </label>
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" name="access_status" title="delete" data-id="{{ $item->id }}"
                                    class="switch-input access_status" @if (@$item->menu_access->delete_status == 1) checked @endif />
                                <span class="slider round"></span>
                            </label>
                        </td>
                        <td>
                            <label class="switch">
                                <input type="checkbox" title="update" data-id="{{ $item->id }}"
                                    class="switch-input access_status" @if (@$item->menu_access->update_status == 1) checked @endif />
                                <span class="slider round"></span>
                            </label>


                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>


    </div>

    @push('js')
        <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
        <script src="{{ asset('assets/custom/menu-role-access.js') }}"></script>
        <script>
            $('.datatables-basic').dataTable({});
            let changeAccessStatus = "{{ route('menusettings.changeAccess') }}";
        </script>
    @endpush
@endsection
