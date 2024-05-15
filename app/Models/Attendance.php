<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attendance extends Model
{
    use HasFactory ,SoftDeletes;
    protected $fillable = ['employee_id', 'date', 'check_in', 'check_out', 'working_hours','extra_hours','total_hours','working_status' ,'deleted_at' , 'attendance_status'];
    public function users(){
        return $this->hasOne(User::class , 'id' , 'employee_id');
    }
}
