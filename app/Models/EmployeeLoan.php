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
}
