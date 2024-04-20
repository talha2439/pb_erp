<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable  = ['name', 'icon' , 'route' , 'has_sub'];
    use HasFactory;
    public function submenu(){
        return $this->hasMany(SubMenu::class , 'menu_id' , 'id');
    }
}
