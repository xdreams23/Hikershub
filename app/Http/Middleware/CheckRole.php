<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Cek apakah user sudah login
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Cek apakah role user sesuai
        if (auth()->user()->role !== $role) {
            // Jika admin mencoba akses user area
            if (auth()->user()->role === 'admin') {
                return redirect()->route('admin.dashboard')
                    ->with('error', 'You do not have permission to access this page.');
            }
            
            // Jika user mencoba akses admin area
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access this page.');
        }

        return $next($request);
    }
}