<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    use HasFactory , Crud;
    public $table = 'user_accesses';

    protected $fillable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
    public function submenu(){
        return $this->hasMany(SubMenu::class , 'user_id' , 'id');
    }
    public function user(){
        return $this->hasOne(User::class , 'user_id' , 'id');
    }
}
