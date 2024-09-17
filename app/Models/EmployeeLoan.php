<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeeLoan extends Model
{
    use HasFactory  , Crud;
    public $table = 'employee_loans';
    protected $fillable = [];
    public function __construct(array $attributes = []){
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function employees(){
        return $this->belongsTo(Employee::class , 'employee_id');
    }
    public function loan_types(){
        return $this->belongsTo(LoanType::class , 'loan_type_id');
    }
    public function approved(){
        return $this->belongsTo(User::class , 'approved_by');
    }
    public function rejected(){
        return $this->belongsTo(User::class , 'rejected_by');

    }
}
