<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LimitFreePlan
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next)
  {
    // Kolom plan dihapus, jadi kita skip limit untuk sementara
    return $next($request);
  }
}
