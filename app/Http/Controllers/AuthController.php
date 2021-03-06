<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function login(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if (Auth::guard('web')->attempt($request->except(['_token','_method']))) {
            
            $userType = User::select('user_type')->whereId(Auth::user()->id)->where('status','activate')->pluck('user_type')->first();
            
            if ($userType) {
                return redirect()->route('authuser.dashboard');
            } else {
                if (Auth::guard('web')->check()) {
                    Auth::guard('web')->logout();
                }
                 return redirect()->route('auth.form')->with('msg','You are not allowed to access this system');
            }
         
            
        }else{
            return back()->with('msg', 'Login credentials are invalid');
        }
    }

    public function logout()
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('auth.form');
        }
    }
}
