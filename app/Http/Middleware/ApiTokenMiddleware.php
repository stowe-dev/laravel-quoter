<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ApiTokenMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');

        if (! $token || $token !== config('services.api.token')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
