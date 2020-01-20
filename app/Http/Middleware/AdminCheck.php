<?php

namespace App\Http\Middleware;

use App\Models\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminCheck
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
        if (!Auth::check()) {
            return redirect()->route('admin.login.get');
        } else if (Auth::user()->role_id != Role::ADMIN && Auth::user()->role_id != Role::SUPER_ADMIN) {
            abort(403, trans('custome.unauthorized_action'));
        }

        return $next($request);
    }
}
