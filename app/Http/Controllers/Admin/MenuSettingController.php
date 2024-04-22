<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\{Menu , SubMenu};
use Illuminate\Http\Request;
use Route;

class MenuSettingController extends Controller
{

    public $parentModel = Menu::class;
    public $childModel = SubMenu::class;
    public $parentView = 'Admin.menu';
    public $parentRoute= 'menusettings';

    public function index(){
        $data['menu'] = $this->parentModel::with('submenu')->paginate(20);
        return view($this->parentView.'.index', $data);
    }
    public function create($id = null){
        $data['action'] = $id == null? 'create': 'edit';
        $data['menu']   = $this->parentModel::where('id', $id)->with('submenu')->first();
        return view($this->parentView.'.create', $data);
    }

    public function store(Request $request, $id = null){
        try{
            $data  = $request->except('_token');
        $data['has_sub'] = isset($data['has_sub']) == "on" ? 1 : 0;

        if($data['has_sub'] == 1){
            $storeMenu  = $this->parentModel::updateOrCreate(['id' => $id],[
                'menu_title' => $data['menu_title'],
                'name' => $data['name'],
                'icon' => $data['icon'],
                'has_sub' => $data['has_sub'],
            ]);
           $removeSubMenu = $this->childModel::where('menu_id', $storeMenu->id)->delete();
           foreach($data['sub_menu_name'] as $key => $value){
            $storeSubMenu = $this->childModel::create([
                'menu_id' => $storeMenu->id,
                'name'    => $data['sub_menu_name'][$key],
                'route'   => $data['route'][$key],
            ]);
           }
           if($storeMenu && $storeSubMenu){

            return response()->json(['success' => true]);
            }
            else{
                return response()->json(['error' => true]);
            }
        }
        else{
            $storeMenu  = $this->parentModel::updateOrCreate(['id' => $id],[
                'name' => $data['name'],
                'menu_title' => $data['menu_title'],
                'icon' => $data['icon'],
                'route' => $data['route'][0],
            ]);
            $storeSubMenu = $this->childModel::updateOrCreate(['menu_id' => $id] , [
                'name'    => $data['name'] ,
                'route'   => $data['route'][0],
                'menu_id' => $storeMenu->id
            ]);
            if($storeMenu && $storeSubMenu){
                return response()->json(['success' => true]);
            }
            else{
                return response()->json(['error' => true]);
            }
        }
        }catch(\Exception $e){
            return response()->json(['error'=> $e->getMessage()]);
        }

    }
    public function check_routes(Request $request){
        $route  = $request->route;
        $missingRoutes = [];
        foreach($route as $key => $value){
            if(!Route::has($route[$key])){
                $missingRoutes[] = $route[$key];
            }
        }
        if(empty($missingRoutes)){
            return response()->json(['success'=>true]);
        }
        else {
            return response()->json(['error' => "Route's name is not available in web.php [" . implode(', ', $missingRoutes) . "]"]);
        }

    }

    public function delete($id){
        $delete  =  $this->parentModel::where('id', $id)->delete();
        $deleteSubmenu  = $this->childModel::where('menu_id', $id)->delete();

        if($delete && $deleteSubmenu){
            return response()->json(['success' => true]);
        }
        else{
            return response()->json(['error' => true]);
        }
    }

}
