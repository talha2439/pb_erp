<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public $parentModel  = Notification::class;
    public function notifications(){
        $data['leave'] = $this->parentModel::where(['is_readed'=> 0 , 'type' => 'leaveApplication' ])->with('leave_application' ,  function($query){
           $query->with(["employees"=> function($query){
                $query->with('users');
            } ,'approved','applied']);
        })->get();


        $data['leave']->transform(function($query){
            $query->created_at_formatted = Carbon::parse($query->created_at)->format('F d, Y H:i:s A');
            return $query;
        });
        return response()->json(['leave' => $data['leave']]);
    }

    public function readed($id = null){
       try{
        $update = $this->parentModel::where('id', $id)->update([
            'is_readed' => 1
        ]);

        if($update){
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
    public function markall(){
       try{
        $update = $this->parentModel::where('is_readed', 0)->pluck('id');
        $update = $this->parentModel::whereIn('id', $update)->update([
            'is_readed' => 1
        ]);

        if($update){
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
