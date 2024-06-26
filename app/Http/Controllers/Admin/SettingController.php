<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public $parentModel = Setting::class;
    public $parentRoute = 'setting';
    public $parentView  = 'Admin';
    public $imagePath   = 'images/settings/';
    public function create(){
        try{
            $data['settings']  = $this->parentModel::latest()->first();
            $data['action']    = !empty($data['settings']) ? 'edit' : 'create';
            return view($this->parentView.'.settings' , $data);
        }

    catch(\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
    }
    public function store(Request $request , $id = null){
       try{
        $data = $request->except("_token");
        $data['email_send']  = isset($data['email_send']) && $data['email_send'] == "on" ? 1 : 0 ;
        if($request->hasFile('favicon')){
            $favicon = time().'.'.$request->file("favicon")->getClientOriginalExtension();
            $request->file('favicon')->move($this->imagePath.'favicon', $favicon);
            $data['favicon'] = url(asset($this->imagePath.'favicon/'.$favicon));
        }
        if($request->hasFile('logo')){
            $logo = time().'.'.$request->file("logo")->getClientOriginalExtension();
            $request->file('logo')->move($this->imagePath.'logo', $logo);
            $data['logo'] = url(asset($this->imagePath.'logo/'.$logo));
        }
        if($request->hasFile('light_logo')){
            $light_logo = time().'.'.$request->file("light_logo")->getClientOriginalExtension();
            $request->file('light_logo')->move($this->imagePath.'light_logo', $light_logo);
            $data['light_logo'] = url(asset($this->imagePath.'light_logo/'.$light_logo));
        }
        if(empty($id)){
            $data['created_by'] = Auth::user()->name;
        }
        else{
            $data['updated_by'] = Auth::user()->name;
        }
        $storeData = $this->parentModel::updateOrCreate(['id' => $id], $data);
        if($storeData){
            return redirect()->back()->with('success', 'Settings has been updated successfully');
        }
        else{
            return redirect()->back()->with('error' , 'Failed to update settings');
        }
       }
       catch(\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
       }
    }
}
