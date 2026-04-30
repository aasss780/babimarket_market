<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsNotBlocked
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->status === 'blocked') {
            auth()->logout();
            return redirect()->route('login')->withErrors([
                'email' => 'Your account has been blocked.',
            ]);
        }

        return $next($request);
    }
}
