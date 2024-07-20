<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Employee;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DesignationController extends Controller
{
    public $parentModel =  Department::class;
    public $childModel  = Designation::class;
    public $parentView  = 'Admin.designation';
    public $parentRoute = 'designations';

    public function index()
    {
        try{
                $this->parentModel::role('view_status', null , null);
                $data['designation'] = $this->childModel::with('departments')->withoutTrashed()->get();

                return view($this->parentView . '.index', $data);

        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trash()
    {
        try{
            $this->parentModel::role('view_status', null , null);
            $data['designation'] = $this->childModel::with('departments')->onlyTrashed()->get();
            return view($this->parentView . '.trash', $data);
        }
        catch(\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
    }
    public function create($id = null)
    {
        try{
                $this->parentModel::role('view_status', null , null);
                $data['action'] = $id == null ? 'create' : 'edit';
                $data['designation']   = $this->childModel::with('departments')->where('id', $id)->first();
                $data['department']    = $this->parentModel::all();
                return view($this->parentView . '.create', $data);

        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function store(Request $request, $id = null)
    {
        try {
            if (!empty($id)) {
                $this->parentModel::role('update_status', null , null);
            }
            $this->parentModel::role('create_status', null , null);

                $data = $request->except('_token');
                $saveData =  $this->childModel::updateOrCreate(['id' => $id], $data);
                if ($saveData) {
                    return redirect(route($this->parentRoute . '.index'))->with('success', 'Designation Information has been saved');
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with('error', 'Failed to save Designation information');
                }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $this->parentModel::role('delete_status',$this->parentRoute.'.index','response');

                $delete        = $this->childModel::where('id', $id)->first();
                $employeeCheck = Employee::where('designation', $delete->id)->count();
                // Check if Designation is assigned to employee
                if ($employeeCheck > 0) {
                    return response()->json(['employee_exist' => true]);
                }
                else {
                    $delete->delete();
                    if ($delete) {
                        return response()->json(['success' => true]);
                    } else {
                        return response()->json(['error' => true]);
                    }
                }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $this->parentModel::role('delete_status',$this->parentRoute.'.index','response');

                $delete        = $this->childModel::onlyTrashed()->where('id', $id)->first();

                $employeeCheck = Employee::where('designation', $delete->id)->count();
                // Check if Designation is assigned to employee
                if ($employeeCheck > 0) {
                    return response()->json(['employee_exist' => true]);
                }
                else {
                    $delete->forceDelete();
                    if ($delete) {
                        return response()->json(['success' => true]);
                    } else {
                        return response()->json(['error' => true]);
                    }
                }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function restore($id){
        try {
            $this->parentModel::role('update_status',$this->parentRoute.'.index','response');

                $restore = $this->childModel::where('id' , $id)->restore();
                if($restore){
                    return redirect(route($this->parentRoute.'.index'))->with(['success' => 'Designation has been restored successfully']);
                }
                else{
                    return redirect(route($this->parentRoute.'.index'))->with(['error' => 'Failed to restore Designation']);
                }
            }

        catch (\Exception $e) {
            return redirect(route($this->parentRoute.'.index'))->with(['error' => $e->getMessage()]);
        }
    }

}
