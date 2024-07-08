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
                        <th>Duration</th>
                        <th>Requested Amount</th>
                        <th>Approved Amount</th>
                        <th>Remaining Amount</th>
                        <th>Paid Amount</th>
                        <th>Requested By</th>
                        <th>Approved By</th>
                        <th>Rejected By</th>
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
                            <td>{{ $item->loan_types->name ?? "" }}</td>
                            @php
                                $requested_date = \Carbon\Carbon::parse($item->request_date);
                                $due_date = \Carbon\Carbon::parse($item->due_date);
                                $status   = $item->status;
                                $blinkstatus = 'success';
                                if($status == 'pending'){
                                    $blinkstatus = 'warning';
                                }
                                else if($status == 'rejected'){
                                    $blinkstatus = 'danger';
                                }
                                else if($status == 'approved'){
                                    $blinkstatus ='success';
                                }
                                else if($status == 'paid'){
                                    $blinkstatus ='info';
                                }

                            @endphp
                            <td>{{  $requested_date->format('F d , Y') }}</td>
                            <td>{{  $due_date->format('F d , Y') }}</td>
                            <td>{{  $requested_date->diffInDays($due_date) .' Days' ?? "0 Days"}}</td>
                            <td>{{  \Number::currency($item->requested_amount , 'PKR' , 'en_PK') }}</td>
                            <td>{{  \Number::currency($item->approved_amount  , 'PKR' , 'en_PK') }}</td>
                            <td>{{  \Number::currency($item->remaining_amount  , 'PKR' , 'en_PK') }}</td>
                            <td>{{  \Number::currency($item->paid_amount  , 'PKR' , 'en_PK') }}</td>
                            <td>{{  $item->created_by ?? 'unknown' }}</td>
                            <td>{{ @$item->approved->first_name .' ' .@$item->approved->last_name  }}</td>
                            <td>{{ @$item->rejected->first_name .' ' .@$item->rejected->last_name  }}</td>
                            <td>
                                <span class="blink blink-{{ $blinkstatus }}">{{ $item->status }}</span></td>
                            <td>
                                <a class="btn btn-info text-white " href="{{ route('employee_loans.details', encrypt($item->id)) }}"> <i
                                        class="fe fe-eye"></i></a> |
                                <a class="btn btn-primary text-white " href="#"> <i
                                        class="fe fe-printer"></i></a> |
                                        <a class="btn btn-success statusChange text-white"data-bs-toggle="modal"
                                        data-bs-target="#loanStatusModal"
                                        data-id="{{ $item->id }}" > <i
                                            class="fe fe-edit" ></i></a> |
                                            <a class="btn btn-danger text-white deleteLoan" data-id="{{ $item->id }}"> <i
                                                    class="fe fe-trash"></i></a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
    @include('Admin.employee_loans.partial.popup')
    @push('js')
    <script src="{{ asset('assets/custom/loan/loan_index.js') }}"></script>
        <script>
            let deleteUrl = "{{ route('employee_loans.delete') }}";
        </script>
    @endpush
@endsection
