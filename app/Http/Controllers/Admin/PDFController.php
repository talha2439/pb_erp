<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Barryvdh\Snappy\PdfWrapper;
use Illuminate\Http\Request;
use Elibyy\TCPDF\Facades\TCPDF as PDF;
use Carbon\Carbon;
class PDFController extends Controller
{
    public function attendance_report(Request $request){
        $data = Employee::where('id' , $request->employee_id)->with(['attendance' => function($query) use ($request) {
            if (!empty($request->month)) {
                $query->whereMonth('date', $request->month);

            }
            if (!empty($request->year)) {
                $query->whereYear('date', $request->year);
            }
        }])->first();
        $type =  empty($request->month) && !empty($request->year) ? 'Yearly' : 'Monthly';
        $html = view()->make('Pdf.attendanceReport', ['data' =>$data ,'type' => $type ])->render();
        $pdf  = new PDF;
        $pdf::setTitle(str_replace(" " , "-" ,strtolower($data->first_name) ).'-attendanceReport');
        $pdf::SetPageOrientation('landscape');
        $pdf::AddPage();
        $pdf::writeHTML($html , true , false, true, false, '');
        $pdf::Footer("All rights Reserved by " . config('setting.site_name'));
        $pdf::Header("Generated Date:" . Carbon::now()->format(' F d , Y '));
        return $pdf::Output(str_replace(" " , "-" ,strtolower($data->first_name) ).'-attendance.pdf' , 'I');

    }
}
