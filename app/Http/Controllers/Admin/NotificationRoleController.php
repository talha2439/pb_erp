<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationRole;
use Illuminate\Http\Request;

class NotificationRoleController extends Controller
{
    public $parentModel = NotificationRole::class;
    public $parentView  = 'admin.notification_roles';
    public $parentRoute = 'notification_roles';
    public $roleRoute = 'notification_roles.index';
    public function index(){
        $this->parentModel::role('view_status',$this->roleRoute);
        try{


            return view($this->parentView.'.index');
        }
        catch(\Exception $e){
            return redirect()->route('dashboard')->with('error', $e->getMessage());
        }
    }
    public function create($id = null){
        $this->parentModel::role('create_status',$this->roleRoute);
        try{

        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
