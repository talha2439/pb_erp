@extends('Admin.layout')
@section('title')
    All Employees
@endsection
@section('content')
    <div class="container" style="max-width:900px">
        <div class="card shadow-sm border p-4" style="min-height: 700px ; padding:30px">

            <div class="row ">
                <div class="col-md-12"><a href="" class="btn btn-primary"><i class="fa fa-print"></i></a></div>
                <div class="col-md-12  m-3" style="width: max-content">
                        {{-- img --}}
                        <div class="row">
                        <div class="ml-3 col-md-4 ">
                            <img src="{{ asset('images/EmployeesImages/'.$employee->image) }}" alt="" class="border rounded shadow-sm p-2" style="height:250px; width:auto; max-width:250px  ; object-fit:cover">
                            <div class="ml-3">
                                <h4 class="fw-bold mt-3">Contact Information</h4><hr>
                            </div>

                            <div class="row p-2 border me-2" style="min-height:200px">
                                <div class="col-md-2 text-primary  "><i class="fe fe-mail"></i></div>
                                <div class="col-md-10  "> {{ $employee->personal_email }}</div>
                                <div class="col-md-2 mt-2 text-primary "><i class="fe fe-mail"></i></div>
                                <div class="col-md-10 mt-2 "> {{ @$employee->users->email }}</div>
                                <div class="col-md-2  mt-2 text-primary"><i class="fe fe-phone"></i></div>
                                <div class="col-md-10 mt-2 "> {{ $employee->personal_contact }}</div>
                                <div class="col-md-2 mt-2 text-primary"><i class="fe fe-map-pin"></i></div>
                                <div class="col-md-10 mt-2 "><small>{{$employee->permanent_address}}</small></div>



                            </div>

                        </div>
                        {{-- Personal Information --}}
                        <div class="text-start col-md-8 ml-3 ">
                            <h1 class="fw-bold" style="text-transform: uppercase; font-size:50px">{{ $employee->first_name }} {{  $employee->last_name }}</h1>
                            <h5>Full-stack Developer</h5>
                            <hr>
                            <div class="d-flex justify-content-between mt-3">
                                <b style="border-bottom:3px solid rgb(134, 11, 216)"><h4><i class="fe fe-file text-primary ml-3"></i>  Qualification</h4></b> &nbsp; <a href="@if(!empty($employee->qualifications->document )){{ asset('images/employee_qualification/' . $employee->qualifications->document ) }}@else # @endif" class="btn btn-primary"><div class="fa fa-print">  </div></a>
                            </div>
                            {{-- QualificationTable --}}
                            <div class="me-4 mt-2" style="position:relative;">
                            <div class="row">

                                <div class="col-md-3  border">Institute</div>
                                <div class="col-md-8 border"> {{ $employee->qualifications->institute ?? "No Information" }}</div>
                                <div class="col-md-3 border">Qualification</div>
                                <div class="col-md-8 border"> {{ $employee->qualifications->qualification ?? "No Information" }}</div>
                                <div class="col-md-3 border">Date</div>
                                <div class="col-md-8  border"> {{ $employee->qualifications->start_date ?? "No Information"}} <b>-</b>  {{ $employee->qualifications->start_date ?? "Present" }} </div>
                                <div class="col-md-3  border">GPA</div>
                                <div class="col-md-8  border"> {{ $employee->qualifications->gpa ?? 0 }}</div>
                                <div class="col-md-3  border">Percentage</div>
                                <div class="col-md-8  border"> {{ $employee->qualifications->percentage ?? 0 }}%</div>

                            </div>
                            </div>
                            {{-- Experience --}}
                            <div class="d-flex justify-content-between mt-3">
                                <b  style="border-bottom:3px solid rgb(134, 11, 216)"><h4><i class="fe fe-briefcase text-primary ml-3"></i>  Job Experience</h4></b> &nbsp; <a href="@if(!empty($employee->experience->attachment )){{ asset('images/emp_experience_attachment/' . $employee->experience->attachment ) }}@else # @endif" class="btn btn-primary"><div class="fa fa-print">  </div></a>
                            </div>
                            <div class="me-4 mt-4" style="position:relative;">
                                <div class="row">

                                    <div class="col-md-3  border">Company Name</div>
                                    <div class="col-md-8 border"> {{ $employee->experience->job_title ?? "No Information" }}</div>

                                    <div class="col-md-3 border">Designation</div>
                                    <div class="col-md-8 border"> {{ $employee->experience->designation ?? "No Information" }}</div>
                                    <div class="col-md-3 border">From</div>
                                    <div class="col-md-8  border"> {{ $employee->experience->start_date ?? "No Information" }}</div>
                                    <div class="col-md-3  border">To</div>
                                    <div class="col-md-8  border"> {{ $employee->experience->end_date ?? "Present" }}</div>

                                    <div class="col-md-3  border">Previous Salary</div>
                                    <div class="col-md-8  border"> PKR,{{ $employee->experience->salary ?? "Present" }}</div>


                                </div>
                                </div>
                        </div>
                    </div>
                </div>
                {{-- Personal Information --}}
                <div class="col-md-8">

                </div>
            </div><hr>
            <center><small class="text-secondary"></small></center>
        </div>
    </div>



@endsection
