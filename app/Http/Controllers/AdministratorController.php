<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdministratorController extends Controller
{
    public function dashboard(){
         $pieGraph = Expense::select(DB::raw('sum(amount) as total, MONTH(created_at) as month'))
        ->where(DB::raw('YEAR(created_at)'),date("Y"))
        ->groupBy('month')
        ->orderBy('month','ASC')
        ->get();
        $lineGraph = Patient::select(DB::raw('COUNT(created_at) as total, MONTH(created_at) as month'))
        ->where(DB::raw('YEAR(created_at)'),date("Y"))
        ->groupBy('month')
        ->orderBy('month','ASC')
        ->get();
        $latestMedicine = Medicine::latest()->limit(5)->get();
        $latestPatient = Patient::latest()->limit(5)->get();
        $countMedicine = Medicine::select(DB::raw('COUNT(id) as total'))->first();
        $countPatient = Patient::select(DB::raw('COUNT(id) as total'))->first();
        $countAdmin= User::select(DB::raw('COUNT(user_type) as total'))->where('user_type','Administrator')->first();
        $countNurse= User::select(DB::raw('COUNT(user_type) as total'))->where('user_type','Nurse')->first();
        return view('administrator/dashboard/index',compact('pieGraph','latestMedicine','latestPatient','lineGraph','countAdmin','countNurse','countMedicine','countPatient'));
    }
}
