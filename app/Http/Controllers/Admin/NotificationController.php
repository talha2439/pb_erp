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
        $data = $this->parentModel::latest()->where('is_readed' , 0 )->get();
        $data->transform(function($query){
            $query->created_at_formatted = Carbon::parse($query->created_at)->format('F d, Y H:i:s A');
            return $query;
        });
        return response()->json(['data' => $data]);
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
    public function destroy(){
        try{
        $delete = $this->parentModel::latest()->forceDelete();
        if($delete){
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
