<?php

namespace App\Models;

use App\Trait\Crud;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{


    use HasFactory , Crud;
    public $table = 'sub_menus';
    protected $fillable = [];
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fillable = Crud::columns($this->table);
    }
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
