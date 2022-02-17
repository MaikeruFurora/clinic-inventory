<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function patient(){
        return view('administrator/patient/index');
    }

    public function patientList(){
        return response()->json([
            "data"=>Patient::all()
        ]);
    }
}
