<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roleIds): Response
    {
        if (!auth()->check() || !in_array(auth()->user()->role_id, $roleIds)) {
            return abort(403, 'Access denied');
        }

        return $next($request);
    }
}
