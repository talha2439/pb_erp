<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Auth;

class AttendanceController extends Controller
{
    public $parentModel = Attendance::class;
    public $childModel  = Employee::class;
    public $parentRoute = 'attendance';
    public $parentView   = 'Admin.attendance.reports';
    public $roleRoute    = 'attendance.reports.all';
    public function create($id = null){
        if (!empty($id)) {
            $this->parentModel::role('update_status', $this->roleRoute , null);
        }
        else{
        $this->parentModel::role('create_status', $this->roleRoute , null);
        }

        $data['attendance'] = $this->parentModel::where('id', $id)->with('users' , function($query){
            $query->with('employees');
        })->first();
        if(!empty($data['attendance'])){
        $data['attendance']->check_in  =  !empty($data['attendance']->check_in) && $data['attendance']->check_in != 'empty' ? $data['attendance']->check_in: "empty" ;
        $data['attendance']->check_out =  !empty($data['attendance']->check_out) && $data['attendance']->check_out != 'empty' ? $data['attendance']->check_out : "empty" ;
        }
        $data['currentAttendance']  = $this->parentModel::whereDate('date' , Carbon::now())->pluck('employee_id');
        $data['action'] = !empty($data['attendance']) ? 'edit' : 'create';
        $data['employees']          =  $data['action'] == 'create' ? $this->childModel::whereNotIn('user_id' , $data['currentAttendance'])->get():$this->childModel::where('user_id',$data['attendance']->employee_id)->latest()->get();
        return view($this->parentView.'.create', $data);
    }
    public function checkin(Request $request)
    {

        try {
            $data = $request->except('_token');
            $data['employee_id'] = Auth::user()->id;
            $data['date']        = Carbon::now()->format('Y-m-d');

            $data['check_in']    = Carbon::parse($data['check_in'])->format('h:i A');
            $data['attendance_status']  = "present";
            $employee        = $this->childModel::where('user_id', $data['employee_id'])->with('shifts')->first();
            $checkAttendance = $this->parentModel::where(['employee_id' => $data['employee_id'], 'date' => $data['date']])->whereNot('check_in', null )->first();
            if (empty($employee)) {
                return response()->json(['empty' => true]);
            }
            if (empty($checkAttendance)) {
                $shiftIn          = Carbon::parse($employee->shifts->start_time);
                $checkInTime      = Carbon::parse($data['check_in']);
                if($checkInTime->lessThan($shiftIn)) {
                    $data['working_status'] = 'early-in';
                }
                else{
                    $data['working_status'] = 'on-time';
                }
                $storeAttendance = $this->parentModel::updateOrCreate(['employee_id' => $data['employee_id'] , 'date' => Carbon::now()->format('y-m-d')],$data);
                if ($storeAttendance) {
                    return response()->json(['success' => true, 'attendance_id' => $storeAttendance->id]);
                } else {
                    return response()->json(['error' => true]);
                }
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }

    }

    public function checkout(Request $request)
    {
        try {

            $emp_id         =  Auth::user()->id;
            $date           =  Carbon::now()->format('Y-m-d');
            $ShiftHours     =  9 * 60 * 60 * 1000;
            $data           =  $request->except('_token');
            $attendanceData =  $this->parentModel::where(['employee_id' => $emp_id, 'date' => $date])->first();
            $checkIn        =  $attendanceData->check_in;
            $checkIn        =   Carbon::parse($checkIn);
            $checkout       =   Carbon::parse($data['check_out']);
            $data['timeElapsed']  =  $checkout->diffInMilliseconds($checkIn);

            if ($attendanceData->count() > 0) {
                $data['working_hours']  = round($data['timeElapsed'] / (1000 * 60 * 60), 2);
                $data['working_status'] = $ShiftHours == $data['timeElapsed'] && !$ShiftHours < $data['timeElapsed'] ? 'on-time' : 'late';
                if ($data['working_hours'] > 9) {
                    $data['working_status'] = 'late-setting';
                    $data['extra_hours']    = round($data['working_hours'] - 9, 1);
                    $data['extra_hours']    = $data['extra_hours'] < 1 ? $data['extra_hours'] * 60 . " minutes" : $data['extra_hours'] . " hours";
                }
                else if ($data['working_hours'] < $ShiftHours) {
                    $shiftData = Employee::where('user_id', $emp_id)->with('shifts')->first();
                    $shiftIn  = Carbon::parse($shiftData->shifts->start_time);
                    $shiftOut = Carbon::parse($shiftData->shifts->end_time);
                    if($checkIn >= $shiftIn){
                        $shiftIntimedifference = $checkIn->diffInMinutes($shiftIn);
                        if($shiftIntimedifference > 30 && $checkout < $shiftOut){
                            $data['working_status'] = 'late and early-out';
                        }
                        else if($shiftIntimedifference > 30){
                            $data['working_status'] = 'late';
                        }
                        else if($checkout < $shiftOut){
                            $data['working_status'] = 'early-out';
                        }
                        else{
                            $data['working_status'] = 'on-time';
                        }
                    }
                    else if($checkIn < $shiftIn && $checkout < $shiftOut ){
                            $data['working_status'] = 'early-in and early-out';
                    }

                    else {
                        $data['working_status'] = 'early-out';
                    }

                }
                else{
                    $data['working_status'] = 'on-time';
                }

                $data['working_hours']  = $data['working_hours'] < 1 ? $data['working_hours'] * 60 . ' minutes' : $data['working_hours'] . " hours";
                $data['total_hours']    = $data['working_hours'];
                unset($data['timeElapsed']);
                $updateAttendance        = $attendanceData->update($data);
                if ($updateAttendance) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => true]);
                }
            } else {
                return response()->json(['error' => "Failed to checkout no attendance found for the specified Employee"]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }}

        public function store(Request $request, $id = null){
            if (!empty($id)) {
                $this->parentModel::role('update_status', $this->roleRoute , null);
            }
            else{
            $this->parentModel::role('create_status', $this->roleRoute , null);
                 }
            try{
                $data = $request->except("_token");
                $employees = $this->childModel::where('id', $data['employee_id'])->first();
                $data['employee_id']  = $employees->user_id;
                $data['date'] =   isset($data['date'])  ? Carbon::parse($data['date'])->format('Y-m-d') : Carbon::now()->format('Y-m-d');
                $checkAttendance = $this->parentModel::where(['employee_id' => $data['employee_id'] , 'date'=> $data['date'] ])->count();
               if(empty($id)){
                if($checkAttendance > 0 ){
                    return redirect()->back()->with('error' , "Attendance already marked for: " . " " .$employees->first_name);
                }
               }
                if(!empty($id)){
                    $data['working_hours']  = $data['working_hours'] ."hours". " " . $data['working_minutes'] . 'minutes';
                    $data['total_hours']    = $data['working_hours'];
                    if($data['working_status'] == 'late-setting'){
                        $data['total_hours']    = (int) $data['working_hours'] + ((int) $data['extra_hours']) . ' hours';

                        $data['extra_hours']   = $data['extra_hours'] . "hours" ." ". $data['extra_minutes']."minutes";
                    }
                    unset($data['working_minutes']);
                    unset($data['extra_minutes']);
                }
                $data['working_hours'] = $data['check_out'] == null && $data['working_hours'] == "NaN" ? '0' : $data['working_hours'];
                $data['check_in'] = $data['check_in'] == null ? 'empty' :Carbon::parse($data['check_in'])->format('H:i A');
                $data['check_out'] = $data['check_out'] == null ? 'empty' : Carbon::parse($data['check_out'])->format('H:i A');
                $markAttendance  = $this->parentModel::updateOrCreate(['id' => $id] , $data);
                if($markAttendance){
                    return redirect(route($this->parentRoute.'.reports.all'))->with('success','Attendance Marked for:' ." " . ucfirst($employees->first_name));
                }
                else{
                    return redirect()->back()->with('error' , "Failed to Mark Attendance");
                }
            }
            catch(\Exception $e){
                return redirect()->back()->with('error' , $e->getMessage());
            }

        }
        public function mark_holidays(Request $request){
            $role = $this->parentModel::role('create_status',$this->roleRoute,'response');
            if(!empty($role)){
                return $role;
            }
            try{
                      $data  = $request->except("_token");

                    $employees =  $this->childModel::latest()->pluck('user_id');
                    $carbonDateRange = [];
                    $dates           = Carbon::parse($data['start_date'])->daysUntil($data['end_date']);
                    foreach($dates as $date){
                        $carbonDateRange[] = $date->format('Y-m-d');
                    }
                    foreach($carbonDateRange as $carbonDate){
                        $checkData = $this->parentModel::whereDate("date",$carbonDate)->pluck('id');
                        if($checkData->count() > 0){
                            $storeAttendance = $this->parentModel::whereIn('id' , $checkData)->update(['attendance_status' => 'off' , 'working_status' => 'off','working_hours' => '0hours 0minutes',
                                'total_hours' => '0hours 0minutes',
                                'extra_hours' => '0hours 0minutes',]);
                        }
                        else{
                        foreach( $employees  as $ids){
                            $storeAttendance = $this->parentModel::create([
                                'employee_id' => $ids ,
                                'date' => $carbonDate,  // Assuming all holidays are on same day
                                'attendance_status' => 'off', // Off means Holidays
                                'working_status'=>'off',// Off means Holidays
                                'working_hours' => '0hours 0minutes',
                                'total_hours' => '0hours 0minutes',
                                'extra_hours' => '0hours 0minutes',
                            ]);
                        }
                        }

                    }
                    if($storeAttendance){
                        return response()->json(['success' => true]);
                    }
                    else{
                        return response()->json(['error' => true]);
                    }


            }
            catch(\Exception $e){
                return response()->json(['error' => $e->getMessage()]);
            }
        }

}
