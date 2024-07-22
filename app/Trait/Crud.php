<?php
namespace App\Trait;

use App\Events\RoleManagement;
use App\Models\Notification;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Knp\Snappy\Pdf as PDF;
use Barryvdh\Snappy\PdfWrapper;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait Crud {
    public static function columns($table){
        $columns = Schema::getColumnListing($table);
        return $columns;
    }
    public static function notification($subject  , $route ,  $created_at){
        $created_at   = Carbon::parse($created_at)->format('F d, Y h:i A');
        $storeNotification = [
            'subject' => $subject,
            'route' => $route,
            'created_at' => $created_at,
        ];
        Notification::create($storeNotification);
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
    public static function role($status,$route = null ,  $type = null){
        if(!empty($route)){
            $checkSubMenu = SubMenu::where('route' , $route)->first();
            if(!empty($checkSubMenu) && !empty($status)){
                $checkAccess =  UserAccess::where(['sub_menu_id'=> $checkSubMenu->id , $status => 1 , 'user_id' => Auth::user()->id ])->first();
                $checkAdmin  =  User::where(['id' => Auth::user()->id , 'role' => 1])->count();
                if($checkAdmin <= 0 && empty($checkAccess)){
                    if($type == 'response'){

                       return response()->json(['unauthorized' => true]);
                    }
                    else{
                        return abort(403);
                    }
                }
            }
        }
    }
}
