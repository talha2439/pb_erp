<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;
use App\Trait\Crud;
class LeaveApplication extends Model
{
    use HasFactory , Crud;
    public $table = 'leave_applications';
    protected $fillable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }

    public function employees(){
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }
    public function approved(){
        return $this->hasOne(User::class, 'id', 'approved_by');
    }
    public function applied(){
        return $this->hasOne(User::class, 'id', 'applied_by');
    }
}
