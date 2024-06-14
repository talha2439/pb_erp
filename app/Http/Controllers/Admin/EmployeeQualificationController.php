<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeQualification;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeQualificationController extends Controller
{
    public $parentModel = EmployeeQualification::class;
    public $imagePath = 'images/employee_qualification/';
    public $parentRoute = "employees";
    public $menuModel = SubMenu::class;
    public function edit($id)
    {
        $emp_qualification = $this->parentModel::where('employee_id', $id)->get();
        return response()->json(['qualification' => $emp_qualification]);
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


                $currentDate = Carbon::now()->format('Y-m-d');

                foreach ($data['institute'] as $key => $value) {
                    if (!empty($request->file("document")[$key]) && isset($request->file("document")[$key])) {
                        $fileNames = str_replace(" ", "", $data['qualification'][$key]) . '_' . time() . '.' . $request->file('document')[$key]->getClientOriginalExtension();
                        $request->file('document')[$key]->move($this->imagePath, $fileNames);
                    }
                    $enddate = Carbon::parse($data['end_date'][$key])->format('Y-m-d');
                    $status = $currentDate == $enddate ? 1 : 0;
                    $storedata = $this->parentModel::updateOrCreate(['id' => $data['qualification_id'][$key] ??null], [
                        'institute' => $data['institute'][$key],
                        'document' => $fileNames ?? "",
                        'qualification' => $data['qualification'][$key],
                        'employee_id' => $data['employee_id'],
                        'start_date' => $data['start_date'][$key],
                        'end_date' => $data['end_date'][$key],
                        'status' => $status,
                        'gpa' => !empty($data['gpa'][$key]) ? $data['gpa'][$key] : 0,
                        'percentage' => !empty($data['percentage'][$key]) ? $data['percentage'][$key] : 0,
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
    public function get_qualification($id){
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
