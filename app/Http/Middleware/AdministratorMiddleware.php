<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdministratorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        $userType = User::select('user_type')->whereId(Auth::user()->id)->where('status','activate')->pluck('user_type')->first();

        switch ($userType) {
            case 'administrator':
                  return $next($request);
                break;
            case 'nurse':
                  return redirect()->route('nurse.dashboard');
                break;
            default:
                if (Auth::guard('web')->check()) {
                    Auth::guard('web')->logout();
                }
                 return redirect()->route('auth.form')->with('msg','You are not allowed to access this system');
                break;
        }
    }
}
