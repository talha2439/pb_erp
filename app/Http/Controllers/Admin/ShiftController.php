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

    public function index()
    {
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
        $checkAccess = $this->check_access($submenuId->id, 'view_status');
        if ($checkAccess) {
            $data['shift'] = $this->childModel::with('departments')->withoutTrashed()->get();

            return view($this->parentView . '.index', $data);
        } else {
            abort(405);
        }
    }
    public function trash()
    {
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
        $checkAccess = $this->check_access($submenuId->id, 'view_status');
        if ($checkAccess) {
            $data['shift'] = $this->childModel::with('departments')->onlyTrashed()->get();
            return view($this->parentView . '.trash', $data);
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
            $data['shift']   = $this->childModel::with('departments')->where('id', $id)->first();
            $data['department']    = $this->parentModel::all();
            return view($this->parentView . '.create', $data);
        } else {
            abort(405);
        }
    }
    public function store(Request $request, $id = null)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.create')->first();
            $checkAccess = $this->check_access($submenuId->id, 'create_status');
            if (!empty($id)) {
                $checkAccess = $this->check_access($submenuId->id, 'update_status');
            }
            if ($checkAccess) {
                $data = $request->except('_token');
                $data['days'] = isset($data['days']) && in_array('all' ,$data["days"])  ? json_encode([0 => 'all']) : json_encode($data['days']);
                if(!empty($id)){
                    $updateDays = $this->childModel::where('id' , $id)->update(['days' => ""]);
                }
                $saveData =  $this->childModel::updateOrCreate(['id' => $id], $data);
                if ($saveData) {
                    return redirect(route($this->parentRoute . '.index'))->with('success', 'Shift and Timing Information has been saved');
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with('error', 'Failed to save Shift and Timing information');
                }
            } else {
                abort(405);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
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
            } else {
                return response()->json(['unauthorized' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
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
            } else {
                return response()->json(['unauthorized' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function restore($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
                $restore = $this->childModel::where('id', $id)->restore();
                if ($restore) {
                    return redirect(route($this->parentRoute . '.index'))->with(['success' => 'Shift and Timing has been restored successfully']);
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with(['error' => 'Failed to restore Shift and Timing']);
                }
            }
        } catch (\Exception $e) {
            return redirect(route($this->parentRoute . '.index'))->with(['error' => $e->getMessage()]);
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
