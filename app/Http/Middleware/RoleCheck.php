<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles){
        //dd( Auth::user()->tagroup_id);
        foreach ($roles as $role) {
            if (Auth::check() && Auth::user()->tagroup_id == $role) {
                return $next($request);
            }
        }
        Auth::logout();
        return redirect()->route('login')->with('status','You are not authorized to access this page.');
    }
}
