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
use App\Events\Notifications;
use App\Models\Notification;

class LeaveController extends Controller
{

    public $parentModel       =   LeaveApplication::class;
    public $childModel        =   Employee::class;
    public $parentView        =  'Admin.attendance.leave_application';
    public $parentRoute       =  'leave.application';
    public $imagePath         =  'images/leave_application/';
    public function index()
    {
        try{
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
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create($id = null)
    {
      try{
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.create')->first();
        $checkAccess = $this->check_access($submenuId->id, 'create_status');
        if (!empty($id)) {
            $checkAccess = $this->check_access($submenuId->id, 'update_status');
        }
        if ($checkAccess) {
            $data['action']       = $id == null ? 'create' : 'edit';
            $data['leave']        = $this->parentModel::with('employees')->where('id', $id)->first();
            $data['employees']    = $this->childModel::all();
            return view($this->parentView . '.create', $data);
        } else {
            abort(405);
        }
      }
      catch(\Exception $e){
        return  redirect()->back()->with('error', $e->getMessage());
      }
    }
    public function data(Request $request){

        $data = $this->parentModel::latest();

        if(Auth::user()->role == 4){
         $data->where('employee_id', Auth::user()->employees->id);
        } // To only show employees their leaves
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

            return  Carbon::parse( $item->from_date)->format('F d, Y') ." - " . Carbon::parse( $item->to_date)->format('F d, Y');
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

            return Carbon::parse($item->approved_at)->format('F d, Y') ?? "" ;
        })
        ->addColumn('applied_by' , function($item){
            return $item->applied->name ?? "" ;
        })
        ->addColumn('applied_at' , function($item){
            return Carbon::parse($item->created_at)->format('F d, Y') ?? "" ;
        })->addColumn('action' , function($item){
            $editRoute = route($this->parentRoute. '.create', $item->id);
            $allowed   = Auth::user()->role == 4 ? 'disabled' : '';
            $status    = $item->status == 'approved' || $item->status == 'rejected' ? 'disabled' : ''; // to disable status change
            $editstatus    = $item->status != 'pending' ? 'disabled' : ''; // to disable status change
            $printRoute    = route('leave.application.pdf' , $item->id);
            if($item->status == 'approved'&&  $item->status != 'pending'  && Auth::user()->role != 4  ){
                $status = ''; // to enable if user is a HR
            }
            $action =  '<a class="btn btn-info text-white" target="_blank"  href="'.$printRoute.'" title="Print Application"> <i
            class="fe fe-printer"></i></a> | <a class="btn btn-primary text-white viewDetails"   title="View Application" data-id="'.$item->id.'" data-bs-toggle="modal" data-bs-target="#applicationModal"> <i
            class="fe fe-eye"></i></a> | <a class="btn btn-warning text-white '.$allowed.' '.$status.' changeStatus"  data-to="'.Carbon::parse($item->to_date)->format('m/d/Y').'" data-from="'.Carbon::parse($item->from_date)->format('m/d/Y').'" data-bs-toggle="modal" data-bs-target="#experienceModal"
             title="Change Status"  data-id="'.$item->id.'"> <i
            class="fe fe-edit-3"></i></a> |
             <a class="btn btn-success text-white  '.$editstatus.' "  title="Edit Application"  href="'.$editRoute.'" > <i
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
            $data['employee_id'] = isset($data['employee_id']) && !empty($data['employee_id']) ? $data['employee_id'] : Auth::user()->employees->id;
            $leave_type          = $data['leave_type'] == 1 ? 'annual_leaves' : 'sick_leaves';
            $data['leave_type']  = str_replace("_" , " " , ucfirst($leave_type));
            $checkLeaves         = $this->childModel::where('id' , $data['employee_id'])->first();
            // If Leaves exceed the maximum number of leaves for employees
            if($checkLeaves->$leave_type < $data['total_days']){
                return redirect()->back()->with('error', 'You have not enough leaves for ' . str_replace("_" , " " , ucfirst($leave_type)));
            }
            // Return back if there is another leave already exists in table leaves application
            $leaveApplication  = $this->parentModel::whereNot('status', 'rejected')->whereNot('status' , 'pending')->where(['employee_id'=> $data['employee_id'] ,'leave_type' => $data['leave_type']])->count();
            if($leaveApplication > 0 ){
                return redirect()->back()->with('error', 'Application For  '. str_replace("_" , " " , ucfirst($leave_type)).' already been applied for '.  ucfirst($checkLeaves->first_name) . " " . ucfirst($checkLeaves->last_name));
            }
            if($request->hasFile('attachment')){
                $filename  = time().'.'.$request->file('attachment')->getClientOriginalExtension();
                $request->file('attachment')->move($this->imagePath, $filename);
                $data['attachment'] = $filename;
            }
            $storeData = $this->parentModel::updateOrCreate(['id'=>$id],$data);
            if($storeData){
                $created_at   = Carbon::parse($storeData->created_at)->format('F d, Y h:i:s A');
                $type = !empty($id)? 'leave_approved' : 'leave_rejected';
                $subject = !empty($id) ? 'Leave Application Updated for ' . ucfirst($checkLeaves->first_name) . " " . ucfirst($checkLeaves->last_name) : 'Leave Application Applied'  . ucfirst($checkLeaves->first_name) . " " . ucfirst($checkLeaves->last_name) ;
                $storeNotification =  $this->parentModel::notification($subject , $storeData  , $type , 'employees');
                Notification::create([
                    'subject' => $subject ,
                    'user_id' => $storeData->employees->user_id,
                    'created_at' => $created_at,
                    'data' => $storeData->id,
                    'type' => $type,
                ]);
                event(new Notifications($storeNotification));
                return redirect()->route($this->parentRoute.'.index')->with(['success'=> $subject]);
            }
            else{
                return redirect()->back()->with('error', 'Something went wrong');
            }
        }
        catch(\Exception $e){
            return redirect()->back()->with(['error'=> $e->getMessage()]);
        }
    }
    public function status(Request $request){
       try{
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
        $checkAccess = $this->check_access($submenuId->id, 'update_status');
        if ($checkAccess) {
        $data = $request->except(['token']);
        $employeedata = $this->parentModel::where('id' , $data['id'])->first();
        if($data['status'] == 'approved'){
            $date_range = explode('-', $data['date_range']);
            $data['from_date']     = carbon::parse($date_range[0])->format('Y-m-d');
            $data['to_date']       = carbon::parse($date_range[1])->format('Y-m-d');
            $data['approved_days'] = Carbon::parse($data['from_date'])->diffInDays(Carbon::parse($data['to_date']));
            $data['rejected_days'] = $employeedata->total_days - $data['approved_days'];
            $data['approved_by']   = $data['status'] == 'approved' ? Auth::user()->name : null;
            $data['approved_at']   = $data['status'] == 'approved' ? Carbon::now() : null;
        }
        else{
            unset($data['from_date']);
            unset($data['to_date']);
        }
        unset($data['date_range']);
        $updateData  = $employeedata->update($data);
        $leaveData   = $this->parentModel::where('id' , $data['id'])->with('employees')->first();
        $leaveData->from_date  = Carbon::parse($leaveData->from_date)->format('F d, Y');
        $leaveData->to_date    = Carbon::parse($leaveData->to_date)->format('F d, Y');
        $created_at   = Carbon::parse($leaveData->updated_at)->format('F d, Y h:i:s A');
        $type = !empty($data['status']) && $data['status'] == 'approved' ? 'leave_approved' : 'leave_rejected';
        $subject = !empty($data['status']) && $data['status'] == 'approved' ? 'Leave Application Approved for '. ucfirst($leaveData->employees->first_name) . " " . ucfirst($leaveData->employees->last_name)  : 'Leave Application rejected for' . ucfirst($leaveData->employees->first_name) . " " . ucfirst($leaveData->employees->last_name);
        $storeNotification =  $this->parentModel::notification($subject , $leaveData  , $type , 'employees');
        Notification::create([
            'subject' => $subject ,
            'user_id' => $leaveData->employees->user_id,
            'created_at' => $created_at,
            'data' => $leaveData->id,
            'type' => $type,
        ]);
        event(new Notifications($storeNotification));
        if($updateData){
            return response()->json(['success' => true]);
        }
        else{
              return response()->json(['error' => true]);
        }
        }
        else{
              return response()->json(['unauthorized' => true]);
        }
       }
       catch(\Exception $e){
           return response()->json(['error' =>  $e->getMessage()]);
       }



    }
    public function details($id){
        try{
            $data['application'] = $this->parentModel::where('id'   , $id)->with('employees')->first();
        if(!empty($data['application'])){
            $data['application']->from_date = Carbon::parse($data['application']->from_date)->format('F d , Y');
            $data['application']->to_date = Carbon::parse($data['application']->to_date)->format('F d , Y');
        }
        return response()->json(['data' => $data]);
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function destroy($id){
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
                $delete        = $this->parentModel::where('id', $id)->forceDelete();
                if ($delete) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => true]);
                }
            } else {
                return response()->json(['unauthorized' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
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
