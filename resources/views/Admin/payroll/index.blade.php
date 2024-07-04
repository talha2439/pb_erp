@extends('Admin.layout')
@section('title')
Salary Information
@endsection
@section('content')
    <div class="page-header">
        <div class="content-page-header">
            <h5>Salary Information</h5>
        </div>
    </div>
    <div class="card p-3">
        <div class="card-header mb-2">
            <div class="d-flex justify-content-between">
                <h3>Salary Information</h3>
                <div>
                    <a href="{{ route('payroll.create') }}" class="btn btn-primary"><i class="fe fe-plus"></i></a>
                </div>
            </div>
        </div>

        <div class="card-datatable table-responsive pt-0">
            <table class="datatables-basic table table-bordered">
                <thead>
                    <tr>

                        <th>#</th>
                        <th>Employee-ID</th>
                        <th>Name</th>
                        <th>Gross Salary</th>
                        <th>Per Hour Salary</th>
                        <th>Absent Amount</th>
                        <th>Deduction Amount</th>
                        <th>Allowance</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

    </div>
    @push('js')
        <script>
            let allDataURL = "{{ route('payroll.data' , ['type' => 'index']) }}";
            $('.datatables-basic').dataTable({
                serverSide:true,
                processing: true,
                ajax: allDataURL,
                columns:[
                    {data:'row_index' , ordering:false},
                    {data:'employee_id'},
                    {data:'employee_name'},
                    {data:'gross_salary'},
                    {data:'per_hour'},
                    {data:'absent_deduction'},
                    {data:'deduction_per_hour'},
                    {data:"allowance"},
                    {data:"action"},

                ]

            });
            


        </script>
    @endpush
@endsection
