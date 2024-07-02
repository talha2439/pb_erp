<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LeaveApplication;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DataTables;
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
    public function index(){

        return view('Admin.notifications.notifications');
    }
    public function alldata(Request $request){
        $data  = $this->parentModel::latest();
        if(isset($request->readed) && $request->readed != null){
            $data->where('is_readed' , (int) $request->readed);
        }

        $result = $data->get();
        return DataTables::of($result)->addColumn('row_index' , function($item) use(&$index){
            $index ++ ;
            return $index;
        })->addColumn('message' , function($item){
            return $item->subject;
        })->addColumn('created_at', function($item){
            return Carbon::parse($item->created_at)->format('F d, Y H:i:s A');
        })->addColumn('status' , function($item){
            $status =  '<button class="btn btn-sm btn-success disabled readed">Readed</button>';
            if($item->is_readed == 0){
                $status =  '<button class="btn btn-sm btn-danger disabled readed">Un-Readed</button>';
            }
            return $status;
        })->addColumn('action', function($item){
            return'<a class="btn btn-primary text-white shadow  marknotification" data-id="'.$item->id.'" href="'.$item->route.'"><i class="fe fe-eye"></i></a> | <button class="btn btn-danger deleteNotification shadow " data-id="'.$item->id.'"><i class="fe fe-trash"></i></button>';
        })->rawColumns(['row_index', 'message','status', 'created_at' , 'action'])->make(true);
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
    
    public function delete($id){
        try{
        $delete = $this->parentModel::where(['id'=>$id])->forceDelete();
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
