<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $userType = Auth::user()->user_type;
                switch ($userType) {
                    case 'administrator':
                            return redirect()->route('administrator.dashboard');
                        break;
                    case 'nurse':
                            return redirect()->route('nurse.dashboard');
                        break;
                    default:
                             return redirect()->route('auth.form'); 
                        break;
                }
            }
        }

        return $next($request);
    }
}
