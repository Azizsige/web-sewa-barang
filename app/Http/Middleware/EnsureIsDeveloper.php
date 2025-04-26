<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureIsDeveloper
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->role === 'developer') {
            return $next($request);
        }
        abort(403, 'Unauthorized');
    }
}
