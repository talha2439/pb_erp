<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAccess extends Model
{
    protected $fillable = ['sub_menu_id' , 'user_id' , 'view_status','create_status','update_status','delete_status'];
    use HasFactory;
    public function submenu(){
        return $this->hasMany(SubMenu::class , 'user_id' , 'id');
    }
    public function user(){
        return $this->hasOne(User::class , 'user_id' , 'id');
    }
}
