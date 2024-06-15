@extends('Admin.layout')
@section('title')
    All Shifts
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>All Shifts</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>All Shifts</h3>
                <div>
                    <a href="{{ route('shifts.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i></a>
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>

                        <th>Department</th>
                        <th>Name</th>
                        <th>Shift Timings</th>
                        <th>Shift Days</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($shift as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $item->departments->name ?? "Not Assigned" }}
                            </td>

                            <td>
                                {{ $item->name }}
                            </td>
                            <td>{{ \Carbon\Carbon::parse($item->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($item->end_time)->format('h:i A') }}</td>
                            <td>
                                <select @readonly(true) name="" id="" class="form-select">
                                @foreach (json_decode($item->days) as $days )
                                <option value="{{ $days }}">{{ $days }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <a class="btn btn-danger text-white deleteShift" data-id="{{ $item->id }}"> <i
                                        class="fe fe-trash"></i></a> |
                                <a class="btn btn-success text-white" href="{{ route('shifts.create', $item->id) }}"> <i
                                        class="fe fe-edit"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @push('js')
        <script>
            $('.datatables-basic').dataTable({});
            let deleteUrl = "{{ route('shifts.delete') }}";
            $(document).on('click', '.deleteShift', function(e) {
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
                                toastr['error']('You are not authorized to delete shift information..!');
                                return false;
                            }
                           else if (res.employee_exist) {
                                toastr['error']('Failed to delete shift some employees are assigned with it delete them first..!');
                                return false;
                            }

                          else  if (res.success) {
                                toastr['success']('Shift Deleted successfully..!')
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
