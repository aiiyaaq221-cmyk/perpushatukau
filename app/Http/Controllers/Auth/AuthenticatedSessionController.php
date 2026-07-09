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

        // Ambil user yang sedang login
        $user = Auth::user();

        // Redirect berdasarkan role
        if ($user->role === 'admin') {
            return redirect()
                ->route('dashboard')
                ->with('login_success', 'Anda berhasil login.');
        }

        if ($user->role === 'user') {
            return redirect()
                ->route('user.index')
                ->with('login_success', 'Anda berhasil login.');
        }

        // Default jika role tidak dikenali
        return redirect()
            ->route('dashboard')
            ->with('success', 'Anda berhasil login.');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/')
                ->with('logout_success', 'Anda telah keluar dari sistem.');
    }
}