<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Barryvdh\Snappy\PdfWrapper;
use PDF;
class PDFController extends Controller
{
    public function employee_cv($id){
        $id  = decrypt($id);
        $data = Employee::where('id',$id)->first();
        $pdf = new PDF();
        $pdf::loadView('Pdf.employee_cv',['employee' => $data]); ;
        return $pdf::inline();
    }
}
