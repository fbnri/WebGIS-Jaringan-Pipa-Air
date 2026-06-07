<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'  => 'required|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id()
        ]);

        /** @var User $user */
        $user = Auth::user();

        $user->name  = $request->name;
        $user->email = $request->email;
        $user->save();

        return back()->with(
            'success',
            'Profil berhasil diperbarui.'
        );
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed'
        ], [
            'current_password.required' => 'Password lama wajib diisi.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.'
        ]);

        /** @var User $user */
        $user = Auth::user();

        if (
            !Hash::check(
                $request->current_password,
                $user->password
            )
        ) {
            return back()->withErrors([
                'current_password' => 'Password lama salah.'
            ]);
        }

        if (
            Hash::check(
                $request->password,
                $user->password
            )
        ) {
            return back()->withErrors([
                'password' => 'Password baru tidak boleh sama dengan password lama.'
            ]);
        }

        $user->password = Hash::make(
            $request->password
        );

        $user->save();

        return back()->with(
            'success',
            'Password berhasil diubah.'
        );
    }
}