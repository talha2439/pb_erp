<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeQualification extends Model
{
    use HasFactory , SoftDeletes , Crud;

    public $table = 'employee_qualifications';
    protected $fillable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }

    public function employees(){
        return $this->hasOne(Employee::class , 'id' , 'employee_id');
    }
}
