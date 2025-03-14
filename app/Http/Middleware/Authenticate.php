<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\App;

class Authenticate {
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure  $next
   * @return mixed
   */
  public function handle(Request $request, Closure $next): Response {
    if (isset($_COOKIE['accessToken']) && $request->session()->has('user')) {
      return $next($request);
    }
    return redirect()->route('pageLogin');
  }
}
