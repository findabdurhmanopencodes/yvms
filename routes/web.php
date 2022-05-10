<?php

use App\Http\Controllers\DisablityController;
use App\Http\Controllers\FeildOfStudyController;
use App\Http\Controllers\EducationalLevelController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\QoutaController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TraininingCenterController;
use App\Http\Controllers\TotalQuotaController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\WoredaController;
use App\Http\Controllers\ZoneController;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Volunteer;
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

// Route::get('/profile/{user?}',[UserController::class,'profile'])->name('profile.show');


Route::get('/login', function () {
    return view('auth.login');
})->name('login');


Route::get('/', function () {
    return view('menu.home');
})->name('home');

Route::get('/aboutus', function () {
    return view('menu.aboutus');
})->name('aboutus');

Route::get('/contactus', function () {
    return view('menu.contactus');
})->name('contactus');

Route::get('/vission_and_mission', function () {
    return view('menu.vission-and-mission');
})->name('vission_and_mission');

Route::get('/terms', function () {
    return view('menu.terms');
})->name('terms');

Route::get('/placement', function () {
    return view('placement.index');
})->name('placement');


Route::post('application/document/upload', [VolunteerController::class, 'application_document_upload'])->name('document.upload');

//Role & Permission
Route::get('application_form', [VolunteerController::class, 'application_form'])->name('aplication.form');
Route::post('application_form/apply', [VolunteerController::class, 'apply'])->name('aplication.apply');
Route::get('training_session/{training_session}/screenout', [TrainingSessionController::class, 'screen'])->name('aplication.screen_out');
Route::middleware(['auth','verified'])->group(function () {
    Route::get('training_session/{training_session}/qouta',[TrainingSessionController::class,'showQuota'])->name('training_session.quota');
    // Route::get('training_session/{training_session}/quota', [QoutaController::class, 'index'])->name('quota.index');
// Route::middleware(['guest'])->group(function () {

    Route::post('user/{user}/giveAllPermission', [UserController::class, 'giveAllPermission'])->name('user.giveAllPermission');
    Route::post('user/{user}/removeAllPermission', [UserController::class, 'removeAllPermission'])->name('user.removeAllPermission');
    Route::get('user/{user}/permission',[UserController::class,'userPermissions'])->name('user.permission.index');
    Route::post('user/{user}/permission/give', [UserController::class, 'givePermission'])->name('user.permission.give');
    Route::post('user/{user}/permission/revoke', [UserController::class, 'revokePermission'])->name('user.permission.revoke');
    Route::resource('educational_level', EducationalLevelController::class);
    Route::resource('feild_of_study', FeildOfStudyController::class);
    Route::resource('disablity', DisablityController::class);
    Route::get('/profile/{user?}', [UserController::class, 'profile'])->name('user.profile.show');
    Route::any('/Volunter-session/{session_id}', [VolunteerController::class, 'index'])->name('applicant.index');
    Route::resource('applicant', VolunteerController::class)->except(['index']);

    ////////////////////////////////////////////////////////////////////////////////
    Route::get('training_sessions',[RegionController::class,'place'])->name('region.place');

    Route::get('training_center',[TraininingCenterController::class,'placement'])->name('training_center.placement'); 
    //Route::get('training_',[RegionController::class,'place'])->name('region.place');
    ///////////////////////////////////////////////////////////////////////////////////
    Route::resource('training_session', TrainingSessionController::class);
    Route::resource('qouta', QoutaController::class);
    Route::resource('user', UserController::class);
    Route::resource('region', RegionController::class);
    Route::resource('zone', ZoneController::class);
    Route::resource('woreda', WoredaController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permission.index');
    Route::post('role/{role}/permission', [RoleController::class, 'givePermission'])->name('role.permission.give');
    Route::delete('role/{role}/permission/{permission}', [RoleController::class, 'revokePermission'])->name('role.permission.revoke');
    Route::post('role/{role}/giveAllPermission', [RoleController::class, 'giveAllPermission'])->name('role.giveAllPermission');
    Route::post('role/{role}/removeAllPermission', [RoleController::class, 'removeAllPermission'])->name('role.removeAllPermission');
    Route::post('users/{user}/role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/role/remove', [UserController::class, 'removeRole'])->name('users.removeRole');
    Route::resource('TrainingCenter', TraininingCenterController::class);
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::post('roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions.give');
    Route::post('applicant/{applicant_id}/screen', [VolunteerController::class, 'screen'])->name('applicant.screen');
    Route::get('applicants/{session}/decide', [VolunteerController::class, 'decide'])->name('applicant.decide');
});
require __DIR__ . '/auth.php';
