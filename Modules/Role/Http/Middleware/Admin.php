<?php

namespace Modules\Role\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        // dd(Auth::user()->roles()->get());
        $roles = [];

        foreach (Auth::user()->roles()->get() as $role) {
            array_push($roles, $role->slug);
        }
        if (in_array('super_admin', $roles, TRUE) || in_array('admin', $roles, TRUE)) {
            return redirect()->route('dashboard');
            // return $next($request);

        } else {
            return redirect()->route('home');
        }
    }
}
