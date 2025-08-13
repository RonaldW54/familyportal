<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UpdateUserLastSeen
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
{
    if (auth()->check()) {
        // Aktualisiere den Zeitstempel nur, wenn der letzte > 5 Minuten her ist, um DB-Last zu sparen
        $user = auth()->user();
        if ($user->last_seen === null || $user->last_seen->diffInMinutes(now()) > 5) {
            $user->last_seen = now();
            $user->save();
        }
    }
    return $next($request);
}
}
