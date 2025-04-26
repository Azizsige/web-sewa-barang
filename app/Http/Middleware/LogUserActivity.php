<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Log activity kalau user login
        if (auth()->check() && $request->routeIs('login')) {
            // Nanti kita log ke tabel activity_logs (setelah tabelnya dibuat)
            // Untuk sekarang, kita skip logika ini
        }

        return $response;
    }
}
