<?php

namespace App\Http\Middleware;

use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {

        $routeName    =  $request->route()->getName();
        $status       =  $request->session()->get('role.status');
        $type         =  $request->session()->get('role.type');

        if(!empty($routeName)){

            $checkSubMenu = SubMenu::where('route' , $routeName)->first();
            if(!empty($checkSubMenu) && !empty($status)){
                $checkAccess =  UserAccess::where(['sub_menu_id'=> $checkSubMenu->id , $status => 1 , 'user_id' => Auth::user()->id ])->first();
                $checkAdmin  =  User::where(['id' => Auth::user()->id , 'role' => 1])->count();
                if($checkAdmin <= 0 && empty($checkAccess)){
                    if($type == 'response'){

                       return response()->json(['unauthorized' => true]);
                    }
                    else{
                        abort(403);
                    }
                }
            }
        }

        return $next($request);
    }
}
