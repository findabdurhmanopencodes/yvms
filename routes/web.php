<?php

use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/profile/{user?}',[UserController::class,'profile'])->name('profile.show');

Route::get('/', function () {
    return view('welcome');
});

//Role & Permission

Route::middleware(['auth'])->group(function () {
    Route::resource('role',RoleController::class);
    Route::resource('permission',PermissionController::class);
    Route::view('/dashboard','dashboard')->name('dashboard');
    Route::post('roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions.give');
});
require __DIR__.'/auth.php';
