<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Payroll;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class EmployeeSalaryController extends Controller
{
    public $parentModel  =  Employee::class;
    public $menuModel    =   SubMenu::class;
    public $childModel   = EmployeeSalary::class;
    public $parentView   = 'Admin.salary';
    public $parentRoute = 'salary';
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
    public function trash(){
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'view_status');
            if($checkAccess){
                $data['employee'] = $this->parentModel::latest()->get();
                return view($this->parentView.'.trash', $data);
            }
                else{
                    abort(405);
                }
            }
            catch(\Exception $e){
                return redirect()->back()->with('error', $e->getMessage());
            }
    }
    public function alldata(Request $request){
        $data  = $this->childModel::latest();
        if($request->type == 'index'){
            $data->withoutTrashed();
        }
        else if($request->type == 'trash'){
            $data->onlyTrashed();
        }
        $result = $data->with('employees')->get();
        return DataTables::of($result)->addColumn('row_index' ,  function($item) use(&$index){
            $index ++;
            return $index;
        })->addColumn('employee_name' , function($item){
            $firstname = $item ->employees->first_name ?? "";
            $lastname = $item ->employees->last_name ?? "";
            return $firstname ." " . $lastname;
        })->addColumn('gross_salary', function($item){

        })->addColumn('per_hour', function($item){})
        ->addColumn('deduction_per_hour', function($item){})
        ->addColumn('absent_deduction' ,function($item){})
        ->addColumn('allowance', function($item){})
        ->addColumn('action',  function($item){

        })
        ->rawColumns(['row_index' , 'employee_name' , 'gross_salary' , 'per_hour' ,'deduction_per_hour','absent_deduction' , 'allowance' ,'action'])->make(true);
    }
    public function create($id = null){
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'create_status');
            if($checkAccess){
                $data['salary']   = $this->childModel::where('id' , $id)->first();
                $data['employees']   = $this->parentModel::latest()->get();
                $data['action']   = !empty($data['employee']) ? 'edit' : 'create';
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
        $checkAccess = $this->check_access($submenuId->id, 'create_status');
        if($checkAccess){
            $data  = $request->except('_token');

            if(!empty($id)){
                $data['updated_by'] =Auth::user()->username;
            }
            else{
                $checkemployee =  $this->childModel::where('employee_id' , $data['employee_id'])->count();
                if($checkemployee > 0 ){
                    return redirect()->back()->with('error', 'Salary information already added for this employee');
                }
                $data['created_by'] = Auth::user()->username;
            }
            $storeData = $this->childModel::updateOrCreate(['id' => $id],$data);
            if($storeData){
                return redirect()->route($this->parentRoute.'.index')->with('success', 'Salary Information has been saved');
            }
            else{
                return redirect()->route($this->parentRoute.'.index')->with('error', 'Failed to save Salary information');
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
    public function delete($id){
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if($checkAccess){
                $checkPayroll = Payroll::where('salary_id' , $id)->count();
                if($checkPayroll > 0 ){
                    return response()->json(['payroll_exist' => true]);
                }
                $delete  = $this->childModel::where('id' , $id)->delete();
                if($delete){
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
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function destroy($id){
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if($checkAccess){
                $checkPayroll = Payroll::where('salary_id' , $id)->count();
                if($checkPayroll > 0 ){
                    return response()->json(['payroll_exist' => true]);
                }
                $delete  = $this->childModel::where('id' , $id)->forceDelete();
                if($delete){
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
            return response()->json(['error'=>$e->getMessage()]);
        }
    }
    public function restore($id){
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'update_status');
            if($checkAccess){
                $restore  = $this->childModel::where('id' , $id)->restore();
                if($restore){
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
            return redirect()->back()->with(['error'=>$e->getMessage()]);
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
