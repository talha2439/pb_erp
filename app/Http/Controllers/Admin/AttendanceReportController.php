<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Employee;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Auth;
class AttendanceReportController extends Controller
{
    public $parentModel  = Attendance::class;
    public $parentView   = 'Admin.attendance.reports';
    public $parentRoute  = 'attendance.reports';

    public function index(){
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.all')->first();
        $checkAccess = $this->check_access($submenuId->id, 'view_status');
        if ($checkAccess) {
            $data['attendance']  = $this->parentModel::withoutTrashed()->get();
            $data['employees']   = Employee::all();
            $data['departments'] = Department::withoutTrashed()->get();
            return view($this->parentView . '.index', $data);
        } else {
            abort(405);
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
