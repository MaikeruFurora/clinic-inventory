<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Medicine;
use App\Models\Patient;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdministratorController extends Controller
{
    private $dateNow;

    public function __construct()
    {
        $this->dateNow=Carbon::now();
    }
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
        $countMedicine = Medicine::select(DB::raw('COUNT(id) as total'))->first();
        $countPatient = Patient::select(DB::raw('COUNT(id) as total'))->where(DB::raw('YEAR(created_at)'),date("Y"))->first();
        $countAdmin= User::select(DB::raw('COUNT(user_type) as total'))->where('user_type','Administrator')->first();
        $countNurse= User::select(DB::raw('COUNT(user_type) as total'))->where('user_type','Nurse')->first();
        $expired =  Medicine::whereDate('expiration_date', '>', $this->dateNow->toDateString())->limit(7)->get();
        $RunningOutOfStock=Medicine::where('unit_qty','<',20)->limit(7)->get();
        return view('administrator/dashboard/index',compact('pieGraph','lineGraph','expired','RunningOutOfStock','countAdmin','countNurse','countMedicine','countPatient'));
    }

    public function profile(){
        return view('administrator/profile/profile');
    }


    public function changePassword(Request $request){
        
        return $request->validate([
            'old_password'=>'required',
            'new_password'=>'required',
            'confirm_password'=>'required',
        ]);
        
        auth()->user()->update([
            'password'=>Hash::make($request->password),
        ]);        
    }


    public function text(){
        return view('text');
    }
}
