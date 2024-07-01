<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notifications;
use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Designation;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\Employee;
use App\Models\EmployeeDocument;
use App\Models\EmployeeExperience;
use App\Models\EmployeeQualification;
use App\Models\Nationality;
use App\Models\Notification;
use App\Models\Shift;
use App\Models\State;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Str;
use Yajra\DataTables\Facades\DataTables;
class EmployeeController extends Controller
{
    public $parentModel = Employee::class;
    public $userModel   = User::class;
    public $childModel  = UserAccess::class;
    public $menuModel   = SubMenu::class;
    public $parentView  = 'Admin.employee';
    public $parentRoute = "employees";
    public $imagePath  = 'images/Employees/profile/';
    public $childimagePath  = 'images/Employees/documents/';
    public function index(Request $request)
    {
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'view_status');
            if ($checkAccess) {
                $data['employees'] = $this->parentModel::latest()->get(['first_name' , 'id' , 'last_name']);
                $data['departments'] = Department::pluck('name','id');
                $data['designations'] = Designation::pluck('name','id');
                $data['shifts'] = Shift::pluck('name' , 'id');
                return view($this->parentView . '.index', $data);
            } else {
                abort(405);
            }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function employee_details($id)
    {
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'view_status');
            if ($checkAccess) {
                try {
                    $id  =  decrypt($id);

                    $data['employee'] = $this->parentModel::withTrashed()->where('id', $id)->first();
                    if(!empty($data['employee'])) {
                    return view($this->parentView . '.templates.employee_details', $data);}
                    else{
                        return redirect()->back()->with('error', 'No data found for this employee');
                    }
                } catch (\Exception $e) {
                    return redirect(route($this->parentRoute.'.index'))->with('error', $e->getMessage());
                }
            } else {
                abort(405);
            }
        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trash(Request $request)
    {
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.trash')->first();
            $checkAccess = $this->check_access($submenuId->id, 'view_status');
            if ($checkAccess) {
                $data['employees'] = $this->parentModel::onlyTrashed()->latest()->get(['first_name' , 'id' , 'last_name']);
                $data['departments'] = Department::pluck('name','id');
                $data['designations'] = Designation::pluck('name','id');
                $data['shifts'] = Shift::pluck('name' , 'id');
                return view($this->parentView . '.trash', $data);
            } else {
                abort(405);
            }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function create($id = null)
    {
        try{
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.create')->first();
        $checkAccess = $this->check_access($submenuId->id, 'create_status');
        if (!empty($id)) {
            $checkAccess = $this->check_access($submenuId->id, 'update_status');
        }
        if ($checkAccess) {
            $data['action']      = $id == null ? 'create' : 'edit';
            $data['employee']    = $this->parentModel::where('id', $id)->first();
            $data['country'] = Country::orderBy('name', 'asc')->pluck('name', 'id');
            $data['nationality'] = Nationality::orderBy('name', 'asc')->pluck('name', 'id');
            $data['users']       = $this->userModel::whereNot('role', 1)->whereNotIn('id', Employee::pluck('user_id')->toArray())
                ->get();
            if ($data['action'] == 'edit') {
                $data['users'] = $this->userModel::where('role', 4)->get();
            }
            $data['department'] = Department::all();
            return view($this->parentView . '.create', $data);
        } else {
            abort(405);
        }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function store(Request $request, $id = null)
    {
        try {
            $submenuId   = $this->menuModel::where('route', $this->parentRoute . '.create')->first();
            $checkAccess = $this->check_access($submenuId->id, 'create_status');

            if (!empty($id)) {
                $checkAccess = $this->check_access($submenuId->id, 'update_status');
            }
            if ($checkAccess) {
                $requestData = $request->data;
                parse_str($requestData, $data);

                unset($data['_token']);
                if (empty($id)) {
                    $validateEmail = $this->parentModel::where('personal_email', $data['personal_email'])->count();
                    if(isset($data['cnic_number']) && !empty($data['cnic_number'])){
                        $validateCnic = $this->parentModel::where('cnic_number', $data['cnic_number'])->count();
                        if ($validateCnic > 0) {
                            return response()->json(['error' => "Cnic number already used"]);
                        }
                    }
                    if ($validateEmail> 0) {
                        return response()->json(['error' => "Personal email already used"]);
                    }
                }
                $data['max_id']         = $this->parentModel::max('id') ?? 0;
                $data['max_id']         = ($data['max_id'] + 1);
                $data['emp_uniq_id']    = "pbhub-" . str_replace(" ", "", strtolower($data['first_name'])) . '-' . str_pad($data['max_id'], 3, '0', STR_PAD_LEFT);
                $data['martial_status'] = isset($data['martial_status']) && $data['martial_status'] == "on" ? 1 : 0;
                $data['country']        = isset($data['country']) && !empty($data['country']) ? $data['country'] : 0;
                $data['state']          = isset($data['state']) && !empty($data['state']) ? $data['state'] : 0;
                $data['city']           = isset($data['city']) && !empty($data['city']) ? $data['city'] : 0;
                $data['nationality']    = isset($data['nationality']) && !empty($data['nationality']) ? $data['nationality'] : 0;
                $data['shift']          = isset($data['shift']) && !empty($data['shift']) ? $data['shift'] : 0;
                $data['no_of_child']    = isset($data['no_of_child']) && !empty($data['no_of_child']) ? $data['no_of_child'] : 0;
                $data['start_date']     = !empty($data['start_date']) ? $data['start_date'] : null;
                $data['cnic_number']    = !empty($data['cnic_number']) ? $data['cnic_number'] : null;
                $data['end_date']       = !empty($data['end_date']) ? $data['end_date'] : null;
                if (!empty($id)) {
                    $emp_data = $this->parentModel::where('id', $id)->first();
                    $data['emp_uniq_id'] = $emp_data->emp_uniq_id;
                }
                if ($request->hasFile("image")) {
                    $filename = $data['emp_uniq_id'] . '.' . $request->file('image')->getClientOriginalExtension();
                    $request->file('image')->move($this->imagePath, $filename);
                    $data['image'] = $filename;
                    if (!empty($id)) {
                        $imageFile =  $this->parentModel::where('id', $id)->get('image');
                        $imagePath =  asset($this->imagePath . $imageFile);
                        if (file_exists($imagePath)) {
                            unlink($imagePath);
                        }
                    }
                }
                $storeData = $this->parentModel::updateOrCreate(['id' => $id], $data);
                if ($storeData) {
                    if(request()->hasFile('document')){
                        foreach($request->file('document') as $key => $value){
                            $filename = $data['emp_uniq_id'] . '-'. $key. '.'. $value->getClientOriginalExtension();
                            $value->move($this->childimagePath, $filename);
                            $data['document'][$key] = url(asset($this->childimagePath. $filename));
                            $storeImage = EmployeeDocument::create([
                                'employee_id' => $storeData->id,
                                'document' => $data['document'][$key]
                            ]);
                        }
                    }

                    $subject = !empty($id) ? 'Employee Information Updated' : 'Employee Information Created';
                    $route = route('employees.details', encrypt($storeData->id));
                    $storeNotification =  $this->parentModel::notification($subject ,  $route  , $storeData->created_at );
                    event(new Notifications($storeNotification));
                    return response()->json(['success' => true, 'emp_id' => $storeData->id]);
                } else {
                    return response()->json(['error' => true]);
                }
            } else {
                return response()->json(['unauthorized' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
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
    public function state($id)
    {
        try{
            $data = State::select('name', 'id')->where('country_id', $id)->get();
            if ($data) {
                return response()->json($data);
            } else {
                return response()->json(['error' => true]);
            }
        }
        catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()]);
        }

    }
    public function alldata(Request $request){
        $data = $this->parentModel::latest();
        if(!empty($request->query('type')) && $request->type == 'trash'){
            $data->onlyTrashed();
        }
        else if(!empty($request->query('index') && $request->type == 'index')){
            $data->withoutTrashed();
        }
        if(!empty($request->employee_id)){
            $data->where('id' , $request->employee_id);

        }
        if(!empty($request->department)){
            $data->where('department' , $request->department);

        }
        if(!empty($request->designation)){
            $data->where('designation' , $request->designation);
        }
        if(!empty($request->status)){
            $data->where('employment_status' , $request->status);
        }
        if(!empty($request->shifts)){
            $data->where('shift' , $request->shifts);
        }
        $result = $data->get();
        return DataTables::of($result)->addColumn('row_index' ,  function($item) use(&$index){
            $index ++;
            return $index;
        })->addColumn('employee_id' , function($item){
            return $item->emp_uniq_id ?? "";
        })->addColumn('first_name' , function($item){
            return $item->first_name ;
        })->addColumn('last_name', function($item) {
            return $item->last_name ?? 'Unknown';
        })->addColumn('email' ,  function($item){
            return $item->personal_email ;
        })->addColumn('department' ,  function($item){
            return $item->departments->name ?? "";
        })->addColumn('designation' ,  function($item){
            return $item->designations->name ?? "";
        })->addColumn('status' , function($item){
            $status =   '<center>
                <div class="bg-danger text-white fw-bold p-1  shadow-sm text-center "
                style="font-size: 10px ;width:75px; border-radius:4px; border:1px solid rgba(80, 3, 3, 0.288)">
                Resigned</div>
                </center>';
            if($item->employment_status == "probhition"){
            $status = ' <center><div class="bg-warning text-white fw-bold p-1 shadow-sm text-center "style="font-size: 10px ;width:65px; border-radius:4px; border:1px solid rgba(212, 132, 11, 0.322)">Probition</div></center>';
            }
            else if($item->employment_status == "parmanent"){
            $status = '<center>
                                        <div class="bg-success text-white fw-bold p-1 shadow-sm text-center "
                                            style="font-size: 10px ;width:65px; border-radius:4px; border:1px solid rgba(3, 80, 35, 0.349)">
                                            Permanent</div></center>';
            }
            else if($item->employment_status == "internship"){
            $status = ' <center>
                                        <div class="bg-info text-white fw-bold p-1 shadow-sm text-center "
                                            style="font-size: 10px ;width:65px; border-radius:4px; border:1px solid rgba(3, 39, 80, 0.192)">
                                            Internship</div>
                                    </center>';
            }
            return $status ;
        })->addColumn('salary' ,  function($item){
            $salary = '<div class="d-flex justify-content-between g-3  p-2">
            <input style="border:none; width:60px" class="salary" readonly type="password"
                value='.$item->salary.'>
            <button class="fa fa-eye eye_icon"
                style="background: none;border:none; position:relative;bottom:2px"
                data-type="show"></button>
        </div>';
        return $salary;
        })->addColumn('document' , function($item){
            $docRoute = route('employees.documents' , $item->id);
            $docs = '<center> <a href="'.$docRoute.'" class="btn btn-primary shadow text-white"> <div class="fa fa-file-invoice"></div></a></center>';
            return $docs;
        })->addColumn('qualification' , function($item){
            $qualification  = '  <center>
                                    <a class="btn btn-info text-white btn-sm showQualification"
                                        data-id="'.$item->id.'" data-bs-toggle="modal"
                                        data-bs-target="#qualificationModal">
                                        <i class="fa-solid fa-file-invoice"></i>
                                    </a>
                                </center>';
            return $qualification;
        })->addColumn('experience' ,  function($item){
            $experience = '<center>
                                    <a class="btn btn-warning text-white btn-sm showExperience" data-bs-toggle="modal"
                                        data-bs-target="#experienceModal"
                                        data-id="'.$item->id.'">
                                        <i class="fa-solid fa-square-poll-horizontal"></i>
                                    </a>
                                </center>';
            return $experience;
        })->addColumn('details' ,  function($item){
            $detailsRoute = route('employees.details', encrypt($item->id));
                $details = ' <center>
                    <a href="'.$detailsRoute.'"
                        class="btn btn-primary text-white btn-sm">
                        <i class="fa fa-eye"></i>
                    </a>
                </center>';
                return $details;
        })->addColumn('action' , function($item) use($request){
            $actionRoute =  $request->type =='index' ?  route('employees.create', $item->id) : route('employees.restore', $item->id) ;
            $editOrRestore  = $request->type =='index' ? ' <a class="btn btn-success text-white"
                                    href="'.$actionRoute.'"> <i class="fe fe-edit"></i></a>' : '<a class="btn btn-success text-white"href="'.$actionRoute.'"> <i class="fa fa-undo"></i></a>';
            $action = '<a class="btn btn-danger text-white deleteEmployee" data-id="'.$item->id.'"> <i
                                        class="fe fe-trash"></i></a> | '.$editOrRestore.'
                            </td>';
            return $action ;
        })->rawColumns(['row_index' ,'employee_id','first_name' ,'last_name','department','designation','email','salary','document','details','qualification','experience','action','status' ])->make(true);


    }
    public function city($id)
    {
       try{
        $data = City::select('name' , 'id')->where('state_id', $id)->get();
        if ($data) {
            return response()->json($data);
        } else {
            return response()->json(['error' => true]);
        }
       }
       catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function designation_and_shift($id)
    {
       try{
        $data['shift']              = Shift::where('department', $id)->withoutTrashed()->first();
        $data['shift']->start_time  = Carbon::parse($data['shift']->start_time)->format('h:i A');
        $data['shift']->end_time    = Carbon::parse($data['shift']->end_time)->format('h:i A');
        $data['designation']        = Designation::where('department', $id)->withoutTrashed()->first();
        if ($data) {
            return response()->json($data);
        }
       }
       catch (\Exception $e){
                return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
                $empDetail        = $this->parentModel::where('id', $id)->first();
                $empName          = $empDetail->first_name. " " .$empDetail->last_name;
                $subject = 'Information For Employee'." ".$empName." ".' has been Deleted';
                $route = route('employees.index');
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , Carbon::now() );
                event(new Notifications($storeNotification));
                $delete        = $this->parentModel::where('id', $id)->delete();
                $removeQualification = EmployeeQualification::where('employee_id', $id)->delete();
                $removeExp           = EmployeeExperience::where('employee_id', $id)->delete();
                if ($delete) {

                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => true]);
                }
            } else {
                return response()->json(['unauthorized' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');

            if ($checkAccess) {
                $empDetail        = $this->parentModel::where('id', $id)->withTrashed()->first();
                $empName          = $empDetail->first_name. " " .$empDetail->last_name;
                $subject = 'Information For Employee'." ".$empName." ".' has been Deleted';
                $route = route('employees.index');
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , Carbon::now() );
                event(new Notifications($storeNotification));
                $delete        = $this->parentModel::where('id', $id)->forceDelete();
                $forceDeleteQualification = EmployeeQualification::where('employee_id', $id)->forceDelete();
                $forceDeleteExp           = EmployeeExperience::where('employee_id', $id)->forceDelete();
                $forceDeleteDoc           = EmployeeDocument::where('employee_id', $id)->forceDelete();
                if ($delete) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => true]);
                }
            } else {
                return response()->json(['unauthorized' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function delete_document($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');

            if ($checkAccess) {
                $documentDetail   = EmployeeDocument::where('id' , $id)->first();
                $empDetail        = $this->parentModel::where('id', $documentDetail->employee_id)->withTrashed()->first();
                $empName          = $empDetail->first_name. " " .$empDetail->last_name;
                $subject = 'Documents For Employee '." ".$empName." ".' has been Deleted';
                $route = route('employees.index');
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , Carbon::now() );
                event(new Notifications($storeNotification));
                $delete        = EmployeeDocument::where('id', $id)->forceDelete();
                if ($delete) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => true]);
                }
            } else {
                return response()->json(['unauthorized' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function documents($id){
       try{
        $data['document'] = EmployeeDocument::where('employee_id', $id)->get();
        if ($data) {
            return view($this->parentView.'.documents' , $data);
        } else {
         return redirect()->back()->with('error', 'There is no employee document');
        }
       }
       catch(\Exception $e){
        return redirect()->back()->with('error', $e->getMessage());
       }
    }
    public function restore($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
                $empDetail        = $this->parentModel::where('id', $id)->withTrashed()->first();
                $empName          = $empDetail->first_name. " " .$empDetail->last_name;
                $subject = 'Information For Employee '." ".$empName." ".' has been Restored';
                $route = route('employees.index');
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , Carbon::now() );
                event(new Notifications($storeNotification));
                $restore = $this->parentModel::where('id', $id)->restore();
                $restoreQualification = EmployeeQualification::where('employee_id', $id)->restore();
                $restoreExp           = EmployeeExperience::where('employee_id', $id)->restore();
                if ($restore) {
                    return redirect(route($this->parentRoute . '.index'))->with(['success' => 'Employee Information has been restored successfully']);
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with(['error' => 'Failed to restore Employee Information']);
                }
            }
        } catch (\Exception $e) {
            return redirect(route($this->parentRoute . '.index'))->with(['error' => $e->getMessage()]);
        }
    }
}
