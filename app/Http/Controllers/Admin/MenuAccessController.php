<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{ Menu , SubMenu , MenuAccessManagment };
use Illuminate\Http\Request;

class MenuAccessController extends Controller
{
    public $parentModel     = Menu::class;
    public $childModel      = MenuAccessManagment::class;
    public $subMenuModel    = SubMenu::class;
    public $parentView      = 'Admin.menu';
    public $parentRoute     ='menusettings';

    public function index($id = null){
        $data['access'] = $this->subMenuModel::where('menu_id', $id)->with(['menu_access'])->get();
        return view($this->parentView.'.role', $data);
    }

    public function changeAccess(Request $request  , $id = null){
        $data = $request->all();
        $changeAccess = $this->childModel::updateOrCreate(['sub_menu_id' => $id] , $data);
        if($changeAccess){
            return response()->json(['success' => true]);
        }
        else{
            return response()->json(['error' => true]);
        }
    }
}
