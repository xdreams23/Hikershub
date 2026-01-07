<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
   public function store(LoginRequest $request): RedirectResponse
{
    $request->authenticate();

    $request->session()->regenerate();

    // Role-based redirect
    $user = auth()->user();
    
    if ($user->role === 'admin') {
        return redirect()->intended(route('admin.dashboard'));
    }

    return redirect()->intended(route('home'));
}
    /**
     * Destroy an authenticated session.
     */
   public function destroy(Request $request): RedirectResponse
{
    $role = auth()->user()->role;

    Auth::guard('web')->logout();

    $request->session()->invalidate();

    $request->session()->regenerateToken();

    // Role-based redirect after logout
    if ($role === 'admin') {
        return redirect()->route('login');
    }

    return redirect('/');
}
}
