<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{User, SubMenu, UserAccess};
use Auth;
class UserAccessController extends Controller
{
    public $parentModel  = User::class;
    public $childModel   = UserAccess::class;
    public $menuModel    = SubMenu::class;
    public $parentView   = 'Admin.user';
    public $parentRoute  = 'users';

    public function index($id = null){

        $subMenuId   = $this->menuModel::where('route' , $this->parentRoute.'.index')->first();
        $checkAccess = $this->check_access($subMenuId->id , 'view_status');
        if($checkAccess){
        try{
            $id = decrypt($id);

            $data['access'] = $this->menuModel::with(['access' => function($query) use ($id) {
                    $query->where('user_id' , $id);
            }, 'menu'])->get();
            $data['user'] = User::findOrFail($id);
            return view($this->parentView . '.role' , $data);
            }
            catch(\Exception $e){
              return redirect(route('users.index'))->with('error', "internal error: " . $e->getMessage());
            }
        }
        else{
            abort(405);
        }
    }
    public function changeAccess(Request $request , $id = null){
        $subMenuId    =  $this->menuModel::where('route' , $this->parentRoute.'.index')->first();
        $checkSubMenu = $this->childModel::where(['user_id'=> $request->user_id , 'sub_menu_id' => $id])->count();

        if($checkSubMenu > 0){
            $checkAccess = $this->check_access($subMenuId->id , 'update_status');
            if(!$checkAccess){
                return response()->json(['unauthorized' => true]);
            }
        }
        else{
            $checkAccess = $this->check_access($subMenuId->id , 'create_status');
            if(!$checkAccess){
                return response()->json(['unauthorized' => true]);
            }
        }

        try{
            $data = $request->all();
            $changeAccess = $this->childModel::updateOrCreate(['sub_menu_id' => $id] , $data);
            if($changeAccess){
                return response()->json(['success' => true]);
            }
            else{
                return response()->json(['error' => true]);
            }
        }
        catch(\Exception $e){
            return response()->json($e->getMessage());
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
    
}
