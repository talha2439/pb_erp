<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeePayrollController extends Controller
{
    public $parentModel  =  Employee::class;
    public $menuModel    =  SubMenu::class;
    public $childModel   =  Payroll::class;
    public $parentView   = 'Admin.payroll';
    public $parentRoute = 'payroll';
    public function index(){
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'view_status');
            if($checkAccess){
                $data['employee'] = $this->parentModel::latest()->get();
                return view($this->parentView.'.index', $data);
            }
                else{
                    abort(405);
                }
            }
            catch(\Exception $e){
                return redirect()->back()->with('error', $e->getMessage());
            }
    }
    public function create($id = null){
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'create_status');
            if($checkAccess){
                $data['payroll']      = $this->childModel::where('id' , $id)->first();
                $data['employees']   = $this->parentModel::latest()->get();
                $data['action']   = !empty($data['payroll']) ? 'edit' : 'create';
                return view($this->parentView.'.create',$data);
            }
            else{
                abort(405);
            }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function store(Request $request , $id = null){
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            if(!empty($id)){
                $checkAccess = $this->check_access($submenuId->id, 'update_status');
            }
            else{
                $checkAccess = $this->check_access($submenuId->id, 'create_status');
            }
            if($checkAccess){
            $data = $request->except('_token');
            $data['ref_number'] =  000 . $data['employee_id'];
            if($data['total_absents'] > 0 ){
                $data['total_deduction'] = $data['total_absents'] * $data['per_absents_deduction'];
            }
            if($data['total_lates'] > 0 ){
                $data['total_deduction'] += $data['per_absents_deduction'] / 2 * $data['total_lates'];
            }
            if($data['total_early_outs'] > 0 ){
                $data['total_deduction'] += $data['per_absents_deduction'] / 2 * $data['total_early_outs'];
            }
            $data['over_all_salary'] = (  $data['gross_salary'] +  $data['loan_amount'] + $data['bonus_amount'] ) - $data['total_deduction'];
            $employeedata = $this->parentModel::where('id' ,$data['employee_id'])->first();
            $attendance = Attendance::where('employee_id', $employeedata->user_id)->whereMonth('date' ,  '<' , Carbon::now()->month)->pluck('total_hours');
            $totalHours = explode('hours', $attendance[0]);
            $totalMinutes = explode('minutes', $attendance[0]);
            $totalMinutes = explode('hours', $totalMinutes[0]);
            $totalMinutes = explode(" ",  $totalMinutes[1]);
            $data['total_hours_worked'] = (int) $totalHours[0];
                $storePayroll = $this->childModel::updateOrCreate(['id' => $id , $data]);
                if($storePayroll){
                    $subject = !empty($id) ? 'Payroll Information Updated' : 'Payroll  Information Generated';
                    $route = route('payroll.create', encrypt($storePayroll->id));
                    $storeNotification =  $this->parentModel::notification($subject ,  $route  , $storePayroll->created_at );
                    event(new Notifications($storeNotification));
                    return redirect(route('payroll.index'))->with('success','Payroll information saved!');
                }
                else{
                    return redirect()->route($this->parentRoute.'.index')->with('error', 'Failed to save Payroll information');
                }

             }
            else{
                abort(405);
            }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
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
