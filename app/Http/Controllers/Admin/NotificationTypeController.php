<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NotificationType;
use Illuminate\Http\Request;

class NotificationTypeController extends Controller
{
    public $parentModel  = NotificationType::class;
    public $parentView   = 'Admin.notification_types';
    public $parentRoute   = 'notification_types';
    public $roleRoute     = 'notification_types.index';
    public function index(){
        $this->parentModel::role('view_status',  $this->roleRoute );
        try{
            return view($this->parentView.'.index');
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
