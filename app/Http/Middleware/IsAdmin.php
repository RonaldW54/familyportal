<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    if (auth()->check() && auth()->user()->isAdmin) {
        return $next($request); // ... darf er passieren.
    }

    // Andernfalls wird er zum normalen Dashboard zurückgeschickt.
    return redirect('/dashboard');
    }
}
