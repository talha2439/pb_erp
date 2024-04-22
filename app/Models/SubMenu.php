<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{

    protected $fillable  = ['name', 'route' , 'menu_id'];
    use HasFactory;
    public function menu(){
        return $this->hasOne(Menu::class , 'id' , 'menu_id');
    }
    public function access(){
        return $this->hasOne(UserAccess::class , 'sub_menu_id' , 'id');
    }
    public function menu_access(){
        return $this->hasOne(MenuAccessManagment::class , 'sub_menu_id' , 'id');
    }
}
