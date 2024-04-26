<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeQualification extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['employee_id','institute','qualification' , 'document' , 'start_date','end_date','status','gpa','percentage'];
    public function employees(){
        return $this->hasOne(Employee::class , 'id' , 'employee_id');
    }
}
