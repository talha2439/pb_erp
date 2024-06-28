<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeExperience;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Auth;

class EmployeeExperienceController extends Controller
{
    public $parentModel = EmployeeExperience::class;
    public $imagePath = 'images/emp_experience_attachment/';
    public $parentRoute = "employees";
    public $menuModel = SubMenu::class;
    public function edit($id = null)
    {
        try{
            $experience = $this->parentModel::where('employee_id', $id)->get();
            return response()->json(['experience' => $experience]);
        }
        catch (\Exception $e){
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request, $id = null)
    {
        try {
            $submenuId = $this->menuModel::where('route', $this->parentRoute . '.create')->first();
            $checkAccess = $this->check_access($submenuId->id, 'create_status');
            if (!empty($id)) {
                $checkAccess = $this->check_access($submenuId->id, 'update_status');
            }
            if ($checkAccess) {
                $requestData = $request->data;
                parse_str($requestData, $data);
                $data['employee_id'] = $request->employee_id;
                unset($data['_token']);
                unset($data['csrf_token']);

                $employeeData = Employee::where('id', $data['employee_id'])->first();

                foreach ($data['job_title'] as $key => $value) {

                    if (!empty($request->file("attachment")[$key]) && isset($request->file("attachment")[$key])) {
                        $fileNames = str_replace(" ", "", $employeeData->emp_uniq_id) . '_' . time() . '.' . $request->file('attachment')[$key]->getClientOriginalExtension();
                        $request->file('attachment')[$key]->move($this->imagePath, $fileNames);
                    }
                    $exp_id = isset($data['exp_id'][$key]) && !empty($data['exp_id'][$key]) ? $data['exp_id'][$key]: null;

                    $storedata = $this->parentModel::updateOrCreate(['id' => $exp_id], [
                        'employee_id' => $data['employee_id'],
                        'job_title' => $data['job_title'][$key],
                        'attachment' => $fileNames ?? "",
                        'salary' => $data['salary'][$key] ?? 0,
                        'designation' => $data['designation'][$key] ?? "",
                        'start_date' => $data['exp_start_date'][$key],
                        'end_date' => $data['exp_end_date'][$key],
                        'reason_for_leaving' => $data['reason_for_leaving'][$key] ?? "",
                        'description' => $data['description'][$key] ?? "",
                    ]);
                }
                if ($storedata) {
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
    public function delete($id)
    {
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
    public function get_experience($id){
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'view_status');
            if ($checkAccess) {
                $qualification        = $this->parentModel::withTrashed()->where('employee_id', $id)->get();
                if ($qualification) {
                    return response()->json(['success' => true , 'data' => $qualification]);
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
    public function check_access($subMenuId, $status)
    {
        $checkAccess = UserAccess::where(['sub_menu_id' => $subMenuId, $status => 1, 'user_id' => Auth::user()->id])->first();
        $checkAdmin = User::where(['id' => Auth::user()->id, 'role' => 1])->count();
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
