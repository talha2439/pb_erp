@extends('Admin.layout')
@section('title')
Trashed Departments
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>Trashed Departments</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>Trashed Departments</h3>
                <div>
                    <a href="{{ route('departments.index') }}" class="btn btn-primary"><i class="fe fe-menu"></i></a>
                </div>

            </div>
        </div>

        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>

                        <th>Name</th>

                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($department as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->name }}
                            </td>

                            <td>
                                <a class="btn btn-danger text-white deleteDepart" data-id="{{ $item->id }}"> <i
                                        class="fe fe-trash"></i></a> |
                                <a class="btn btn-success text-white" href="{{ route('departments.restore', $item->id) }}"> <i
                                        class="fa fa-undo"></i></a>
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

            let deleteUrl = "{{ route('departments.destroy') }}";
            $(document).on('click', '.deleteDepart', function(e) {
                let id = $(this).data('id');
                let row = $(this).closest('tr');
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
                            if (res.unauthorized) {
                                toastr['error']('You are not authorized to delete Department information..!');
                                return false;
                            }
                           else if (res.employee_exist) {
                                toastr['error']('Failed to delete Department some employees are assigned with it delete them first..!');
                                return false;
                            }
                           else if (res.designation_exist) {
                                toastr['error']('Failed to delete Department some designation are assigned with it delete them first !');
                                return false;
                            }
                          else  if (res.success) {
                                toastr['success']('Department Deleted successfully..!')
                                row.remove();
                            } else {
                                toastr['error']('Something went wrong..!');
                            }
                        }
                    })
                        }
                     });

            });


        </script>
    @endpush
@endsection
