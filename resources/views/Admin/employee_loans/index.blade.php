@extends('Admin.layout')
@section('title')
Employee Loan List
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>Employee Loan List</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>Employee Loan List</h3>
                <div>
                    <a href="{{ route('employee_loans.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i></a>
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>

                        <th>Employee ID</th>
                        <th>Employee name</th>
                        <th>Loan type</th>
                        <th>Requested Date</th>
                        <th>Due Date</th>
                        <th>Requested Amount</th>
                        <th>Approved Amount</th>
                        <th>Requested By</th>
                        <th>Requested At</th>
                        <th>Approved By</th>
                        <th>Approved At</th>
                        <th>Rejected By</th>
                        <th>Rejected At</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($loans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>  {{ $item->employees->emp_uniq_id ??  ""}}</td>
                            <td>
                                {{ $item->employees->first_name .' '. $item->employees->last_name  ?? ""}}
                            </td>
                            
                            <td>
                                <a class="btn btn-danger text-white deleteLoanType" data-id="{{ $item->id }}"> <i
                                        class="fe fe-trash"></i></a> |
                                <a class="btn btn-success text-white" href="{{ route('employee_loans.create', $item->id) }}"> <i
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

            let deleteUrl = "{{ route('employee_loans.delete') }}";
            $(document).on('click', '.deleteLoanType', function(e) {
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
                                toastr['error']('You are not authorized to delete Loan information..!');
                                return false;
                            }

                            else  if (res.success) {
                                    toastr['success']('Loan Type Deleted successfully..!')
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
