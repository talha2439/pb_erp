@extends('Admin.layout')
@section('title')
    All Departments
@endsection
@section('content')

<div class="page-header">
    <div class="content-page-header">
        <h5>All Departments</h5>
    </div>
</div>
<div class="card p-3">
    <div class="card-header mb-2">
        <div class="d-flex justify-content-between">
            <h3>All Departments</h3>
            <a class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTop" aria-controls="offcanvasTop"><i class="fe fe-filter"></i></a>
            <div class="offcanvas offcanvas-top" style="height: max-content!important" tabindex="-1" id="offcanvasTop" aria-labelledby="offcanvasTopLabel">
            <div class="offcanvas-header">
                <h5 id="offcanvasTopLabel" class="fw-bolder"><span class="text-primary"><i class="fe fe-file-text"></i></span>Reports Filter</h5>
                <button type="button" class="btn-close text-reset btn-primary btn" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div><hr>
            <div class="offcanvas-body">
            <div class="card p-3">
                @include('Admin.attendance.reports.filter')
            </div>
            </div>
            </div>
        </div>
    </div>

    <div class="card-datatable table-responsive pt-0">
        <table class="datatables-basic table table-bordered">
            <thead>
                <tr>

                    <th>#</th>
                    <th>Employee ID</th>
                    <th>Employee Name</th>
                    <th>Department</th>
                    <th>Date</th>
                    <th>Attendance Status</th>
                    <th>Check in -  Checkout</th>
                    <th>More Details</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($attendance as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ $item->name }}
                        </td>

                        <td>
                            <a class="btn btn-danger text-white deleteDepart" data-id="{{ $item->id }}"> <i
                                    class="fe fe-trash"></i></a> |
                            <a class="btn btn-success text-white" href="{{ route('departments.create', $item->id) }}"> <i
                                    class="fe fe-edit"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>
@push('js')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.js"></script>
<link rel="stylesheet" href="{{ asset('assets/plugins/datatables/datatables.min.css') }}">
<script src="{{ asset('assets/plugins/datatables/datatables.min.js') }}"></script>
<script>

    $('.datatables-basic').dataTable({});

    let deleteUrl = "{{ route('departments.delete') }}";
    $(document).on('click', '.deleteDepart', function(e) {
        let id = $(this).data('id');
        let confirm = window.confirm('Are you sure you want to delete');
        if (confirm) {
            $.ajax({
                url: deleteUrl + "/" + id,
                type: 'Get',
                success: function(res) {
                    if (res.unauthorized) {
                        toastr['error']('You are not authorized to delete department information..!');
                        return false;
                    }
                   else if (res.employee_exist) {
                        toastr['error']('Failed to delete department some employees are assigned with it delete them first..!');
                        return false;
                    }
                   else if (res.designation_exist) {
                        toastr['error']('Failed to delete department some designation are assigned with it delete them first !');
                        return false;
                    }
                  else  if (res.success) {
                        toastr['success']('Department Deleted successfully..!')
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
    $(document).ready(function(){
        $('.select2').select2({});
    })

</script>
@endpush
@endsection
