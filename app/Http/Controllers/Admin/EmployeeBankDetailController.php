<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeBankDetail;
use Illuminate\Http\Request;

class EmployeeBankDetailController extends Controller
{

    public $parentModel = EmployeeBankDetail::class;
    public $parentRoute = 'employees';
    public $parentView  = 'Admin.employee';

    public function create(){
        try{
            $this->parentModel::role('view_status', null , null);
            $data['employees'] = Employee::latest()->get();
            return view($this->parentView.'.bank_details' , $data);
        }

    catch(\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
    }
    public function store(Request $request){
       try{
        $this->parentModel::role('create_status', null , null);
        $data = $request->except("_token");

        $storeData = $this->parentModel::updateOrCreate(['employee_id' => $data['id']], $data);
        if($storeData){
            return response()->json(['success'=> true]);
        }
        else{
            return response()->json(['error'=> true]);

        }
       }
       catch(\Exception $e){
        return response()->json(['error'=> $e->getMessage()]);
       }
    }
    public function employee_bank_details($id = null){
        try{

            $employeeData = $this->parentModel::where('employee_id', $id)->first();
            if(!empty($employeeData)){
                return response()->json(['data' => $employeeData]);
            }
            else{
                return response()->json(['error' => true]);
            }
        } catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);

        }
    }

}
