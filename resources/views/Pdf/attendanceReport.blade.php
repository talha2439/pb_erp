<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    *{
        font-family: sans-serif;

    }
    table{
        width: 100%;
    }
    th{
        border:1px solid rgb(95, 95, 95);
        white-space: nowrap!important;
        background-color: rgb(102, 4, 102);
        color: white;
        padding: 10px;
    }
    td{
        border:1px solid purple!important;
        white-space: nowrap!important;
        padding: 10px;

    }
    .container{
        border: 1px solid rgba(0, 0, 0, 0.329)!important;
        padding: 10px;
        border-radius: 10px;
    }
    .table-data{
        min-height: 500px
    }
    .generatedDate{
        padding: 10px;

    }

</style>
<body>
    @php
        $totalWorkingHoursAllEmployees  = 0 ;
    @endphp
        <div>
        <h1 style="text-align:center"> Attendance {{ ucfirst($data['type']) }} Report</h1>
        <p style="text-align:center">This is the {{ ucfirst($data['type']) }} report for employee :  <b>{{ ucfirst($data->first_name) ?? '' }}</b></p>
        </div> <br><div class="generatedDate"><b>Generated Date: </b> {{ \Carbon\Carbon::now()->format('F d , Y') }}</div>
    <div class="container">
        <table class="table-data">
            <tr>
                <th >
                   EMP#ID
                </th>
                <th >
                    NAME
                </th>
                <th >
                   DEPARTMENT
                </th>
                <th >
                   DATE & DAY
                </th>
                <th >
                   IN-OUT
                </th>
                <th >
                    WORK STATUS
                </th>
                <th >
                   WORK HOURS
                </th>
            </tr>
            <tbody>
                @foreach ($data->attendance as $key => $item)
                <tr>
                    <td >
                        {{ $item->users->employees->emp_uniq_id ?? ""}}
                    </td>
                    <td >
                        {{ $item->users->employees->first_name ?? ""}}
                    </td>
                    <td >
                        {{ $item->users->employees->departments->name ?? ""}}
                    </td>
                    <td >
                        {{ $item->date . ' / ' . \Carbon\Carbon::parse($item->date ?? "")->format("l") ?? ""}}
                    </td>
                    <td >
                        {{ $item->check_in . ' - ' . $item->check_out ?? ""}}
                    </td>
                    <td >
                        @if(\Carbon\Carbon::parse($item->date)->format('l') == 'Sunday') Off-Day @else {{ $item->working_status ?? ""}} @endif
                    </td>
                    <td >
                        @php
                        $totalWorkingHours = 0;

                        preg_match('/(\d+)\s*hour/', $item->working_hours, $hourMatches);
                        preg_match('/(\d+)\s*minute/', $item->working_hours, $minuteMatches);

                        $hours = isset($hourMatches[1]) ? (int)$hourMatches[1] : 0; // hours as integer
                        $minutes = isset($minuteMatches[1]) ? (int)$minuteMatches[1] : 0; // minutes as integer

                        // Convert hours to minutes
                        $totalMinutes = $hours * 60 + $minutes;

                        // Convert total minutes to hours and minutes
                        $totalHours = floor($totalMinutes / 60);
                        $remainingMinutes = $totalMinutes % 60;
                        $totaltime = "$totalHours hours $remainingMinutes minutes";

                        // Add current employee's total working hours to overall total
                        $totalWorkingHoursAllEmployees += $totalMinutes;
                        @endphp

                        @if(\Carbon\Carbon::parse($item->date)->format('l') == 'Sunday') Off-Day @else {{ $totaltime }} @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
       <table>
        <tr >

                <th style="background-color:black ;color:white; height: 30px!important; width:max-content;"><b>Total Working Hours: </b>{{ floor($totalWorkingHoursAllEmployees / 60) }} hours {{ $totalWorkingHoursAllEmployees % 60 }} minutes</th>

        </tr>
       </table>
    </div>

</body>
</html>
