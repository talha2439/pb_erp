<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notifications;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Employee, EmployeeBankDetail, User , SubMenu , UserAccess};
use Illuminate\Support\Facades\Auth;
use Str;
use Hash;
use Mail;
use Carbon\Carbon;
class UserController extends Controller
{
        public $parentModel = User::class;
        public $childModel  = UserAccess::class;
        public $menuModel   = SubMenu::class;
        public $parentView  = 'Admin.user';
        public $parentRoute = "users";
        public $imagePath  = 'images/UsersImages/';
        public $roleRoute  = 'users.index';
        public function index(Request $request){
          $this->parentModel::role('view_status',$this->roleRoute,null);
          try{
            $data['user'] = $this->parentModel::whereNot('role' , 1)->get();
            if(!empty($request->type) && $request->type == "active_users"){
            $data['user'] = $this->parentModel::whereNot('role' , 1)->whereNot('email_verified_at' , null)->get();
            }
            return view($this->parentView.'.index', $data);

          }
          catch(\Exception $e){
            return redirect()->back()->with('error', "internal error: ". $e->getMessage());
          }
        }
        public function create($id = null){
            if(!empty($id)){
                $this->parentModel::role('update_status', $this->roleRoute , null);

            }
            else{
                $this->parentModel::role('create_status', $this->roleRoute , null);

            }
           try{
            $data['action'] = $id == null? 'create': 'edit';
            $data['user']   = $this->parentModel::where('id', $id)->first();
            return view($this->parentView.'.create', $data);

           }
           catch(\Exception $e){
            return redirect()->back()->with('error', "internal error: ". $e->getMessage());
           }
        }

        public function store(Request $request, $id = null){
            if(!empty($id)){
                $this->parentModel::role('update_status', $this->roleRoute , null);

            }
            else{
                $this->parentModel::role('create_status', $this->roleRoute , null);

            }
            $data                = $request->except('_token');
            $query               = $request->query('type');

            // Update Bank Details
            if($query == 'profile'){
                if(!empty($data['employee_id'])){
                $storeBankDetails  = EmployeeBankDetail::updateOrCreate(['employee_id' => $data['employee_id']],[
                    'employee_id' => $data['employee_id'] ?? "",
                    'name' => $data['bank_name']  ?? "",
                    'branch_name' => $data['branch_name']  ?? "",
                    'account_holder_name'=>$data['account_holder_name']  ?? "",
                    'account_number' => $data['account_number']  ?? "",
                    'iban' => $data['iban'] ?? "",
                ]);
                if($storeBankDetails){
                    unset($data['employee_id']);
                    unset($data['bank_name']);
                    unset($data['branch_name']);
                    unset($data['account_holder_name']);
                    unset($data['account_number']);
                    unset($data['iban']);
                }
                }
            }


            if($query == 'profile'){
            try{
            $storeStatus         = empty($id)  ? 'saved' : 'updated';
            if($request->hasFile('image')){
                $filename = str_replace(' ' , '-' , strtolower($data['username'])).'.'.$data['image']->getClientOriginalExtension();
                $data['image']->move($this->imagePath , $filename);
                $data['image'] = $filename;
                // To Remove existing image while updating profile
                if(!empty($id)){
                    $imageFile =  $this->parentModel::where('id' , $id)->first();
                    $imagePath =  asset($this->imagePath . $imageFile->image);
                    if(file_exists($imagePath)){
                        unlink($imagePath);
                    }
                }
            }
            $data['email_verified_at']      = isset($data['active']) == "on" ? Carbon::now() : null ; // it will check that verified user is checked or unchecked
            // To check user name and email
            if(empty($id)){
                $checkusername       = $this->parentModel::where("username", $data['username'])->count();
                $checkemail          = $this->parentModel::where("email" , $data['email'])->count();
                if($checkusername > 0 ){
                return redirect()->back()->with('error' ,"User name already Exists..!");

                }
                if($checkemail > 0){
                return redirect()->back()->with('error' ,"Email address already Exists..!");
                }
                $data['password']     =  isset($data['password']) && $data['password'] != null ? $data['password'] : Str::random(15);
                $password             =  $data['password'];
                $data['password_txt'] =  $data['password'];
                $data['password']     =  Hash::make($data['password']);
             }
                $storeUser           = $this->parentModel::updateOrCreate(['id' => $id] , $data);
                if($storeUser){
                    // Storing User Id in Acccess Management Table

                    if(empty($id)){

                        $getSubMenu = $this->menuModel::pluck('id');
                        foreach($getSubMenu  as $key => $value){
                            $storeAccess = $this->childModel::updateOrCreate(['sub_menu_id' => $getSubMenu[$key]] , [
                                'user_id'     => $storeUser->id,
                                'sub_menu_id' => $getSubMenu[$key],
                            ]);
                        }
                        $sendMessage =   Mail::send('email_templates.user_register', ['data' => $data , 'password' => $password] , function($message) use ($data){
                            $message->to($data['email'], $data['name'])->subject('Welcome to Coupon Manager');
                            $message->from(env("MAIL_FROM_ADDRESS"), env('MAIL_FROM_NAME'));
                        });
                        if($request->query('type') == 'profile'){
                            return redirect(route('profile_settings', decrypt($id)))->with('success' ,"User Information has been $storeStatus successfully..!");
                        }
                        $subject = !empty($storeUser->id) ? 'User Information Updated' : 'User Information Created';
                        $route = route('users.create', $storeUser->id);
                        $storeNotification =  $this->parentModel::notification($subject ,  $route  , $storeUser->created_at );
                        event(new Notifications($storeNotification));
                        return redirect(route($this->parentRoute.'.index'))->with('success' ,"User Information has been $storeStatus successfully..!");

                    }
                    else{

                        if($request->query('type') == 'profile'){
                            return redirect(route('profile_settings', decrypt($id)))->with('success' ,"User Information has been $storeStatus successfully..!");
                        }
                        $subject = !empty($id) ? 'User Information Updated' : 'User Information Created';
                        $route = route('users.create', $storeUser->id);
                        $storeNotification =  $this->parentModel::notification($subject ,  $route  , $storeUser->created_at );
                        event(new Notifications($storeNotification));
                        return redirect(route($this->parentRoute.'.index'))->with('success' ,"User Information has been $storeStatus successfully..!");
                    }
                }
                else{
                    return redirect()->back()->with('error' ,"Failed to $storeStatus user information. Please try again later..!");
                }
            }
            catch(\Exception $e){
                return redirect()->back()->with('error' , "Internal Server Error:". $e);
             } }


        }
        public function status(Request $request , $id){
            $role = $this->parentModel::role('update_status',$this->roleRoute,'response');
            if(!empty($role)){
                return $role;
            }
            try{


            $activeStatus = $request->status == 1 ? Carbon::now() : null;
            $deactive = $this->parentModel::where('id' , $id)->update(['email_verified_at' => $activeStatus]);
            $userInfo = $this->parentModel::where('id' , $id)->first();
            if($deactive)
            {
                if($request->type =='deactivate'){
                    return redirect(route('auth.logout'))->with('error' , 'Your account has been deactivated. you have no longer access to your account.');
                }
                $status = $request->status == 1 ? 'Activated' : 'Deactivated';
                $subject = 'User has been ' ." ". $status;
                $route = route('users.create', $id);
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , $userInfo->updated_at );
                event(new Notifications($storeNotification));
                return response()->json(['success' => true]);
            }
            else{
                return response()->json(['error' => true]);
            }

            }
            catch(\Exception $e){
                return response()->json(['error' =>$e->getMessage()]);
            }
        }
        public function delete($id){
            $role = $this->parentModel::role('delete_status',$this->roleRoute,'response');
            if(!empty($role)){
                return $role;
            }
        try{
            $checkEmployee = Employee::where('user_id' , $id)->count();
            if($checkEmployee > 0){
                return response()->json(['exists' => true]);
            }

            $delete  =  $this->parentModel::where('id', $id)->delete();
            if($delete){
                $subject = 'User has been Deleted';
                $route = route('users.index');
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , Carbon::now()->format('d F , Y h:iA') );
                event(new Notifications($storeNotification));
                return response()->json(['success' => true]);
            }
            else{
                return response()->json(['error' => true]);
            }
            }
            catch(\Exception $e){
                return response()->json(['error' =>$e->getMessage()]);
         }

        }

}
