<?php

namespace App\Http\Controllers\Admin;

use App\Events\Notifications;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeLoan;
use App\Models\LoanInstallment;
use App\Models\LoanType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Number;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class LoanInstallmentController extends Controller
{
    public $parentModel  = LoanInstallment::class;
    public $childModel   = EmployeeLoan::class;
    public $parentView   = 'Admin.employee_loans.installment';
    public $parentRoute  = 'loan_installment';
    public $roleRoute    = 'loan_installment.index';
    public $imagePath    = 'images/loans_installment/';
    public function index(){
       if(Auth::user()->role != 1){
        $data['loan'] = $this->childModel::where(['employee_id'=> Auth::user()->employees->id,'status' => 'approved'])->whereNot('status','paid')->first();
        return view($this->parentView.'.index', $data);
       }
       else{
            abort(403);
       }
    }
    public function store(Request $request){
        $this->parentModel::role('create_status', $this->roleRoute , null);
        try{

            $data  = $request->except('_token');
            $loanData = $this->childModel::where('id' , $data['loan_id'])->first();
            if($loanData->remaining_amount < $data['amount']){
                return redirect()->back()->with('error' ,'Installment cannot be greater than remaining amount..!');
            }

            if($request->hasFile('attachment')){
                $filename = $loanData->employees->emp_uniq_id.'.'.$data['attachment']->getClientOriginalExtension();
                $request->file('attachment')->move($this->imagePath , $filename);
                $data['attachment'] = $filename;
            }
            $data['payment_date'] = Carbon::now()->format('Y-m-d');
            $storeData = $this->parentModel::create($data);
            if($storeData){
                $loanData->remaining_amount -= $data['amount'];
                $loanData->paid_amount += $data['amount'];
                $loanData->status   = $loanData->remaining_amount == 0 ? 'paid' : 'approved';
                $loanData->save();
                $firstName = $loanData->employees->first_name ?? "" ;
                $lastName  = $loanData->employees->last_name ?? "";
                $empName          = $firstName. " " . $lastName;
                $subject = 'Loan Installment Paid By  '.$empName ;
                $route = route($this->parentRoute.'.list',$loanData->id);
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , Carbon::now());
                event(new Notifications($storeNotification));
                if($loanData->remaining_amount == 0){

                    return redirect()->back()->with('success' ,'All Installments has been cleared..!');
                }
                return redirect()->back()->with('success' ,'Installment has been Paid..!');

            }
            else{
                return redirect()->back()->with('error' ,'Failed to pay loan installment..!');

            }
        }
        catch(\Exception $e){
            return redirect()->back()->with('error' ,$e->getMessage());

        }
    }
    public function list(){
        $this->parentModel::role('view_status' , $this->roleRoute , null);

        $data['employees'] = Employee::where('employment_status' , 'parmanent')->latest()->get()->map(function($query){
            return [
                'id' => $query->id,
                'name' => $query->first_name .' ' . $query->last_name
            ];
        })->pluck('name', 'id');
        $data['loan_type']  = LoanType::latest()->pluck('name' , 'id');
        return view($this->parentView.'.list' ,$data);
    }
    public function allData(Request $request){
        $data  = $this->parentModel::latest();
        $employee_id = Auth::user()->role == 4 ? Auth::user()->employees->id : $request->employee_id;
        if(!empty($employee_id)){
            $data->whereHas('loans' , function($query) use($employee_id){
                $query->where('employee_id', $employee_id);
            });
        }
        if(!empty($request->loan_type)){
            $data->whereHas('loans' , function($query) use($request){
                $query->where('loan_type_id', $request->loan_type);
            });
        }
        if(!empty($request->date)){
            $data->whereDate('payment_date', $request->date);
        }

        $result = $data->get();
        return DataTables::of($result)->addColumn('index', function($item) use (&$index){
            $index ++;
            return $index;
        })->addColumn('emp_id' , function($item){
            return $item->loans->employees->emp_uniq_id ?? 0;
        })->addColumn('first_name' , function($item){
            return $item->loans->employees->first_name ?? "";
        })->addColumn('last_name' , function($item){
            return $item->loans->employees->last_name ?? '';
        })->addColumn('total_amount', function($item){
            return Number::currency($item->loans->approved_amount ,'PKR' , 'en_PK') ?? 0 ;
        })->addColumn('installment_amount', function($item){
            return Number::currency(!empty($item->amount) ? $item->amount : 0 ,'PKR' , 'en_PK')?? 0 ;
        })->addColumn('remaining_amount' , function($item){
            return Number::currency(!empty($item->loans->remaining_amount) ? $item->loans->remaining_amount: 0 ,'PKR' ,'en_PK') ?? 0;
        })->addColumn('paid_amount', function($item){
            return Number::currency(!empty($item->loans->paid_amount)?$item->loans->paid_amount:0,'PKR','en_PK') ?? 0;
        })->addColumn('payment_date' , function($item){
            return Carbon::parse($item->payment_date)->format("F d , y")?? "";
        })->addColumn('confirmed_by' , function($item){
            return $item->confirmed_by?? "";
        })->addColumn('confirmed_at' , function($item){
            return Carbon::parse($item->confirmed_at)->format("F d , y H:i")?? "";
        })->addColumn('attachment' , function($item){
            $btn = '<a href=""  class="btn  btn-info text-white"> <i class="fe fe-eye"></i></a>';
            return $btn;
        })
        ->addColumn('status' , function($item){
            $statusBtn = 'fe fe-check';
            $status = $item->status == 0 ? 'success' : 'danger disabled';
            if($item->status == 1){
                $statusBtn = 'fe fe-minus-circle';

            }
            $btn = '<a href="#"  class="btn changeStatus text-white btn-'.$status.'" data-id="'.$item->id.'"> <i class="'.$statusBtn.'"></i></a>';
            return $btn;
        })->addColumn('action' , function($item){
            $status = $item->loans->remaining_amount <= 0 ? 'disabled' : '';
            $btn = '<a href="#"  class="btn text-white btn-primary"> <i class="fe fe-printer"></i></a> | <a href="#" data-id="'.$item->id.'" data-bs-toggle="modal"
                                        data-bs-target="#editModal" data-amount="'.$item->amount.'" class="btn editBtn   '.$status.'  text-white btn-success"> <i class="fe fe-edit"></i></a>';
            return $btn;
        })->rawColumns(['index','attachment' , 'emp_id' , 'last_name' , 'first_name' , 'total_amount' ,'installment_amount','remaining_amount','paid_amount','payment_date','confirmed_by','confirmed_at','status','action'])->make(true);

    }

    public function status($id = null){
        $role = $this->parentModel::role('update_status',$this->roleRoute,'response');
        if(!empty($role)){
            return $role;
        }
        try{
            $data = $this->parentModel::where('id' , $id)->first();
            if(!empty($data)){

                $updated =  $data->update([
                    'status' => 1,
                    'confirmed_by' =>Auth::user()->name ,
                    'confirmed_at' => Carbon::now(),
                ]);
            $loanData = $this->childModel::where('id' , $data->loan_id)->first();

              if($updated){
                $firstName = $loanData->employees->first_name ?? "" ;
                $lastName  = $loanData->employees->last_name ?? "";
                $empName          = $firstName. " " . $lastName;
                $subject = 'Loan Installment Confirmed for  '.$empName ;
                $route = route($this->parentRoute.'.list',$loanData->id);
                $storeNotification =  $this->parentModel::notification($subject ,  $route  , Carbon::now());
                event(new Notifications($storeNotification));
                return response()->json(['success' => true]);
              }
              else{
                return response()->json(['error' => true]);
              }
            }
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function update(Request $request){
        $role = $this->parentModel::role('update_status',$this->roleRoute,'response');
        if(!empty($role)){
            return $role;
        }
        try{
            $data = $request->except('_token');
            $update = $this->parentModel::where('id' , $data['id'])->first();
            $loanData = $this->childModel::where('id' , $update->loan_id)->first();
            if($update){
                if ($update->amount == 0) {
                    return response()->json(['exceed' => true]);
                }
                $remainingData = $loanData->remaining_amount;
                $paid_amount = $loanData->paid_amount;
                if ($loanData->remaining_amount + $update->amount - $data['amount'] < 0) {
                    return response()->json(['exceed' => true]);
                }
                $loanData->remaining_amount += $update->amount;
                $loanData->paid_amount -= $update->amount;
                $loanData->save();
                $update->amount = $data['amount'];
                $update->save();
                $newdata = $this->parentModel::where('id', $data['id'])->first();
                $loanData->remaining_amount -= $newdata->amount;
                $loanData->paid_amount += $newdata->amount;
                if ($loanData->remaining_amount < 0) {

                    $loanData->remaining_amount = $remainingData;
                    $loanData->paid_amount = $paid_amount;
                    $loanData->save();
                    return response()->json(['exceed' => true]);
                }
                if($loanData->remaining_amount == 0){
                    $loanData->status = 'paid';
                }
                $loanData->save();
                return response()->json(['success' => true]);
            }
            else{
                return response()->json(['error' => true]);
            }
        }
        catch(\Exception $e){
            return response()->json(['error' => $e->getMessage()]);
        }
    }
}
