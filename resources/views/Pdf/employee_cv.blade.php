<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        *{
            font-family: sans-serif ;
            padding: 10px
        }
    </style>
</head>
<body>
    <div class="main-container" style="min-height:1270px; max-height:auto; height:auto; border:1px solid rgba(128, 128, 128, 0.356);  border-radius:5px;">
        <div class="display" style="display:flex!important">
            <table>
                <tbody>
                    <tr>
                        <td>
                            @php

                            @endphp
                            <div  style="min-height:250px;">
                                <img src="" alt=""
                                style="min-height:250px; min-width:250px; max-width:250px; object-fit:cover; border:1px solid rgba(128, 128, 128, 0.356);  border-radius:5px;">
                            </div>
                            <div class="ml-3" style="border: 1px solid black">
                                <h4 class="fw-bold mt-3">Contact Information</h4>
                                <table>
                                    <tr>
                                        <td>
                                            <tr> Email: {{ $employee->personal_email }}</tr>
                                        </td>


                                    </tr>
                                    <tr>
                                        <td>
                                             Phone: {{ $employee->personal_contact }}
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                        <td>
                        <div class="text col-md-8  col-12" style="position: relative;bottom:20px">
                                    <h1 class=" " style="font-weight: bold; text-transform:uppercase">
                                        {{ $employee->first_name }} {{ $employee->last_name }}
                                    </h1>
                                    <h5>{{ ucfirst($employee->designations->name) }}</h5>
                        </div>
                        <table>

                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
