<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Shift;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Auth;

class ShiftController extends Controller
{
    public $parentModel =  Department::class;
    public $childModel  =  Shift::class;
    public $parentView  = 'Admin.shift';
    public $parentRoute = 'shifts';
    public $roleRoute = 'shifts.index';

    public function index()
    {
        $this->parentModel::role('view_status',$this->roleRoute,null);
        try {
                $data['shift'] = $this->childModel::with('departments')->withoutTrashed()->get();

                return view($this->parentView . '.index', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trash()
    {
        $this->parentModel::role('view_status',$this->roleRoute,null);
        try {

                $data['shift'] = $this->childModel::with('departments')->onlyTrashed()->get();
                return view($this->parentView . '.trash', $data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function create($id = null)
    {
        if(!empty($id)){
            $this->parentModel::role('update_status', $this->roleRoute , null);

        }
        else{
            $this->parentModel::role('create_status', $this->roleRoute , null);

        }
       try{
            $data['action'] = $id == null ? 'create' : 'edit';
            $data['shift']   = $this->childModel::with('departments')->where('id', $id)->first();
            $data['department']    = $this->parentModel::all();
            return view($this->parentView . '.create', $data);

       }
       catch(\Exception $e) {
        return redirect()->back()->with('error', $e->getMessage());
       }
    }
    public function store(Request $request, $id = null)
    {   if(!empty($id)){
                $this->parentModel::role('update_status', $this->roleRoute , null);

            }
            else{
                $this->parentModel::role('create_status', $this->roleRoute , null);

            }
        try {

                $data = $request->except('_token');
                $data['days'] = isset($data['days']) && in_array('all', $data["days"])  ? json_encode([0 => 'all']) : json_encode($data['days']);
                if(!isset($data['days'])){
                    $data['days'] = json_encode([0 => 'all']);
                }
                if (!empty($id)) {
                    $updateDays = $this->childModel::where('id', $id)->update(['days' => ""]);
                }
                $saveData =  $this->childModel::updateOrCreate(['id' => $id], $data);
                if ($saveData) {
                    return redirect(route($this->parentRoute . '.index'))->with('success', 'Shift and Timing Information has been saved');
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with('error', 'Failed to save Shift and Timing information');
                }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function delete($id)
    {
        $role = $this->parentModel::role('delete_status',$this->roleRoute,'response');
        if(!empty($role)){
            return $role;
        }
        try {

                $delete        = $this->childModel::where('id', $id)->first();
                $employeeCheck = Employee::where('shift', $delete->id)->count();
                // Check if Designation is assigned to employee
                if ($employeeCheck > 0) {
                    return response()->json(['employee_exist' => true]);
                } else {
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
        $role = $this->parentModel::role('delete_status',$this->roleRoute,'response');
        if(!empty($role)){
            return $role;
        }
        try {

                $delete        = $this->childModel::onlyTrashed()->where('id', $id)->first();

                $employeeCheck = Employee::where('shift', $delete->id)->count();
                // Check if Designation is assigned to employee
                if ($employeeCheck > 0) {
                    return response()->json(['employee_exist' => true]);
                } else {
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
    public function restore($id)
    {
        $role = $this->parentModel::role('update_status',$this->roleRoute,'response');
        if(!empty($role)){
            return $role;
        }
        try {
            $restore = $this->childModel::where('id', $id)->restore();
                if ($restore) {
                    return redirect(route($this->parentRoute . '.index'))->with(['success' => 'Shift and Timing has been restored successfully']);
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with(['error' => 'Failed to restore Shift and Timing']);
                }

        } catch (\Exception $e) {
            return redirect(route($this->parentRoute . '.index'))->with(['error' => $e->getMessage()]);
        }
    }

}
