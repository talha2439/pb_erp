@extends('Admin.layout')
@section('title')
    All Employees
@endsection
@section('content')
    <style>
        @media (min-width: 768px)  {
            .experienceContainer{
                position: relative; bottom:130px
            }
        }
    </style>
    <div class="container" style="max-width:900px">
        <div class="card shadow-sm border p-4" style="min-height: 700px; padding:30px">

            <div class="row">
                <div class="col-md-12">
                    <a href="{{ route('employees.index') }}" class="btn btn-secondary"><i class="fe fe-corner-down-left"></i></a> | <a href="{{ route('employee.cv.pdf' , encrypt($employee->id)) }}" target="_blank" class="btn btn-primary"><i class="fe fe-printer"></i></a>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    {{-- Profile Image and Name --}}
                    <div class="ml-3 row mt-3 mb-2">
                        @php
                            $imagePath = file_exists(public_path('images/Employees/profile/' . $employee->image)) ? url(asset('images/Employees/profile/' . $employee->image)) : url(asset('assets/img/no-image.png')) ;
                        @endphp
                        <div class="col-md-4 " style="min-height:250px;">
                            <img src="{{ $imagePath }}" alt=""
                            class="border rounded shadow-sm p-2"
                            style="min-height:250px; min-width:250px; max-width:250px; object-fit:cover">
                        </div>

                        <div class="text col-md-8  col-12">
                            <h1 class="fw-bold text-uppercase fs-1 fs-md-2 fs-lg-3 fs-xl-4">
                                {{ $employee->first_name }} {{ $employee->last_name }}
                            </h1>
                            <h5>{{ ucfirst($employee->designations->name) }}</h5>
                        </div>
                    </div>

                    {{-- Personal Information --}}
                    <div class="text-start row col-md-12 ml-3">
                        {{-- Contact Information --}}
                        <div class="col-md-4">
                            <div class="ml-3">
                                <h4 class="fw-bold mt-3">Contact Information</h4>
                                <hr>
                                <div class="row rounded p-2 border me-2" style="min-height:200px">
                                    <div class="col-md-2 text-primary"><i class="fe fe-mail" style="border-right: 2px solid rgb(122, 93, 204); padding-right:5px"></i></div>
                                    <div class="col-md-10">{{ $employee->personal_email }}</div>
                                    <div class="col-md-2 mt-2 text-primary"><i class="fe fe-mail" style="border-right: 2px solid rgb(122, 93, 204); padding-right:5px"></i></div>
                                    <div class="col-md-10 mt-2">{{ @$employee->users->email }}</div>
                                    <div class="col-md-2 mt-2 text-primary"><i class="fe fe-phone" style="border-right: 2px solid rgb(122, 93, 204); padding-right:5px"></i></div>
                                    <div class="col-md-10 mt-2">{{ $employee->personal_contact }}</div>
                                    <div class="col-md-2 mt-2 text-primary"><i class="fe fe-map-pin" style="border-right: 2px solid rgb(122, 93, 204); padding-right:5px"></i></div>
                                    <div class="col-md-10 mt-2"><small>{{ $employee->permanent_address }}</small></div>
                                </div>
                            </div>
                            @if(!empty($employee->emergency_contact))
                            <div class="ml-3">
                                <h4 class="fw-bold mt-3">Emergency Contact</h4>
                                <hr>
                                <div class="row rounded p-2 border me-2" style="min-height:100px">
                                    <div class="col-md-2 text-primary"><i class="fe fe-user" style="border-right: 2px solid rgb(122, 93, 204); padding-right:5px"></i></div>
                                    <div class="col-md-10">{{ $employee->emergency_contact_person }}</div>
                                    <div class="col-md-2 text-primary"><i class="fe fe-phone" style="border-right: 2px solid rgb(122, 93, 204); padding-right:5px"></i></div>
                                    <div class="col-md-10">{{ @$employee->emergency_contact }}</div>

                                    <div class="col-md-2 text-primary"><i class="fe fe-users" style="border-right: 2px solid rgb(122, 93, 204); padding-right:5px"></i></div>
                                    <div class="col-md-10"> <small>{{ $employee->emergency_contact_relation != null ? $employee->emergency_contact_relation : "No Defined" }}</small></div>
                                </div>
                            </div>
                            @endif
                        </div><br>

                        {{-- Qualifications and Experiences --}}
                        <div class="col-md-8 experienceContainer " >
                            <hr>
                            <div class="d-flex justify-content-between mt-3">
                                <b style="border-bottom:3px solid rgb(134, 11, 216)">
                                    <h4><i class="fe fe-file text-primary ml-3"></i> Qualification</h4>
                                </b>
                            </div>
                            {{-- QualificationTable --}}
                            <div class="me-4 mt-2" style="position:relative;">
                                <div class="accordion accordion-flush" id="qualification">
                                @forelse ($employee->qualifications as $key => $qualification)
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header" id="heading{{ $qualification->id }}">
                                            <button class="accordion-button bg-white border-0 mt-1 p-1 pe-2 btn-primary" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapse{{ $qualification->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $qualification->id }}">
                                                <a href="" class="btn btn-primary"><i class="fe fe-printer  text-white"></i></a>&nbsp;<span class="ml-3">{{ $qualification->qualification }}</span>
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $qualification->id }}" class="accordion-collapse collapse @if($key == 0) show active @endif" aria-labelledby="heading{{ $qualification->id }}"
                                            data-bs-parent="#qualification">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-3 border">Institute</div>
                                                    <div class="col-md-8 border">{{ $qualification->institute ?? 'No Information' }}</div>
                                                    <div class="col-md-3 border">Qualification</div>
                                                    <div class="col-md-8 border">{{ $qualification->qualification ?? 'No Information' }}</div>
                                                    <div class="col-md-3 border">Date</div>
                                                    <div class="col-md-8 border">{{ $qualification->start_date ?? 'No Information' }} <b>-</b>
                                                        {{ $qualification->start_date ?? 'Present' }}</div>
                                                    <div class="col-md-3 border">GPA</div>
                                                    <div class="col-md-8 border">{{ $qualification->gpa ?? 0 }}</div>
                                                    <div class="col-md-3 border">Percentage</div>
                                                    <div class="col-md-8 border">{{ $qualification->percentage ?? 0 }}%</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="accordion-item border-0">
                                        <button class="accordion-button bg-white mt-4 btn-primary" disabled type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            No Qualification Information Available
                                        </button>
                                    </div>
                                    @endforelse
                                </div>
                            </div>

                            <hr>

                            <div class="d-flex justify-content-between mt-3">
                                <b style="border-bottom:3px solid rgb(134, 11, 216)">
                                    <h4><i class="fe fe-briefcase text-primary ml-3"></i> Job Experience</h4>
                                </b>
                            </div>

                            {{-- Experience --}}
                            <div class="me-4 mt-4" style="position:relative;">
                                <div class="accordion accordion-flush" id="experience">
                                    @forelse ($employee->experiences as $key => $experience)
                                    <div class="accordion-item border-0">
                                        <h2 class="accordion-header" id="experienceHeading{{ $experience->id }}">
                                            <button class="accordion-button border-0 bg-white mt-1 p-1 pe-2 btn-primary" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#collapseExperience{{ $experience->id }}" aria-expanded="true"
                                                aria-controls="collapse{{ $experience->id }}">
                                                <a href="" class="btn btn-primary"><i class="fe fe-printer  text-white"></i></a>&nbsp;<span class="ml-3">{{ $experience->designation }}</span>
                                            </button>
                                        </h2>
                                        <div id="collapseExperience{{ $experience->id }}" class="accordion-collapse collapse @if($key == 0) show active @endif" aria-labelledby="experienceHeading{{ $experience->id }}"
                                            data-bs-parent="#experience">
                                            <div class="accordion-body">
                                                <div class="row">
                                                    <div class="col-md-3  border">Company Name</div>
                                                    <div class="col-md-8 border">{{ $experience->job_title ?? 'No Information' }}</div>
                                                    <div class="col-md-3 border">Designation</div>
                                                    <div class="col-md-8 border">{{ $experience->designation ?? 'No Information' }}</div>
                                                    <div class="col-md-3 border">From</div>
                                                    <div class="col-md-8  border">{{ $experience->start_date ?? 'No Information' }}</div>
                                                    <div class="col-md-3  border">To</div>
                                                    <div class="col-md-8  border">{{ $experience->end_date ?? 'Present' }}</div>
                                                    <div class="col-md-3  border">Previous Salary</div>
                                                    <div class="col-md-8  border"> PKR,{{ $experience->salary ?? 'Present' }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <div class="accordion-item border-0">
                                        <button class="accordion-button bg-white mt-4 btn-primary" disabled type="button" data-bs-toggle="collapse"
                                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                            No Experience Information Available
                                        </button>
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <hr>
            <center><small class="text-secondary"></small></center>
        </div>
    </div>
@endsection
