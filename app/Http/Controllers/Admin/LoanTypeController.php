<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EmployeeLoan;
use App\Models\LoanType;
use App\Models\SubMenu;
use App\Models\User;
use App\Models\UserAccess;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoanTypeController extends Controller
{
    public $parentModel =  LoanType::class;
    public $parentView  = 'Admin.loan_type';
    public $parentRoute = 'loan_type';
    public $roleRoute = 'loan_type.index';

    public function index()
    {
        $this->parentModel::role('view_status',$this->roleRoute,null);
        try{

            $data['loan_type'] = $this->parentModel::withoutTrashed()->get();
            return view($this->parentView . '.index', $data);

        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trash()
    {
        $this->parentModel::role('view_status',$this->roleRoute, null);
        try{
                $data['loan_type'] = $this->parentModel::onlyTrashed()->get();
                return view($this->parentView . '.trash', $data);

        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function create($id = null)
    {
        if(!empty($id)){
            $this->parentModel::role('update_status', $this->roleRoute , null);

        }
        else{
            $this->parentModel::role('create_status', $this->roleRoute , null);

        }
       try{
            $data['action'] = $id == null ? 'create' : 'edit';
            $data['loan_type']   = $this->parentModel::where('id', $id)->first();
            return view($this->parentView . '.create', $data);

       }
       catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
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

                $data = $request->except('_token');
                $saveData =  $this->parentModel::updateOrCreate(['id' => $id], $data);
                if ($saveData) {
                    return redirect(route($this->parentRoute . '.index'))->with('success', 'Loan Type Information has been saved');
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with('error', 'Failed to save Loan Type Information');
                }

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function delete($id)
    {
        $this->parentModel::role('delete_status',$this->roleRoute,'response');
        try {

                $delete        = $this->parentModel::where('id', $id)->first();
                $loan_exists   = EmployeeLoan::where('loan_type_id', $id)->count();

                // Check if Loan type is assigned to Loans table
                if ($loan_exists > 0) {
                    return response()->json(['loan_exists' => true]);
                }else {
                    $delete->delete();
                    if ($delete) {
                        return response()->json(['success' => true]);
                    } else {
                        return response()->json(['error' => true]);
                    }
                }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function destroy($id)
    {
        $this->parentModel::role('delete_status',$this->roleRoute,'response');
        try {

                $delete        = $this->parentModel::onlyTrashed()->where('id', $id)->first();
                $loan_exists   = EmployeeLoan::where('loan_type_id', $id)->count();
                // Check if Loan type is assigned to Loans table
                if ($loan_exists > 0) {
                    return response()->json(['loan_exists' => true]);
                }
                 else {
                    $delete->forceDelete();
                    if ($delete) {
                        return response()->json(['success' => true]);
                    } else {
                        return response()->json(['error' => true]);
                    }
                }

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function restore($id){
        $this->parentModel::role('update_status',$this->roleRoute,'response');
        try {

                $restore = $this->parentModel::where('id' , $id)->restore();
                if($restore){
                    return redirect(route($this->parentRoute.'.index'))->with(['success' => 'Loan Type has been restored successfully']);
                }
                else{
                    return redirect(route($this->parentRoute.'.index'))->with(['error' => 'Failed to restore Loan Type']);
                }

        }
        catch (\Exception $e) {
            return redirect(route($this->parentRoute.'.index'))->with(['error' => $e->getMessage()]);
        }
    }


}
