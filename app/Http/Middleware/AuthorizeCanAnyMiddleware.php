<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class AuthorizeCanAnyMiddleware
{
    public function handle(Request $request, Closure $next, ...$permissions)
    {
        if (!$request->user()) {
            abort(403);
        }

        if (!$request->user()->hasAnyPermission($permissions)) {
            abort(403);
        }

        return $next($request);
    }
}
