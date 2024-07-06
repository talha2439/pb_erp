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

    public function index()
    {
        try{
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
        $checkAccess = $this->check_access($submenuId->id, 'view_status');
        if ($checkAccess) {
            $data['loan_type'] = $this->parentModel::withoutTrashed()->get();
            return view($this->parentView . '.index', $data);
        } else {
          abort(403);
        }
        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function trash()
    {
        try{
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'view_status');
            if ($checkAccess) {
                $data['loan_type'] = $this->parentModel::onlyTrashed()->get();
                return view($this->parentView . '.trash', $data);
            } else {
              abort(403);
            }
        }
        catch(\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function create($id = null)
    {
       try{
        $submenuId   = SubMenu::where('route', $this->parentRoute . '.create')->first();
        $checkAccess = $this->check_access($submenuId->id, 'create_status');
        if (!empty($id)) {
            $checkAccess = $this->check_access($submenuId->id, 'update_status');
        }
        if ($checkAccess) {
            $data['action'] = $id == null ? 'create' : 'edit';
            $data['loan_type']   = $this->parentModel::where('id', $id)->first();
            return view($this->parentView . '.create', $data);
        } else {
          abort(403);
        }
       }
       catch(\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
       }
    }
    public function store(Request $request, $id = null)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.create')->first();
            $checkAccess = $this->check_access($submenuId->id, 'create_status');
            if (!empty($id)) {
                $checkAccess = $this->check_access($submenuId->id, 'update_status');
            }
            if ($checkAccess) {
                $data = $request->except('_token');
                $saveData =  $this->parentModel::updateOrCreate(['id' => $id], $data);
                if ($saveData) {
                    return redirect(route($this->parentRoute . '.index'))->with('success', 'Loan Type Information has been saved');
                } else {
                    return redirect(route($this->parentRoute . '.index'))->with('error', 'Failed to save Loan Type Information');
                }
            } else {
              abort(403);
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function delete($id)
    {
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
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
            } else {
                return response()->json(['unauthorized' => true]);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }
    public function restore($id){
        try {
            $submenuId   = SubMenu::where('route', $this->parentRoute . '.index')->first();
            $checkAccess = $this->check_access($submenuId->id, 'delete_status');
            if ($checkAccess) {
                $restore = $this->parentModel::where('id' , $id)->restore();
                if($restore){
                    return redirect(route($this->parentRoute.'.index'))->with(['success' => 'Loan Type has been restored successfully']);
                }
                else{
                    return redirect(route($this->parentRoute.'.index'))->with(['error' => 'Failed to restore Loan Type']);
                }
            }
        }
        catch (\Exception $e) {
            return redirect(route($this->parentRoute.'.index'))->with(['error' => $e->getMessage()]);
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
}
