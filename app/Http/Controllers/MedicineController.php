<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    public function medicine(){
        return view('administrator/medicine/index');
    }
    
    public function medicineList(){
        return response()->json([
            "data"=> Medicine::all()
        ]);
    }
}
