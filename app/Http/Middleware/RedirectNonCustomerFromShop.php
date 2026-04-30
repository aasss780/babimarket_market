<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectNonCustomerFromShop
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user()) {
            return $next($request);
        }

        if ($request->user()->role === 'seller') {
            return redirect()->route('seller.dashboard')->with('success', 'Seller account redirected to dashboard.');
        }

        if ($request->user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('success', 'Admin account redirected to dashboard.');
        }

        return $next($request);
    }
}
