<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Leave Application</title>
</head>
<style>
    *{
        font-family: sans-serif
    }
    .main-container{
        position: relative;
        padding: 20px;
        min-height: 1000px;
        height: auto;
        border:1px solid #ccc;
        border-radius: 10px;
    }
    .heading {
        border-bottom: 3px solid purple !important;
        width: 100px !important;
        text-align: center
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
    .info-container{
        padding: 10px;
        border-bottom: 1px solid #ccc;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
    }
    .message-container{
        padding: 10px;
        background: #F5F5F5;
        border-radius: 5px;;
        margin-top: 20px;
        margin-bottom: 50px;
        min-height: 400px;
        height: auto;
        border: 1px solid #686868;
    }
    .status-container{
        position: fixed;
        top: 20%;
        right:15%;
    }
    .status-container img{
        position: relative;

    }
    .heading-section{
        margin: 0;
    }
    .heading-section h5{
        background: rgb(128, 0, 128);
        font-size:20px;
        padding: 10px 10px ;
        margin: 0;
        margin-top:10px;
        margin-bottom:5px;
        color: white;
        text-transform: uppercase;
        border-radius: 5px;
    }
</style>
<body>
    <div class="main-container">
        <table class="heading">
            <tr>
                <th>

                        <img width="40" height="40" src="https://img.icons8.com/dotty/80/6F1187/leave.png" alt="leave"/>
                </th>
                <th>
                    <h2>Leave Application</h2>
                </th>
            </tr>
        </table><br>
        {{-- Application Information --}}
        <div class="info-container">
            <h4> <img width="30" height="30"
                src="https://img.icons8.com/ios/50/6F1187/contact-card.png"
                alt="contact-card" style="position: relative;top:10px;" /> | Applicant Name: <b>{{ ucfirst($data->employees->first_name . " " . $data->employees->last_name) ?? ""  }}</b></h4>
            <h4><img width="35" height="30" src="https://img.icons8.com/dotty/50/6F1187/calendar.png"  style="position: relative;top:10px;" alt="calendar"/>| Date: <b>{{ \Carbon\Carbon::parse($data->created_at)->format('d F, Y') }}</b></h4>
            <h4><img width="35" height="30" src="https://img.icons8.com/dotty/50/6F1187/leave.png" style="position: relative;top:10px;" alt="leave"/>| Leave Type: <b>{{ $data->leave_type ?? ""}}</b></h4>
            <h4><img width="30" height="30" src="https://img.icons8.com/dotty/50/6F1187/user.png"  style="position: relative;top:8px;"alt="user"/>| Applied by: <b>{{ $data->applied->name ?? ""}}</b></h4>
            <h4><img width="35" height="30" src="https://img.icons8.com/dotty/50/6F1187/calendar.png"  style="position: relative;top:10px;" alt="calendar"/>| Requested Dates: <b>{{ \Carbon\Carbon::parse($data->from)->format('d F, Y') }} - {{ \Carbon\Carbon::parse($data->to)->format('d F, Y') }}</b></h4>
        </div>
        <div class="heading-section">
            <h5><img width="30" height="30" src="https://img.icons8.com/pastel-glyph/64/FFFFFF/secured-letter--v1.png "style="position: relative;top:2px;" alt="secured-letter--v1"/> <span style="position: relative;bottom:8px;">
                | Application</span></h5>
        </div>
        <div class="message-container">
            <p>
               {{ $data->reason }}
            </p>
        </div>
        <div class="status-container">
            @if($data->status == 'Approved' || $data->status == 'approved')
            <span> <center><img width="120" height="120" src="{{ url(asset('assets/img/approve.png')) }}" alt="ok"/></center></span>
            @elseif($data->status == "rejected" || $data->status == "Rejected")
            <img src="{{ url(asset('assets/img/rejected.png')) }}"/>
            @else
            <span> <center><img width="120" height="120" src="{{ url(asset('assets/img/pending.png')) }}" alt="ok"/></center></span>
            @endif
        </div>
    </div>


</body>
</html>
