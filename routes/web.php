<?php

use App\Http\Controllers\SettingsController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PipeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SuperAdmin\UserManagementController;
use App\Http\Controllers\ForcePasswordController;

// PUBLIC
Route::get('/', [PipeController::class, 'publicMap'])->name('home');
Route::get('/pipes', [PipeController::class, 'publicPipes'])->name('user.pipes');

// AUTH USER
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ADMIN (ADMIN + SUPER ADMIN)
Route::middleware([
    'auth', 
    'active', 
    'force.password', 
    'nocache', 
    'role:admin,super_admin'
])
->prefix('admin')
->name('admin.')
->group(function () {
    Route::get('/dashboard', [PipeController::class, 'adminMap'])->name('dashboard');
    Route::resource('/pipes', PipeController::class);
});

// SUPER ADMIN ONLY
Route::middleware([
    'auth', 
    'active', 
    'force.password', 
    'nocache', 
    'role:super_admin'
])
->prefix('super-admin')
->name('super.')
->group(function(){
    Route::get('/users', [\App\Http\Controllers\SuperAdmin\UserManagementController::class,'index'])->name('users');
    Route::post('/users', [UserManagementController::class,'store'])->name('users.store');
    Route::put('/users/{user}/toggle', [\App\Http\Controllers\SuperAdmin\UserManagementController::class,'toggle'])->name('users.toggle');
    Route::put('/users/{user}/reset-password', [\App\Http\Controllers\SuperAdmin\UserManagementController::class,'resetPassword'])->name('users.reset');
    Route::put('/users/{user}', [\App\Http\Controllers\SuperAdmin\UserManagementController::class,'update'])->name('users.update');
    Route::delete('/users/{user}', [\App\Http\Controllers\SuperAdmin\UserManagementController::class,'destroy'])->name('users.destroy');
});

// SETTINGS ACCOUNT
Route::middleware([
    'auth', 
    'active',
    'force.password', 
    'nocache'
])
->group(function () {
    Route::get(
        '/settings',
        [SettingsController::class,'index']
    )->name('settings.index');

    Route::put(
        '/settings/profile',
        [SettingsController::class,'updateProfile']
    )->name('settings.profile');

    Route::put(
        '/settings/password',
        [SettingsController::class,'updatePassword']
    )->name('settings.password');
});

// FORCE CHANGE PASSWORD
Route::middleware([
    'auth', 
    'nocache'
])->group(function () {
    Route::get(
        '/force-change-password',
        [ForcePasswordController::class,'index']
    )->name('password.force.change');

    Route::post(
        '/force-change-password',
        [ForcePasswordController::class,'update']
    )->name('password.force.update');
});

require __DIR__.'/auth.php';