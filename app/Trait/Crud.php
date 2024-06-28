<?php
namespace App\Trait;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Knp\Snappy\Pdf as PDF;
use Barryvdh\Snappy\PdfWrapper;

trait Crud {
    public static function columns($table){
        $columns = Schema::getColumnListing($table);
        return $columns;
    }
    public static function notification($subject  , $data ,  $type , $relations = null){
        $created_at   = Carbon::parse($data->created_at)->format('F d, Y h:i:s A');
        $allData = $data;
        if(!empty($relations)){
        $allData =   $data->with($relations)->first();
        }
        $storeNotification = [
            'subject' => $subject,
            'user_id' => $data->user_id,
            'created_at' => $created_at,
            'data' =>  json_encode($allData),
            'type' => $type,
        ];

        return $storeNotification;
    }
    public static function PDFgenerate($filename ,$view ,$data ,  $orientation){
        try{
            $pdf = new PDF(config('snappy.pdf.binary'));
            $pdfWrapper = new PdfWrapper($pdf);
            $render = view($view , ['data' => $data] ); // Render the view to HTML
            $pdfWrapper->setOptions(['javascript-delay' => 1000,'page-size' => 'A4','title' => $filename , 'orientation' => $orientation]);
            $pdfWrapper->loadHTML($render); // Load the HTML content into the PDF wrapper
            return  $pdfWrapper->inline($filename);
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
