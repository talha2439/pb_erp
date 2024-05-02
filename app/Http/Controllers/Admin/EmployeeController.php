<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Designation;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\Employee;
use App\Models\EmployeeExperience;
use App\Models\EmployeeQualification;
use App\Models\Nationality;
use App\Models\Shift;
use App\Models\State;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Auth;
use Carbon\Carbon;
use Str;

class EmployeeController extends Controller
{
    public $parentModel = Employee::class;
    public $userModel   = User::class;
    public $childModel  = UserAccess::class;
    public $menuModel   = SubMenu::class;
    public $parentView  = 'Admin.employee';
    public $parentRoute = "employees";
    public $imagePath  = 'images/EmployeesImages/';
    public $childimagePath  = 'images/EmployeesImages/cv_files/';
    public function index(Request $request)
    {
        $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
        $checkAccess = $this->check_access($submenuId->id, 'view_status');
        if ($checkAccess) {
            $data['employee'] = $this->parentModel::withoutTrashed()->get();

            return view($this->parentView . '.index', $data);
        } else {
            abort(405);
        }
    }
    public function employee_details($id)
    {
        $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
        $checkAccess = $this->check_access($submenuId->id, 'view_status');
        if ($checkAccess) {
            try {
                $id  =  decrypt($id);
                $data['employee'] = $this->parentModel::where('id', $id)->first();
                return view($this->parentView . '.templates.employee_details', $data);
            } catch (\Exception $e) {
                return redirect(route($this->parentRoute.'.index'))->with('error', $e->getMessage());
            }
        } else {
            abort(405);
        }
    }
    public function trash(Request $request)
    {
        $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.trash')->first();
        $checkAccess = $this->check_access($submenuId->id, 'view_status');
        if ($checkAccess) {
            $data['employee'] = $this->parentModel::onlyTrashed()->get();

            return view($this->parentView . '.trash', $data);
        } else {
            abort(405);
        }
    }
    public function create($id = null)
    {
        $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.create')->first();
        $checkAccess = $this->check_access($submenuId->id, 'create_status');
        if (!empty($id)) {
            $checkAccess = $this->check_access($submenuId->id, 'update_status');
        }
        if ($checkAccess) {
            $data['action']      = $id == null ? 'create' : 'edit';
            $data['employee']    = $this->parentModel::where('id', $id)->first();
            $data['country']     = Country::all();
            $data['nationality'] = Nationality::all();
            $data['users']       = $this->userModel::where('role', 4)->whereNotIn('id', Employee::pluck('user_id')->toArray())
                ->get();
            if ($data['action'] == 'edit') {
                $data['users'] = $this->userModel::where('role', 4)->get();
            }
            $data['department'] = Department::all();
            return view($this->parentView . '.create', $data);
        } else {
            abort(405);
        }
    }
    public function store(Request $request, $id = null)
    {
        try {
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.create')->first();
            $checkAccess = $this->check_access($submenuId->id, 'create_status');

            if (!empty($id)) {
                $checkAccess = $this->check_access($submenuId->id, 'update_status');
            }
            if ($checkAccess) {
                $requestData = $request->data;
                parse_str($requestData, $data);
                unset($data['_token']);
                if (empty($id)) {
                    $validateEmailandCnic = $this->parentModel::where('personal_email', $data['personal_email'])->orWhere('cnic_number', $data['cnic_number'])->count();
                    if ($validateEmailandCnic > 0) {
                        return response()->json(['error' => "Personal email or cnic number already used"]);
                    }
                }
                $data['max_id']         = $this->parentModel::max('id') ?? 0;
                $data['max_id']         = ($data['max_id'] + 1);
                $data['emp_uniq_id']    = "pbhub-" . str_replace(" ", "", strtolower($data['first_name'])) . '-' . str_pad($data['max_id'], 3, '0', STR_PAD_LEFT);
                $data['martial_status'] = isset($data['martial_status']) && $data['martial_status'] == "on" ? 1 : 0;
                $data['country']        = isset($data['country']) && !empty($data['country']) ? $data['country'] : 0;
                $data['state']          = isset($data['state']) && !empty($data['state']) ? $data['state'] : 0;
                $data['city']           = isset($data['city']) && !empty($data['city']) ? $data['city'] : 0;
                $data['nationality']    = isset($data['nationality']) && !empty($data['nationality']) ? $data['nationality'] : 0;
                $data['shift']          = isset($data['shift']) && !empty($data['shift']) ? $data['shift'] : 0;
                $data['no_of_child']    = isset($data['no_of_child']) && !empty($data['no_of_child']) ? $data['no_of_child'] : 0;
                $data['start_date']     = !empty($data['start_date']) ? $data['start_date'] : null;
                if (!empty($id)) {
                    $emp_data = $this->parentModel::where('id', $id)->first();
                    $data['emp_uniq_id'] = $emp_data->emp_uniq_id;
                }
                if ($request->hasFile("image")) {
                    $filename = $data['emp_uniq_id'] . '.' . $request->file('image')->getClientOriginalExtension();
                    $request->file('image')->move($this->imagePath, $filename);
                    $data['image'] = $filename;
                    if (!empty($id)) {
                        $imageFile =  $this->parentModel::where('id', $id)->get('image');
                        $imagePath =  asset($this->imagePath . $imageFile);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }
                if ($request->hasFile("cv_file")) {
                    $cv_file = $data['emp_uniq_id'] . '.' . $request->file('cv_file')->getClientOriginalExtension();
                    $request->file('cv_file')->move($this->childimagePath, $cv_file);
                    $data['cv_file'] = $cv_file;
                    if (!empty($id)) {
                        $imageFile =  $this->parentModel::where('id', $id)->get('cv_file');
                        $cvPath =  asset($this->childimagePath . $imageFile);
                        if (file_exists($cvPath)) {
                            unlink($cvPath);
                        }
                    }
                }
                $storeData = $this->parentModel::updateOrCreate(['id' => $id], $data);
                if ($storeData) {
                    return response()->json(['success' => true, 'emp_id' => $storeData->id]);
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
    public function state($id)
    {
        $data = State::where('country_id', $id)->get();
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['error' => true]);
        }
    }
    public function city($id)
    {
        $data = City::where('state_id', $id)->get();
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['error' => true]);
        }
    }
    public function designation_and_shift($id)
    {
        $data['shift']              = Shift::where('department', $id)->withoutTrashed()->first();
        $data['shift']->start_time  = Carbon::parse($data['shift']->start_time)->format('h:i A');
        $data['shift']->end_time    = Carbon::parse($data['shift']->end_time)->format('h:i A');
        $data['designation']        = Designation::where('department', $id)->withoutTrashed()->first();
        if ($data) {
            return response()->json($data);
        }
    }
    public function delete($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
                $delete        = $this->parentModel::where('id', $id)->delete();
                $removeQualification = EmployeeQualification::where('employee_id', $id)->delete();
                $removeExp           = EmployeeExperience::where('employee_id', $id)->delete();
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

    public function destroy($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');

            if ($checkAccess) {
                $delete        = $this->parentModel::where('id', $id)->forceDelete();
                $forceDeleteQualification = EmployeeQualification::where('employee_id', $id)->forceDelete();
                $forceDeleteExp           = EmployeeExperience::where('employee_id', $id)->forceDelete();
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
    public function restore($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
                $restore = $this->parentModel::where('id', $id)->restore();
                $restoreQualification = EmployeeQualification::where('employee_id', $id)->restore();
                $restoreExp           = EmployeeExperience::where('employee_id', $id)->restore();
                if ($restore) {
                    return redirect(route($this->parentRoute . '.index'))->with(['success' => 'Employee Information has been restored successfully']);
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with(['error' => 'Failed to restore Employee Information']);
                }
            }
        } catch (\Exception $e) {
            return redirect(route($this->parentRoute . '.index'))->with(['error' => $e->getMessage()]);
        }
    }
}
