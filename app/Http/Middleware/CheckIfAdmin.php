<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIfAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $userType = Auth::user()->userType->typeName;
        if( $userType == 'ADMIN' || $userType == 'SUPERVISOR' || $userType == 'HR' || $userType == 'MANAGER' ) {
            return $next($request);
        }
        return redirect()->back()->with('error', 'Not Permitted!');
    }
}
