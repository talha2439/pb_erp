<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeQualification;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployeeQualificationController extends Controller
{
    public $parentModel = EmployeeQualification::class;
    public $imagePath = 'images/employee_qualification/';
    public $parentRoute = "employees";
    public $menuModel  = SubMenu::class;
    public $roleRoute = 'employees.index';
    public function edit($id = null)
    {
        try{
            $emp_qualification = $this->parentModel::where('employee_id', $id)->get();
            return response()->json(['qualification' => $emp_qualification]);
        }
        catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function store(Request $request, $id = null)
    {
        if(!empty($id)){
            $this->parentModel::role('update_status', $this->roleRoute , null);

        }
        else{
            $this->parentModel::role('create_status', $this->roleRoute , null);

        }
        try {
                $requestData = $request->data;
                parse_str($requestData, $data);
                $data['employee_id'] = $request->employee_id;
                unset($data['_token']);
                unset($data['csrf_token']);


                $currentDate = Carbon::now()->format('Y-m-d');

                foreach ($data['institute'] as $key => $value) {

                    $fileNames = null;
                    if (!empty($request->file("document")[$key])) {
                        $fileNames = str_replace(" ", "", $data['qualification'][$key]) . '_' . time() . '.' . $request->file('document')[$key]->getClientOriginalExtension();
                        $request->file('document')[$key]->move($this->imagePath, $fileNames);
                    }
                    if($fileNames == null){
                        $checkname = $this->parentModel::where('id' , $data['qualification_id'][$key] )->first();
                        if(!empty($checkname)){
                            $fileNames = $checkname->document;
                        }
                        else{
                            $fileNames = null;
                        }
                    }
                    $enddate = Carbon::parse($data['end_date'][$key])->format('Y-m-d');
                    $status = $currentDate == $enddate ? 1 : 0;
                    $qualificationId = isset($data['qualification_id'][$key]) ? $data['qualification_id'][$key] : null;
                    $storedata = $this->parentModel::updateOrCreate(['id' => $qualificationId], [
                        'institute' => $data['institute'][$key],
                        'document' => $fileNames ?? "",
                        'qualification' => $data['qualification'][$key],
                        'employee_id' => $data['employee_id'],
                        'start_date' => $data['start_date'][$key],
                        'end_date' => $data['end_date'][$key],
                        'status' => $status,
                        'gpa' => !empty($data['gpa'][$key]) ? $data['gpa'][$key] : 0,
                        'percentage' => !empty($data['percentage'][$key]) ? $data['percentage'][$key] : 0,
                    ]);
                }
                if ($storedata) {
                    $subject = !empty($id) ? 'Employee Qualification Information Updated' : 'Employee Qualification Information Created';
                    $route = route('employees.details', encrypt($storedata->id));
                    $storeNotification =  $this->parentModel::notification($subject ,  $route  , $storedata->created_at );
                    event(new Notifications($storeNotification));
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => true]);
                }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        $this->parentModel::role('delete_status',$this->roleRoute,'response');
        try {

                $delete        = $this->parentModel::where('id', $id)->forceDelete();
                if ($delete) {
                    return response()->json(['success' => true]);
                } else {
                    return response()->json(['error' => true]);
                }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function get_qualification($id){
        $this->parentModel::role('view_status' ,$this->roleRoute,'response');
        try {
                $qualification        = $this->parentModel::withTrashed()->where('employee_id', $id)->get();
                if ($qualification) {
                    return response()->json(['success' => true , 'data' => $qualification]);
                } else {
                    return response()->json(['error' => true]);
                }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

}
