<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shift extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = ['name' , 'days' , 'start_time', 'end_time' , 'department'];
    public function departments(){
        return $this->hasOne(Department::class , 'id' , 'department');
    }
}
