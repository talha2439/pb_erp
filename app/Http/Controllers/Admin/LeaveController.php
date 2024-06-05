<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\LeaveApplication;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Yajra\DataTables\Facades\DataTables;

class LeaveController extends Controller
{

    public $parentModel =  LeaveApplication::class;
    public $childModel  =  Employee::class;
    public $parentView  = 'Admin.attendance.leave_application';
    public $parentRoute = 'leave.application';
    public $imagePath   = 'images/leave_application/';

    public function index()
    {
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
        $checkAccess = $this->check_access($submenuId->id, 'view_status');
        if ($checkAccess) {
            $data['departments'] = Department::withoutTrashed()->get();
            $data['employees']   = $this->childModel::withoutTrashed()->get();
            return view($this->parentView . '.index' , $data);
        } else {
            abort(405);
        }
    }

    public function create($id = null)
    {
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.create')->first();
        $checkAccess = $this->check_access($submenuId->id, 'create_status');
        if (!empty($id)) {
            $checkAccess = $this->check_access($submenuId->id, 'update_status');
        }
        if ($checkAccess) {
            $data['action'] = $id == null ? 'create' : 'edit';
            $data['leave']   = $this->childModel::with('departments')->where('id', $id)->first();
            $data['employees']    = $this->childModel::all();
            return view($this->parentView . '.create', $data);
        } else {
            abort(405);
        }
    }
    public function data(Request $request){

        $data = $this->parentModel::latest();
        if(!empty($request->date)){
            $data->whereDate('created_at' ,$request->date);
        }
        if(!empty($request->employee)){
          $data->where('employee_id', $request->employee);
        }
        if(!empty($request->department)){
           $data->whereHas('employees.departments', function($query) use ($request){
                $query->where('department', $request->department);
           });
        }
        if(!empty($request->month)){
            $data->whereMonth('created_at', $request->month);
        }
        if(!empty($request->year)){
            $data->whereYear('created_at', $request->year);
        }
        if(!empty($request->status)){
            $data->where('status', $request->status);
        }
        if(!empty($request->leave_types)){
            $data->where('leave_type', $request->leave_types);
        }
        $results = $data->get();
        return DataTables::of($results)->addColumn('row_index' , function($item) use(&$index){
            $index ++ ;
            return $index;
        })->addColumn('employee_id' , function($item){
            return $item->employees->emp_uniq_id ?? "";
        })
        ->addColumn('employee_name' , function($item){
            return $item->employees->first_name ?? "";
        })
        ->addColumn('department' , function($item){
            return $item->employees->departments->name ?? "";
        })
        ->addColumn('leave_type' , function($item){
            return $item->leave_type ?? "";
        })->addColumn('duration',function($item){
            return $item->from_date ." - " .$item->to_date;
        })
        ->addColumn('total_days' , function($item){
            return $item->total_days ?? "" ;
        })
        ->addColumn('approved_days' , function($item){
            return $item->approved_days ?? "" ;
        })
        ->addColumn('status' , function($item){
            if($item->status == 'pending'){
                $blinkclass = 'warning';
                $status = 'Pending';
            }
            else if($item->status == 'approved'){
                $blinkclass ='success';
                $status = 'Approved';
            }
            else if($item->status =='rejected'){
                $blinkclass = 'danger';
                $status = 'Rejected';
            }
            return '<span class="blink blink-'.$blinkclass.'">'.$status.'</span>';
        })
        ->addColumn('approved_by' , function($item){
            return $item->approved_by ?? "" ;
        })
        ->addColumn('approved_at' , function($item){
            return $item->approved_at ?? "" ;
        })
        ->addColumn('applied_by' , function($item){
            return $item->applied->name ?? "" ;
        })
        ->addColumn('applied_at' , function($item){
            return Carbon::parse($item->created_at)->format('y-m-d') ?? "" ;
        })->addColumn('action' , function($item){
            $editRoute = route($this->parentRoute. '.edit', $item->id);
            $action =  '<a class="btn btn-primary text-white viewDetails"  title="View Application" data-id="'.$item->id.'"> <i
            class="fe fe-eye"></i></a> | <a class="btn btn-warning text-white changeStatus"  data-bs-toggle="modal" data-bs-target="#experienceModal"
             title="Change Status" data-id="'.$item->id.'"> <i
            class="fe fe-edit-3"></i></a> |
             <a class="btn btn-success text-white"  title="Edit Application" href="'.$editRoute.'"> <i
            class="fe fe-edit"></i></a>';
            return $action;
        })
        ->rawColumns(['row_index' , 'employee_id' , 'employee_name' , 'department' , 'applied_at' ,'leave_type' ,'duration' ,'total_days', 'approved_days' , 'status' ,'approved_by' ,'approved_at' , 'action'])->make(true);
    }
    public function store(Request $request , $id = null){
        try{
            $data = $request->except("_token");
            $from_date = Carbon::parse($data['from_date']);
            $to_date   = Carbon::parse($data['to_date']);
            $data['total_days']  = $from_date->diffInDays($to_date);
            $data['applied_by']  = Auth::user()->id;
            $data['employee_id'] = isset($data['employee_id']) && !empty($data['employee_id']) ? $data['employee_id'] : Auth::user()->id;
            $leave_type          = $data['leave_type'] == 1 ? 'annual_leaves' : 'sick_leaves';
            $data['leave_type']  = str_replace("_" , " " , ucfirst($leave_type));
            $checkLeaves         = $this->childModel::where('id' , $data['employee_id'])->first();
            // If Leaves exceed the maximum number of leaves for employees
            if($checkLeaves->$leave_type < $data['total_days']){
                return redirect()->back()->with('error', 'You have not enough leaves for ' . str_replace("_" , " " , ucfirst($leave_type)));
            }
            // Return back if there is another leave already exists in table leaves application
            $leaveApplication  = $this->parentModel::whereNot('status', 'rejected')->where(['employee_id'=> $data['employee_id'] ,'leave_type' => $data['leave_type']])->count();
            if($leaveApplication > 0){
                return redirect()->back()->with('error', 'Application For  '. str_replace("_" , " " , ucfirst($leave_type)).' already been applied for '.  ucfirst($checkLeaves->first_name) . " " . ucfirst($checkLeaves->last_name));
            }
            if($request->hasFile('attachment')){
                $filename  = time().'.'.$request->file('attachment')->getClientOriginalExtension();
                $request->file('attachment')->move($this->imagePath, $filename);
                $data['attachment'] = $filename;
            }
            $storeData = $this->parentModel::create($data);
            if($storeData){
                return redirect()->route($this->parentRoute.'.index')->with('success', 'Leave Application has been successfully applied for '. ucfirst($checkLeaves->first_name) . " " . ucfirst($checkLeaves->last_name));
            }
            else{
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function destroy($id){

    }
    public function check_access($subMenuId , $status)
    {
        $checkAccess =  UserAccess::where(['sub_menu_id'=> $subMenuId , $status => 1 , 'user_id' => Auth::user()->id ])->first();
        $checkAdmin  = User::where(['id' => Auth::user()->id , 'role' => 1])->count();
        if($checkAdmin > 0){
            return true;
        }
        if($checkAccess){
            return true ;
        }
        else{
            return false;
        }
    }
}
