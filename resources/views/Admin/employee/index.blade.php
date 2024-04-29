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
                  @foreach ($employee as $item )
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
                            @if($item->employment_status =="probition")
                            <div class="bg-warning text-white fw-bold p-1 text-center shadow" style="font-size: 10px ; border-radius:10px; border:2px solid rgb(212, 132, 11)">Probition</div>
                            @elseif ($item->employment_status == "parmanent")
                            <div class="bg-success text-white fw-bold p-1 text-center shadow" style="font-size: 10px ; border-radius:10px; border:2px solid rgb(3, 80, 35)">Permanent</div>
                            @elseif ($item->employment_status == "internship")
                            <div class="bg-info text-white fw-bold p-1 text-center shadow" style="font-size: 10px ; border-radius:10px; border:2px solid rgb(3, 39, 80)">Internship</div>
                            @else
                            <div class="bg-danger text-white fw-bold p-1 text-center shadow" style="font-size: 10px ; border-radius:10px; border:2px solid rgb(80, 3, 3)">Notice period</div>
                            @endif
                          </td>
                          <td> <a href="{{ route('menusettings.access' , $item->id) }}" class="btn btn-primary text-white" title="User Access Management"><i class='fe fe-lock'></i></a></td>

                          <td>
                              <a class="btn btn-danger text-white deleteMenu"  data-id="{{ $item->id }}" > <i class="fe fe-trash"></i></a> | <a class="btn btn-success text-white" href="{{ route("menusettings.create" , $item->id) }}"> <i class="fe fe-edit"></i></a>
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
        $('.datatables-basic').dataTable({

        });

        let deleteUrl  = "{{ route('menusettings.delete') }}";

        $(document).on('click', '.deleteMenu' , function (e) {
            let id = $(this).data('id');

            let confirm = window.confirm('Are you sure you want to delete');
            if(confirm) {
                $.ajax({
                    url : deleteUrl +"/"+id,
                    type:'Get',
                    success:function(res){
                        if(res.success){
                            toastr['success']('Menu Deleted successfully..!')
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        }
                        else{
                            toastr['error']('Something went wrong..!');
                        }
                    }
                })
            }

        });
   </script>

    @endpush
@endsection
