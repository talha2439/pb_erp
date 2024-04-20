<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuAccessManagment extends Model
{
    use HasFactory;
    protected $fillable = ['sub_menu_id' , 'has_all' , 'view_status','create_status','update_status','delete_status'];

    public function submenu(){
        return $this->hasOne(SubMenu::class , 'id' , 'sub_menu_id');
    }
}
