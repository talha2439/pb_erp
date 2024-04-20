<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Dashboardcontroller extends Controller
{
    public $parentView = 'Admin.';
    public function index(){
        return view($this->parentView.'dashboard');
    }
}
