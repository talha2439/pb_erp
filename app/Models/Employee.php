<?php

namespace App\Models;

use App\Trait\Crud;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory , SoftDeletes , Crud;

    public $table = 'employees';
    protected $fillable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }

    public function users(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function countries(){
        return $this->hasOne(Country::class, 'id', 'country');
    }
    public function nationalties(){
        return $this->hasOne(Nationality::class, 'name', 'nationality');
    }
    public function cities(){
        return $this->hasOne(City::class, 'id', 'city');
    }
    public function states(){
        return $this->hasOne(State::class, 'id', 'state');
    }

    public function departments(){
        return $this->hasOne(Department::class, 'id', 'department');
    }
    public function designations(){
        return $this->hasOne(Designation::class, 'id', 'designation');
    }
    public function qualifications(){
        return $this->hasMany(EmployeeQualification::class , 'employee_id' , 'id');
    }
    public function attendance(){
        return $this->hasMany(Attendance::class ,'employee_id' , 'user_id');
    }
    public function shifts(){
        return $this->hasOne(Shift::class , 'id' , 'shift');
    }
    public function experiences(){
        return $this->hasMany(EmployeeExperience::class , 'employee_id' , 'id');
    }
    public function bank_details(){
        return $this->hasOne(EmployeeBankDetail::class,'employee_id' , 'id');
    }
    public function loans() {
       $currentDay   = Carbon::now()->day;
       $employeeId   = $this->id;
        return $this->hasOne(EmployeeLoan::class, 'employee_id', 'id')
            ->where(function ($query) {
                $query->where('repay_type', 'salary')
                      ->where('status' ,'approved');
            })
            ->orWhere(function ($query) use ($currentDay) {
                $query->where('repay_type', 'monthly')->where('status' ,'approved')
                      ->where('date_of_payment', '<', $currentDay);
            })->where('employee_id' , $employeeId  );
    }
}
