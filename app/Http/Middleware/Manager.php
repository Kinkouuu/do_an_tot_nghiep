<?php

namespace App\Http\Middleware;

use App\Enums\RoleAccount;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Manager
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
        if (
            Auth::guard('admins')->user()->role == RoleAccount::Manager
            ||
            Auth::guard('admins')->user()->role == RoleAccount::Admin
        ) {
            return $next($request);
        } else {
            abort(403, 'Unauthorized');
        }
    }
}
