<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class AdminRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            // Cek apakah pengguna memiliki role 'admin'
            if (!Auth::user()->role == 'admin') {
                Auth::logout(); // Logout pengguna jika bukan admin
                return redirect('/admin/login')->with('error', 'Anda tidak memiliki akses ke dashboard ini.');
            }
        }

        return $next($request);
    }
}
