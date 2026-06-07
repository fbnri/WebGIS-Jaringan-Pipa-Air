<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserManagementController extends Controller
{
    public function index() {
        $admins = User::where('role','admin')->get();

        return view(
            'super-admin.users',
            compact('admins')
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);

        $tempPassword = '@dmin123';

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($tempPassword),
            'role' => 'admin',
            'is_active' => true,
            'force_password_change' => true,
        ]);

        return back()->with(
            'success',
            'Admin berhasil ditambahkan. Password sementara: '.$tempPassword
        );
    }

    public function toggle(User $user) {
        $user->is_active=!$user->is_active;
        $user->save();

        return back();
    }

    public function resetPassword(User $user)
    {
        $tempPassword = '@dmin123';
        $user->password = bcrypt($tempPassword);
        $user->force_password_change = true;
        $user->save();

        return back()->with(
            'success',
            'Password '.$user->name.
            ' berhasil direset. Password sementara: '.$tempPassword
        );
    }

    public function update(
        Request $request,
        User $user
    ){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$user->id,
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return back()->with(
            'success',
            'Admin berhasil diperbarui'
        );
    }

    public function destroy(User $user)
    {
        $user->delete();

        return back()->with(
            'success',
            'Admin berhasil dihapus'
        );
    }
}
