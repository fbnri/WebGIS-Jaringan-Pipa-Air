<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ForcePasswordController extends Controller
{
    public function index()
    {
        return view(
            'auth.force-password'
        );
    }

    public function update(
        Request $request
    ): RedirectResponse
    {
        $request->validate(
            [
                'password' => 'required|min:8|confirmed'
            ],
            [
                'password.confirmed' => 'Konfirmasi password tidak cocok.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.required' =>'Password wajib diisi.'
            ]
        );

        $user = User::find(session('password_reset_user_id'));

        if (!$user) {
            abort(403);
        }

        $user->password = Hash::make(
            $request->password
        );

        $user->force_password_change = false;
        $user->save();

        // HAPUS SESSION RESET
        session()->forget(
            'password_reset_user_id'
        );

        // LOGIN ULANG USER
        Auth::login($user);

        // REGENERATE SESSION
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $request->session()->regenerate();

        // REDIRECT
        if ($user->role === 'super_admin') {
            return redirect()
            ->route('admin.dashboard')
            ->withHeaders([
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => 'Sat, 01 Jan 1990 00:00:00 GMT',
            ]);
        }

        return redirect()
        ->route('admin.dashboard')
        ->withHeaders([
            'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
            'Pragma' => 'no-cache',
            'Expires' => 'Sat, 01 Jan 1990 00:00:00 GMT',
        ]);
    }
}