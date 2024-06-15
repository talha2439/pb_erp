<?php
namespace App\Trait;

use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;

trait Crud {
    public static function columns($table){
        $columns = Schema::getColumnListing($table);
        return $columns;
    }
    public static function notification($subject  , $data ,  $type , $relations = null){
        $created_at   = Carbon::parse($data->created_at)->format('F d, Y h:i:s A');
        $allData = $data;
        if(!empty($relations)){
        $allData =   $data->with($relations)->first();
        }
        $storeNotification = [
            'subject' => $subject,
            'user_id' => $data->user_id,
            'created_at' => $created_at,
            'data' =>  json_encode($allData),
            'type' => $type,
        ];

        return $storeNotification;
    }
}
