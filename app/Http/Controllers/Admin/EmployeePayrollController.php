<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Payroll;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class EmployeePayrollController extends Controller
{
    public $parentModel  =  Employee::class;
    public $menuModel    =  SubMenu::class;
    public $childModel   =  Payroll::class;
    public $parentView   = 'Admin.payroll';
    public $parentRoute = 'payroll';
    public function index(){
        try{
                $this->parentModel::role('view_status', null , null);
                $data['employees'] = Auth::user()->role == 4   ? $this->parentModel::where('employee_id' , Auth::user()->employees->id)->latest()->get()->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->first_name . ' ' . $item->last_name
                     ];
                })->pluck('name', 'id') : $this->parentModel::latest()->get()->map(function($item) {
                    return [
                        'id' => $item->id,
                        'name' => $item->first_name . ' ' . $item->last_name
                     ];
                })->pluck('name', 'id');
                $data['departments'] = Department::latest()->pluck('name', 'id');
                return view($this->parentView.'.index', $data);

            }
            catch(\Exception $e){
                return redirect()->back()->with('error', $e->getMessage());
            }
    }
    public function create($id = null){
        try{
            if(!empty($id)){
                $this->parentModel::role('update_status', null , null);

            }
            else{
                $this->parentModel::role('create_status', null , null);

            }
                $data['payroll']      = $this->childModel::where('id' , $id)->first();
                $data['employees']   = $this->parentModel::latest()->get();
                $data['action']   = !empty($data['payroll']) ? 'edit' : 'create';
                return view($this->parentView.'.create',$data);

        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function store(Request $request , $id = null){
        try{

            if(!empty($id)){
                $this->parentModel::role('update_status', null , null);

            }
            else{
                $this->parentModel::role('create_status', null , null);

            }

            $data = $request->except('_token');

            if($data['total_absents'] > 0 ){
                $data['total_deduction'] = $data['total_absents'] * $data['per_absents_deduction'];
            }
            if($data['total_lates'] > 0 ){
                $data['total_deduction'] += $data['per_absents_deduction'] / 2 * $data['total_lates'];
            }
            if($data['total_early_outs'] > 0 ){
                $data['total_deduction'] += $data['per_absents_deduction'] / 2 * $data['total_early_outs'];
            }
            $data['over_all_salary'] = (  ($data['gross_salary'] ?? 0 ) +  ($data['loan_amount'] ?? 0) + ($data['bonus_amount'] ?? 0)) - ($data['total_deduction'] ?? 0);
            $employeedata = $this->parentModel::where('id' ,$data['employee_id'])->first();
            $attendance = Attendance::where('employee_id', $employeedata->user_id)->whereMonth('date' ,  '<' , Carbon::now()->month)->pluck('total_hours')->toArray();
            $totalHours = 0 ;
            $totalMins  = 0 ;
            foreach ($attendance as $item){
                preg_match('/(\d*\.?\d*)hours/', $item, $hoursMatch);
                $hours = floatval($hoursMatch[1] ?? 0);
                preg_match('/(\d*\.?\d*)minutes/', $item, $minutesMatch);
                $minutes = floatval($minutesMatch[1] ?? 0);
                $totalHours += $hours;
                $totalMins += $minutes;
            }
                $data['total_hours_worked'] = $totalHours.'hours' ." " . $totalMins.'minutes';
                if(!empty($id)){

                    $data['updated_by'] = Auth::user()->name;
                }
                else{
                    $oldId = $this->childModel::latest()->first();
                    $increment = ($oldId->id ?? 0) + 1;
                    $data['ref_number'] = str_pad($increment, 6, '0', STR_PAD_LEFT);
                    $data['created_by'] = Auth::user()->name;
                    $data['date']  = Carbon::now()->subMonth()->format('Y-m-d');
                    $checkPayroll = $this->childModel::whereMonth('date' , Carbon::now()->subMonth()->format('m'))->where('employee_id', $data['employee_id'] )->count();
                    if($checkPayroll > 0 ){
                        $previousMonth = Carbon::now()->subMonth()->format('F');
                        return redirect()->back()->with("error", 'Payroll for the Month of ' . $previousMonth . ' \n   already been generated for the employee.' );
                    } // To Check Payroll for the generated month for employee
                }
                $storePayroll = $this->childModel::updateOrCreate(['id' => $id] , $data);
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
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function allData(Request $request){
        $data = $this->childModel::whereMonth('date' ,  Carbon::now()->subMonth()->format('m'));
        $employee_id = Auth::user()->role == 4 ? Auth::user()->employees->id : $request->employee_id;
        if(!empty($employee_id)){
            $data->where('employee_id', $employee_id);

        }
        if(!empty($request->department_id)){
            $data->whereHas('employees', function($query) use ($request) {
                $query->where('department', $request->department_id);
            });
        }
        if(!empty($request->month)){
            $data->whereMonth('date', $request->month);
        }
        if(!empty($request->year)){
            $data->whereYear('date', $request->year);
        }
        $result = $data->get();
        return DataTables::of($result)->addColumn('row_index', function($item) use (&$index){
            $index ++ ;
            return $index;
        })->addColumn('employee_id' , function($item){
            return $item->employees->emp_uniq_id ?? "";
        })->addColumn('name' , function($item){
            $first_name = $item->employees->first_name ?? "";
            $last_name  = $item->employees->last_name ?? "";
            return $first_name ." ". $last_name;
        })->addColumn('gross_salary' , function($item){
            return "RS,".$item->employees->salary ?? 0 ;
        })->addColumn('absent_deduction' , function($item){
            return 'RS,'. $item->per_absents_deduction ?? 0;
        })->addColumn('total_absents', function($item){
            return $item->total_absents?? 0;
        })->addColumn('total_lates' ,  function($item){
            return $item->total_lates?? 0;
        })->addColumn('total_leaves', function($item){
            return $item->total_leaves?? 0;
        })->addColumn('total_early_outs', function($item){
            return $item->total_early_outs?? 0;
        })->addColumn('total_off' ,  function($item){
            return $item->total_off ?? 0;
        })->addColumn('total_deduction' , function($item){
            return "RS,".$item->total_deduction??0;
        })->addColumn('loan_amount', function($item){
            return "RS,".$item->loan_amount ?? 0;
        })->addColumn('bonus_amount', function($item){
            return "RS,".$item->bonus_amount ?? 0;
        })->addColumn('allowance' , function($item){
            return "RS,".($item->total_allowance ?? 0);
        })->addColumn('net_salary', function($item){
            return "RS,".$item->over_all_salary ?? 0;
        })->addColumn('action', function($item){
            $editRoute = route($this->parentRoute. '.create', $item->id);
            $printRoute    = route('leave.application.pdf' , $item->id);
            $action =  '<a class="btn btn-info text-white" target="_blank"  href="'.$printRoute.'" title="Print Application"> <i
            class="fe fe-printer"></i></a> | <a class="btn btn-primary text-white viewDetails"   title="View Application" data-id="'.$item->id.'" data-bs-toggle="modal" data-bs-target="#applicationModal"> <i
            class="fe fe-eye"></i></a> |
             <a class="btn btn-success text-white  "  title="Edit Application"  href="'.$editRoute.'" > <i
            class="fe fe-edit"></i></a>';
            return $action;
        })->addColumn('month_year', function($item){
            return date('F / Y', strtotime($item->date));
        })
        ->rawColumns(['row_index' ,'month_year', 'employee_id' ,'name' , 'gross_salary','absent_deduction','total_absents','total_lates','total_early_outs','total_off','total_deduction','loan_amount','bonus_amount','allowance','net_salary','action'])->make(true);
    }

}
