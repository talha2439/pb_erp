<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use Barryvdh\Snappy\PdfWrapper;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;

class PDFController extends Controller
{
    public $parentModel  = Employee::class ;
    public function attendance_report(Request $request){
        $data = $this->parentModel::where('id' , $request->employee_id)->with(['attendance' => function($query) use ($request) {
            if (!empty($request->month)) {
                $query->whereMonth('date', $request->month);}
            if (!empty($request->year)) {
                $query->whereYear('date', $request->year); }
        }])->first();
        $data['type'] =  empty($request->month) && !empty($request->year) ? 'Yearly' : 'Monthly';
        $view = 'Pdf.attendanceReport';
        $filename = str_replace(" " , "-" ,strtolower($data->first_name) ).'-attendanceReport';
        $generate  = $this->parentModel::PDFgenerate($filename , $view , $data , 'landscape');
        return $generate;
    }
    public function employee_cv($id){
        $id = decrypt($id);
        $data = $this->parentModel::where('id' , $id)->first();
        $view = 'Pdf.employee_cv';
        $filename = str_replace(" " , "-" ,strtolower($data->first_name) ).'-cv';
        $generate  = $this->parentModel::PDFgenerate($filename , $view ,$data ,'portrait');
        return $generate;
    }
}
