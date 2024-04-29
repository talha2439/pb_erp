<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeExperience extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['employee_id', 'job_title', 'designation', 'start_date', 'end_date', 'description' , 'salary','reason_for_leaving' ,'attachment'];
}
