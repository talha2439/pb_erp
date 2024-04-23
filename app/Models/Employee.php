<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = [

            'emp_uniq_id',
            'user_id',
            'image',
            'first_name',
            'last_name',
            'date_of_birth',
            'personal_email',
            'personal_contact',
            'emergency_contact',
            'permanent_contact',
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
            'no_of_child'
    ];
    public function users(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
}
