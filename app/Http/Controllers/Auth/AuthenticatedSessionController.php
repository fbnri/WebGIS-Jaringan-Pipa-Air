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
        $user = \App\Models\User::where(
            'email',
            $request->email
        )->first();

        $request->authenticate();
        $request->session()->regenerate();
        $user = auth()->user();

        // FORCE PASSWORD
        if ($user && $user->force_password_change) {
            session([
                'password_reset_user_id' => $user->id
            ]);

            return redirect()->route(
                'password.force.change'
            );
        }

        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak terdaftar atau password salah.'
            ]);
        }

        // REDIRECT ROLE
        if ($user->role === 'super_admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
