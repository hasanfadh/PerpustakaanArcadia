<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PeminjamMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::guard('peminjam')->check()) {
            return redirect()->route('peminjam.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}