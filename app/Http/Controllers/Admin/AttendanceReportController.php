<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use DataTables;
class AttendanceReportController extends Controller
{
    public $parentModel  = Attendance::class;
    public $parentView   = 'Admin.attendance.reports';
    public $parentRoute  = 'attendance.reports';

    public function index(){
        try{
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.all')->first();
            $checkAccess = $this->check_access($submenuId->id, 'view_status');
            if ($checkAccess) {
                $data['attendance']  = $this->parentModel::withoutTrashed()->where('date' , Carbon::now()->format('Y-m-d'))->get();
                $data['employees']   = Employee::all();
                $data['departments'] = Department::withoutTrashed()->get();
                return view($this->parentView . '.index', $data);
            } else {
                abort(405);
            }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function reports(Request $request){

        $data = $this->parentModel::latest();
        if(!empty($request->daterange)){
        $date = explode('-', $request->daterange);
        $startDate = Carbon::parse($date[0])->format('Y-m-d');
        $endDate = Carbon::parse($date[1])->format('Y-m-d');
        $data = $this->parentModel::whereBetween('date', [$startDate , $endDate]);
        }
        if(empty($request->employee) && empty($request->department) && empty($request->month) && empty($request->year) && empty($request->daterange))
        {
            $data = $data->where('date',  Carbon::now()->format('Y-m-d'));
        }
        if(!empty($request->employee)){
            $data = $data->where('employee_id', $request->employee);
        }
        if(!empty($request->department)){
            $data = $data->whereHas('users.employees.departments', function($query) use ($request){
                $query->where('department', $request->department);
            });
        }
        if(!empty($request->month)){
            $data = $data->whereMonth('date', $request->month);
        }
        if(!empty($request->year)){
            $data = $data->whereYear('date', $request->year);
        }
        $result = $data->get();
        return DataTables::of($result)->addColumn('DT_RowIndex' ,function($i) use (&$seriesnumber){
            $seriesnumber ++ ;
            return $seriesnumber;
        })->addColumn('employee_id' , function($item){
           $employee_id = $item->users->employees->emp_uniq_id ?? "";
            return $employee_id;
        })->addColumn('employee_name' , function($item){
            $employee_name = $item->users->employees->first_name ?? "";
            return $employee_name;
        })->addColumn('department' , function($item){
            $department = $item->users->employees->departments->name?? "";
            return $department;
        })->addColumn('date', function($item){
            return $item->date;
        })->addColumn('attendance_status' , function($item){
            $blinkclass = 'warning';
            if($item->attendance_status == strtolower('present')){
                $blinkclass = 'success';
            }
           else if($item->attendance_status == strtolower('Absent')){
                $blinkclass = 'danger';
            }
            else if($item->attendance_status == strtolower('Leave')){
                $blinkclass = 'info';
            }
            else if($item->attendance_status == strtolower('off')){
                $blinkclass = 'secondary';
            }
            return '<span class="blink blink-'.$blinkclass.'">'.$item->attendance_status.'</span>';
        })->addColumn('checkin_checkout', function($item){
            $checkout = !empty($item->check_out) && $item->check_out != null ? Carbon::parse($item->check_out)->format('h:i A') : "";
            $checkin = !empty($item->check_in) && $item->check_in ? Carbon::parse($item->check_in)->format('h:i A') : "";
            $checkin  =  $checkin .' - '. $checkout ;
            if($item->attendance_status == strtolower('Leave')){
                $checkin ='On-leave';
            }
            if($item->attendance_status == strtolower('off')){
                $checkin ='Off-Day';
            }
            return $checkin;
        })->addColumn('working_hours', function($item){
            $workinghours = $item->working_hours ?? '0 hours' ;
            return $workinghours;
        })
        ->addColumn('extra_hours', function($item){
            $extra_hours = $item->extra_hours ?? '0 hours' ;
            return $extra_hours;
        })
        ->addColumn('total_hours', function($item){
            $total_hours = $item->total_hours ?? '0 hours' ;
            return $total_hours;
        })
        ->addColumn('working_status' , function($item){
            $blinkclass = '';
            $workingStatus = "";
            $totalHours = explode(" " ,$item->total_hours);
            if(!empty($item->check_in) && empty($item->check_out) && $item->working_status == strtolower('on-time') || $item->working_status == strtolower('early-in') &&  $item->working_status != strtolower('early-in and early-out')){
                $blinkclass = 'success';
                $workingStatus = 'On-time';
            }
            else if(!empty($item->check_in) &&!empty($item->check_out) && $totalHours[0] >= 9 && empty($item->extra_hours)){
                $blinkclass ='success';
                $workingStatus = 'Full-time';
            }
            else if(!empty($item->check_in) &&!empty($item->check_out) && $totalHours[0] < 9 ){
                $blinkclass ='danger';
                $workingStatus = 'Half-time';
            }
            else if($item->working_status == strtolower('late and early-out') || $item->working_status == strtolower('early-in and early-out') || $item->working_status == strtolower('early-out')){
                $blinkclass = 'danger';
                $workingStatus = 'Half-time';
            }
            else if($item->working_status == strtolower('late-setting')){
                $blinkclass = 'info';
                $workingStatus = 'Over-time';

            }
            else if($item->working_status == strtolower('Leave')){
                $blinkclass = 'info';
                $workingStatus = 'on-leave';

            }
            else if($item->working_status == strtolower('off')){
                $blinkclass = 'secondary';
                $workingStatus = "Off";
            }
            else if($item->working_status == strtolower('late')){
                $blinkclass = 'danger';
                $workingStatus = "Late";
            }
            return '<span class="blink blink-'.$blinkclass.'">'.$workingStatus.'</span>';

        })->addColumn('action' , function($item){
            $editRoute = route('attendance.create', $item->id);
            $checkAuth = Auth::user()->role == 1 ? '' : 'disabled';
            $action =  '
             <a class="btn btn-success text-white '. $checkAuth .' " href="'.$editRoute.'"> <i
            class="fe fe-edit"></i></a>';
            return $action;
        })
        ->rawColumns(['DT_RowIndex' ,'extra_hours' , 'total_hours' , 'employee_id' , 'employee_name' ,'department','date','attendance_status','checkin_checkout','working_hours','working_status','action'])->make(true);
    }
    public function check_access($subMenuId, $status)
    {
        $checkAccess =  UserAccess::where(['sub_menu_id' => $subMenuId, $status => 1, 'user_id' => Auth::user()->id])->first();
        $checkAdmin  = User::where(['id' => Auth::user()->id, 'role' => 1])->count();
        if ($checkAdmin > 0) {
            return true;
        }
        if ($checkAccess) {
            return true;
        } else {
            return false;
        }
    }

}
