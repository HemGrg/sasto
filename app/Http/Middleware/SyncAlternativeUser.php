<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Modules\AlternativeUser\Entities\AlternativeUser;

class SyncAlternativeUser
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
        if (is_alternative_login()) {
            session()->put('alt_usr', AlternativeUser::find(alt_usr()->id));
        }
        return $next($request);
    }
}
