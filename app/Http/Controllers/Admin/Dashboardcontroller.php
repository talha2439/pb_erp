<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Dashboardcontroller extends Controller
{
    public $parentView = 'Admin.';
    public function index(){
        try{
            $data['attendance'] = Attendance::where(['employee_id' => Auth::user()->id , 'date' => Carbon::now()->format('Y-m-d')])->first();
            return view($this->parentView.'dashboard' ,  $data);
        }
        catch(\Exception $e){
            return redirect(route('auth.login'))->with('error', $e->getMessage());
        }
    }
}
