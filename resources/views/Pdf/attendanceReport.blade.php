<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<style>
    th{
        border:1px solid rgb(95, 95, 95);
        white-space: nowrap!important;
        background-color: rgb(102, 4, 102);
        color: white;
    }
    td{
        border:1px solid purple!important;
        white-space: nowrap!important;
        padding: 10px;

    }
</style>
<body>
    @php
        $totalWorkingHoursAllEmployees  = 0 ;
    @endphp
        <div>
        <h1 style="text-align:center"> Attendance {{ ucfirst($type) }} Report</h1>
        <small style="padding:10px ; text-align:center">This is the {{ ucfirst($type) }} report for employee :  <b>{{ ucfirst($data->first_name) ?? '' }}</b></small>
        </div> <br>
        <table>
            <tr>
                <th style="background-color:black ;color:white; height: 30px!important; line-height:22px;">
                   EMP#ID
                </th>
                <th style="height: 30px!important; line-height:22px;">
                    NAME
                </th>
                <th style="height: 30px!important; line-height:22px;">
                   DEPARTMENT
                </th>
                <th style="height: 30px!important; line-height:22px;">
                   DATE & DAY
                </th>
                <th style="height: 30px!important; line-height:22px;">
                   IN-OUT
                </th>
                <th style="height: 30px!important; line-height:22px;">
                    WORK STATUS
                </th>
                <th style="height: 30px!important; line-height:22px;">
                   WORK HOURS
                </th>
            </tr>
            <tbody>
                @foreach ($data->attendance as $key => $item)
                <tr>
                    <td style="height: 30px!important; line-height:29px!important; font-size:8px">
                        {{ $item->users->employees->emp_uniq_id ?? ""}}
                    </td>
                    <td style="height: 30px!important; line-height:29px!important; font-size:10px">
                        {{ $item->users->employees->first_name ?? ""}}
                    </td>
                    <td style="height: 30px!important; line-height:29px!important; font-size:10px">
                        {{ $item->users->employees->departments->name ?? ""}}
                    </td>
                    <td style="height: 30px!important; line-height:29px!important; font-size:8px">
                        {{ $item->date . ' / ' . \Carbon\Carbon::parse($item->date ?? "")->format("l") ?? ""}}
                    </td>
                    <td style="height: 30px!important; line-height:29px!important; font-size:10px">
                        {{ $item->check_in . ' - ' . $item->check_out ?? ""}}
                    </td>
                    <td style="height: 30px!important; line-height:29px!important; font-size:10px">
                        @if(\Carbon\Carbon::parse($item->date)->format('l') == 'Sunday') Off-Day @else {{ $item->working_status ?? ""}} @endif
                    </td>
                    <td style="height: 30px!important; line-height:29px!important; font-size:10px">
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
</body>
</html>
