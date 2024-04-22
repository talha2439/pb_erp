@extends('Admin.layout')
@section('title')
All Menus
@endsection
@section('content')

    <div class="page-header">
    <div class="content-page-header">
    <h5>Side Bar Menus</h5>
    </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>All Sider Bar Menus</h3>
                <a href="{{ route('menusettings.create') }}" class="btn btn-primary">Add Menus</a>
            </div>
        </div>
        <div class="table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
              <thead>
                <tr>

                  <th>#</th>
                  <th>Icon</th>
                  <th>Name</th>
                  <th>Total Sub Menus</th>
                  <th>Route</th>
                  <th>Role Access</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                  @foreach ($menu as $item )
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>
                              <i class="{{ $item->icon }}"></i>
                          </td>
                          <td>
                              {{ $item->name }}
                          </td>
                          <td>
                              {{ $item->submenu->count() }}
                          </td>
                          <td>{{ $item->route ?? $item->submenu[0]->route }}</td>
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
