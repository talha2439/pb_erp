<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanInstallment extends Model
{
    use HasFactory , Crud;
    public $table = 'loan_installments';
    protected $fillable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function loans(){
       return  $this->hasOne(EmployeeLoan::class ,'id' , 'loan_id');
    }
    public function employees(){
       return  $this->hasOne(EmployeeLoan::class ,'id' , 'loan_id');
    }
}
