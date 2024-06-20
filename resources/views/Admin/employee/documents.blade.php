@extends('Admin.layout')
@section('title')
   Employees Documents
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
                <h3>Employees Documents</h3>
                <div>
                    <a href="{{ route('employees.index') }}" class="btn btn-primary"><i class="fe fe-menu"></i></a>
                </div>
            </div>
        </div>
        <div class="table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Employee-Id</th>
                        <th>Document URL</th>

                        <th>Action</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach ($document as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                {{ $item->employees->emp_uniq_id }}
                            </td>

                            <td>
                                {{ $item->document }}
                            </td>
                            <td>
                                    <a class="btn btn-primary text-white btn-sm viewDocument" data-image="{{ $item->document }}" data-bs-toggle="modal"
                                        data-bs-target="#documentModal">
                                        <i class="fa fa-eye"></i>
                                    </a> |  <a data-id="{{ $item->id }}"
                                        class="btn btn-danger text-white btn-sm deleteDocument">
                                        <i class="fa fa-trash"></i>
                                    </a>

                            </td>


                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    </div>
    @include('Admin.employee.popup.document')
    {{-- End of Modal Partial --}}
    @push('js')
        <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
        <script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
        <script>
            let basePath = "{{ asset('') }}";

            $('.datatables-basic').dataTable({});

            let deleteUrl = "{{ route('employees.document.delete') }}";

            $(document).on('click', '.deleteDocument', function(e) {
                let id =  $(this).data('id');
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
                                if (res.success) {
                                    toastr['success'](
                                        'Employee Document has been  Deleted successfully..!'
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
            $(document).on('click', '.viewDocument', function(e) {
                let image = $(this).data('image');
                $(document).find('#documentImage').attr('src', image);
            });

        </script>
    @endpush
@endsection
