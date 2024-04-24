<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\Employee;
use App\Models\Nationality;
use App\Models\State;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Auth;
class EmployeeController extends Controller
{
    public $parentModel = Employee::class;
    public $userModel   = User::class;
    public $childModel  = UserAccess::class;
    public $menuModel   = SubMenu::class;
    public $parentView  = 'Admin.employee';
    public $parentRoute = "employees";
    public $imagePath  = 'images/EmployeesImages/';
    public function index(Request $request){
        $submenuId   = $this->menuModel::where('route' , $this->parentRoute.'.index')->first();
        $checkAccess = $this->check_access($submenuId->id , 'view_status');
        if($checkAccess){
        $data['user'] = $this->parentModel::whereNot('role' , 1)->get();
        if(!empty($request->type) && $request->type == "active_users"){
        $data['user'] = $this->parentModel::whereNot('role' , 1)->whereNot('email_verified_at' , null)->get();
        }
        return view($this->parentView.'.index', $data);
        }
        else{
            abort(405);
        }
    }
    public function create($id = null){
        $submenuId   = $this->menuModel::where('route' , $this->parentRoute.'.create')->first();
        $checkAccess = $this->check_access($submenuId->id , 'create_status');
        if(!empty($id)){
        $checkAccess = $this->check_access($submenuId->id , 'update_status');
        }
        if($checkAccess){
        $data['action']     = $id == null? 'create': 'edit';
        $data['employee']   = $this->parentModel::where('id', $id)->first();
        $data['country']    = Country::all();
        $data['nationality'] = Nationality::all();
        $data['users']       = $this->userModel::where('role' , 4)->get();
        return view($this->parentView.'.create', $data);
        }
        else{
            abort(405);
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
    public function state($id){
        $data = State::where('country_id' , $id)->get();
        if($data){
            return response()->json($data);
        }
        else{
            return response()->json(['error' => true]);
        }
    }
    public function city($id){
        $data = City::where('state_id' , $id)->get();
        if($data){
            return response()->json($data);
        }
        else{
            return response()->json(['error' => true]);
        }
    }
}
