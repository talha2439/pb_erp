<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Employee;
use Carbon\Carbon;
use Auth;
class AttendanceController extends Controller
{
    public $parentModel = Attendance::class;
    public $childModel  = Employee::class;
    public function checkin(Request $request){
      try{
        $data = $request->except('_token');
        $data['employee_id'] = Auth::user()->id;
        $data['date']        = Carbon::now()->format('Y-m-d');
        $data['check_in']    = Carbon::parse($data['check_in'])->format('h:i A');
        $data['attendance_status']            ="present" ;

        $checkEmployee = $this->childModel::where('user_id', $data['employee_id'])->first();
        // To Check if the user is a valid staff member in Company not a user or an admin
        if(empty($checkEmployee)){
           return response()->json(['empty'=> true]);
        }
        $checkAttendance  = $this->parentModel::where(['employee_id' => $data['employee_id'] , 'date' => $data['date']])->first();
        if(empty($checkAttendance)){
            $storeAttendance = $this->parentModel::create($data);
            if($storeAttendance){
            return response()->json(['success' => true]);}
            else{
                return response()->json(['error' => true]);
            }
        }
        else{
            return response()->json(['marked' => true]);
        }
      }
      catch(\Exception $e){
        return response()->json(['error' => $e->getMessage()]);
      }


    }
}
