<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [

            'emp_uniq_id',
            'user_id',
            'image',
            'cv_file',
            'first_name',
            'last_name',
            'date_of_birth',
            'personal_email',
            'personal_contact',
            'emergency_contact',
            'emergency_contact_person',
            'emergency_contact_relation',
            'permanent_address',
            'present_address',
            'country',
            'state',
            'city',
            'nationality',
            'religion',
            'joining_date',
            'employment_status',
            'cnic_number',
            'blood_group',
            'martial_status',
            'no_of_child',
            'designation',
            'department',
            'designation',
            'shift',
            'salary',
            'gender',
            'start_date',
            'end_date',

    ];
    public function users(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function departments(){
        return $this->hasOne(Department::class, 'id', 'department');
    }
    public function qualifications(){
        return $this->hasMany(EmployeeQualification::class , 'employee_id' , 'id');
    }
    public function shifts(){
        return $this->hasOne(Shift::class , 'id' , 'shift');
    }
    public function experiences(){
        return $this->hasMany(EmployeeExperience::class , 'employee_id' , 'id');
    }
}
