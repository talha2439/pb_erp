<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee CV</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
        integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/js/all.min.js"
        integrity="sha512-u3fPA7V8qQmhBPNT5quvaXVa1mnnLSXUep5PS1qo5NRzHwG19aHmNJnj1Q8hpA/nBWZtZD4r4AX6YOt5ynLN2g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<style>
    * {
        font-family: Arial, Helvetica, sans-serif
    }

    .container {
        padding: 10px;
        border: 1px solid rgb(197, 197, 197);
        border-radius: 10px;
    }

    .left-data {
        width: 380px;
        height: 100%;
        overflow: hidden;
        position: relative;
        bottom: 30px;
    }

    .image-container {
        border: 1px solid rgb(197, 197, 197);
        padding: 10px;
        border-radius: 10px;
        width: 320px;
        height: 330px;
        text-align: center;
        /* Center image horizontally */
        line-height: 280px;
        /* Center image vertically */
        position: relative;
        margin:
            10px;
    }

    .image-container img {
        max-width: 100%;
        max-height: 330px;
        height: 100%;
        border-radius: 5px;
    }

    .title-container {
        padding: 10px;
        position: relative;
        bottom: 30px
    }

    .title-container h1 {
        font-size: 45px;
        text-transform: uppercase;
        font-weight: bold;
        color: rgb(41, 5, 41)
    }

    .title-container h3 {
        position: relative;
        bottom: 15px;
        color: rgb(58, 56, 56)
    }

    .qualification-container {
        padding: 10px;
        position: relative;
        bottom: 40px;

    }

    .qualification-container h2 {
        border-bottom: 3px solid purple;
        width: 190px
    }

    .qualification-container table {
        width: 600px;
    }

    .qualification-container table th {
        border: 1px solid rgb(145, 145, 145);
        padding: 3px 10px;
        font-weight: light;
        color: rgb(46, 45, 45);
        text-align: start;
    }

    .experience-container {
        padding: 10px;
        position: relative;
        bottom: 40px;
    }

    .heading th {
        border: none !important;
        padding: 0 !important;
        border-spacing: 0 !important;
        white-space: nowrap !important;
        display: flex;
    }

    .heading h2 {
        border: none !important;
        position: relative;
        left: 15px;
    }

    .heading {
        border-bottom: 3px solid purple !important;
        width: 50px !important;
    }

    .experience-container h2 {
        border-bottom: 3px solid purple;
        width: 190px;
        white-space: nowrap
    }

    .experience-container table {
        width: 600px;
    }

    .experience-container table th {
        border: 1px solid rgb(145, 145, 145);
        padding: 3px 10px;
        font-weight: light;

        color: rgb(46, 45, 45);
        text-align: start;
    }

    .contact-container {
        text-align: start;
        padding: 10px;
        border: 1px solid rgb(146, 146, 146);
        border-radius: 5px;
        margin-bottom: 20px;
    }

    .contact-container th {}

    .contact-container table {
        border-spacing: 10px !important;
    }

    .address {
        width: 10px !important;
    }
</style>

<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tr>

                <td class="left-data">
                    @php
                        $imagePath = file_exists(public_path('images/Employees/profile/' . $data->image))
                            ? url(asset('images/Employees/profile/' . $data->image))
                            : url(asset('assets/img/no-image.png'));
                    @endphp
                    <div class="left-data">
                        <div class="image-container">
                            <img src="{{ $imagePath }}" alt="">
                        </div><br>
                        <hr><br>
                        <div class="contact-container">
                            <table class="heading">
                                <tr>
                                    <th>
                                        <img width="40" height="40"
                                            src="https://img.icons8.com/ios/50/6F1187/contact-card.png"
                                            alt="contact-card" />
                                    </th>
                                    <th>
                                        <h2>Contact Information</h2>
                                    </th>
                                </tr>
                            </table><br>

                            <div class="contact-information">
                                <table>
                                    <tr>
                                        <th style="width: 30px!important"><img width="40" height="40"
                                                src="https://img.icons8.com/carbon-copy/100/6F1187/new-post--v2.png"
                                                alt="new-post--v2" /></th>
                                        <th>{{ $data->users->email ?? '' }}</th>
                                    </tr>
                                    <tr>
                                        <th style="width: 30px!important"><img width="40" height="40"
                                                src="https://img.icons8.com/carbon-copy/100/6F1187/new-post--v2.png"
                                                alt="new-post--v2" /></th>
                                        <th>{{ $data->personal_email ?? '' }}</th>

                                    </tr>
                                    <tr>
                                        <th><img width="30" height="30"
                                                src="https://img.icons8.com/wired/30/6F1187/phone.png" alt="phone" />
                                        </th>
                                        <th>{{ $data->personal_contact ?? '' }}</th>
                                    </tr>
                                    <tr>
                                        <th><img width="35" height="35"
                                                src="https://img.icons8.com/dotty/35/6F1187/marker.png"
                                                alt="marker" /></th>
                                        <th class="address"> {{ $data->present_address ?? '' }}</th>
                                    </tr>

                                </table>
                            </div>
                        </div>
                        <div class="contact-container">
                            <table class="heading">
                                <tr>
                                    <th>
                                        <img width="40" height="40"
                                            src="https://img.icons8.com/dotty/40/6F1187/phone-contact.png"
                                            alt="phone-contact" />
                                    </th>
                                    <th>
                                        <h2>Emergency Contact</h2>
                                    </th>
                                </tr>
                            </table><br>

                            <div class="emergency-contact">
                                <table>

                                    <tr>
                                        <th>
                                            <img width="40" height="40"
                                                src="https://img.icons8.com/dotty/40/6F1187/user.png" alt="user" />
                                        </th>
                                        <th>{{ $data->emergency_contact_person ?? '' }}</th>
                                    </tr>
                                    <tr>
                                        <th><img width="35" height="35"
                                                src="https://img.icons8.com/ios/35/6F1187/collaboration.png"
                                                alt="collaboration" /></th>
                                        <th>{{ $data->emergency_contact_relation ?? '' }} </th>
                                    </tr>
                                    <tr>
                                        <th><img width="30" height="30"
                                                src="https://img.icons8.com/wired/30/6F1187/phone.png" alt="phone" />
                                        </th>
                                        <th>{{ $data->emergency_contact ?? '' }}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>

                    </div>
                </td>
                <td>
                    <div class="title-container">
                        <h1>{{ $data->first_name ?? '' }} {{ $data->last_name ?? '' }}</h1>
                        <h3>{{ $data->designations->name ?? '' }}</h3>
                        <hr>
                    </div>
                    {{-- Qualification Container --}}
                    <div class="qualification-container">


                        @if (!empty($data->qualifications))
                            <table class="heading">
                                <tr>
                                    <th><img width="40" height="40"
                                            src="https://img.icons8.com/ios/40/6F1187/certificate--v1.png"
                                            alt="certificate--v1" /></th>
                                    <th>
                                        <h2>Qualification</h2>
                                    </th>
                                </tr>
                            </table>

                            @foreach ($data->qualifications as $key => $item)
                                <div class="qualifications">
                                    <h4>{{ $item->qualification ?? '' }}</h4>
                                    <table>
                                        <tr>
                                            <th>Institute</th>
                                            <th>{{ $item->institute ?? '' }}</th>
                                        </tr>
                                        <tr>
                                            <th>Qualification</th>
                                            <th>{{ $item->qualification ?? '' }}</th>
                                        </tr>
                                        <tr>
                                            <th>Date</th>
                                            <th>{{ \Carbon\Carbon::parse($item->start_date ?? '')->format('Y/F/d') }} -
                                                {{ \Carbon\Carbon::parse($item->end_date ?? '')->format('Y/F/d') }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>GPA</th>
                                            <th>{{ $item->gpa ?? '' }}</th>
                                        </tr>
                                        <tr>
                                            <th>Percentage</th>
                                            <th>{{ $item->percentage . '%' ?? '' }}</th>
                                        </tr>
                                    </table>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- End of Qualification Container --}}
                    {{-- Experience Container --}}
                    <div class="experience-container">
                        @if (!empty($data->experiences))

                            <table class="heading">
                                <tr>
                                    <th><img width="40" height="40"
                                            src="https://img.icons8.com/external-tal-revivo-regular-tal-revivo/40/6F1187/external-businessman-with-breifcase-isolated-on-white-background-company-regular-tal-revivo.png"
                                            alt="external-businessman-with-breifcase-isolated-on-white-background-company-regular-tal-revivo" />
                                    </th>
                                    <th>
                                        <h2>Job experience</h2>
                                    </th>
                                </tr>
                            </table>
                            @foreach ($data->experiences as $key => $value)
                                <div class="experience">
                                    <h4>{{ $value->designation ?? '' }}</h4>
                                    <table>
                                        <tr>
                                            <th>Company Name</th>
                                            <th>{{ $value->job_title ?? '' }}</th>
                                        </tr>
                                        <tr>
                                            <th>Designation</th>
                                            <th>{{ $value->designation ?? '' }}</th>
                                        </tr>
                                        <tr>
                                            <th>From</th>
                                            <th>{{ \Carbon\Carbon::parse($value->start_date ?? '')->format('Y/F/d') }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>To</th>
                                            <th>{{ \Carbon\Carbon::parse($value->end_date ?? '')->format('Y/F/d') }}
                                            </th>
                                        </tr>
                                        <tr>
                                            <th>Previous Salary</th>
                                            <th>{{ 'PKR,' . $value->salary ?? '' }}</th>
                                        </tr>
                                    </table>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    {{-- End of Experience Container --}}
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
