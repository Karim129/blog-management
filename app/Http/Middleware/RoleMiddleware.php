<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.

     *

     * @param  string|null  $role
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $role = null)
    {

        if (! $request->user() || ! $request->user()->hasRole($role)) {

            // Abort if the user does not have the required role

            abort(403);
        }

        return $next($request);
    }
}
