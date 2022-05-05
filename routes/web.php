<?php

use App\Http\Controllers\FeildOfStudyController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WoredaController;
use App\Http\Controllers\ZoneController;
use App\Models\TrainingSession;
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
    return view('welcome'); // make this login
});

//Role & Permission

Route::middleware(['auth'])->group(function () {
    Route::resource('training_session',TrainingSessionController::class);
    Route::resource('user',UserController::class);
    Route::resource('region',RegionController::class);
    Route::resource('zone',ZoneController::class);
    Route::resource('woreda',WoredaController::class);
    Route::resource('role',RoleController::class);
    Route::resource('permission',PermissionController::class);
    Route::view('/dashboard','dashboard')->name('dashboard');
    Route::post('roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions.give');
    Route::resource('region', RegionController::class);
    Route::resource('zone', ZoneController::class);
    Route::resource('woreda', WoredaController::class);

    Route::resource('educational_level',EducationalLevelController::class);
    Route::resource('feild_of_study', FeildOfStudyController::class);
    Route::resource('disablity', DisablityController::class);
});
require __DIR__.'/auth.php';
