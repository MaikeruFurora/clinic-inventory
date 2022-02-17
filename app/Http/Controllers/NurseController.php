<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NurseController extends Controller
{
    public function dashboard(){
        return view('nurse/dashboard/index');
    }
}
