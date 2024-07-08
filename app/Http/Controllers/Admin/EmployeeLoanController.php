<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeLoan;
use App\Models\LoanType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class EmployeeLoanController extends Controller
{
    public $parentModel     = Employee::class;
    public $childModel      = EmployeeLoan::class;
    public $subChildModel   = LoanType::class;
    public $parentView      = 'Admin.employee_loans';
    public $parentRoute     = 'employee_loans';
    public function index(){
        $data['loans'] = $this->childModel::latest()->with(['employees','loan_types'])->get();
        return view($this->parentView.'.index' , $data);
    }
    public function create($id = null){
        $data['employees'] = $this->parentModel::latest()->get()->map(function($query){
            return [
                'id' => $query->id,
                'name' => $query->first_name .' ' . $query->last_name
            ];
        })->pluck('name', 'id');
        $data['loan_types'] = $this->subChildModel::latest()->pluck('name', 'id');
        $data['loan']       = $this->childModel::where('id' , $id)->first();
        $data['action']     =  !empty($data['loan']) ? 'edit':'create';
        return view($this->parentView.'.create', $data);

    }
    public function store( Request $request , $id = null){
        try{
            $data = $request->except('_token');
            // Check If there is any loan is already available
            $checkLoan  =  $this->childModel::where(['employee_id'=> $data['employee_id'] , 'status' => 'pending' , 'loan_type_id' => $data['loan_type_id']])
                          ->orWhere(['status' => 'approved'])->count();
            if($checkLoan > 0){
                return redirect()->back()->with('error' ,'Cannot request for loan for this employee , there are already some pending loans for this employee..!');
            }
            // Check if Requested or Approved amount is equal or greated then employee salary
            $checkSalary  = $this->parentModel::where(['id' => $data['employee_id']])->first();
            if($checkSalary->salary < $data['requested_amount']){
                return redirect()->back()->with('error' ,'Requested amount must be less than or equal to Employee salary');
            };
            $storeData  = $this->childModel::updateOrCreate(['id' => $id] , $data);
            if($storeData){
                $empName          = $checkSalary->first_name. " " .$checkSalary->last_name;
                $subject = 'Loan Request For '." ".$empName." ".' has been registered';
                $route = route($this->parentRoute.'.create',$checkSalary->id);
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , Carbon::now());
                event(new Notifications($storeNotification));
                return redirect(route($this->parentRoute.'.index'))->with('success', 'Request for Loan has been registered successfully');
            }
            else{
                return redirect()->back()->with('error', 'Failed to register Request for Loan');
            }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error' , $e->getMessage());
        }
    }
}
