<?php

use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisablityController;
use App\Http\Controllers\FeildOfStudyController;
use App\Http\Controllers\EducationalLevelController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PrintController;
use App\Http\Controllers\QoutaController;
use App\Http\Controllers\QuotaController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\ResourceController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TraininingCenterController;
use App\Http\Controllers\TotalQuotaController;
use App\Http\Controllers\TrainingCenterCapacityController;
use App\Http\Controllers\TrainingController;
use App\Http\Controllers\TrainingMasterController;
use App\Http\Controllers\TrainingMasterPlacementController;
use App\Http\Controllers\TrainingPlacementController;
use App\Http\Controllers\TrainingScheduleController;
use App\Http\Controllers\TrainingSessionController;
use App\Http\Controllers\UserAttendanceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\WoredaController;
use App\Http\Controllers\ZoneController;
use App\Mail\VerifyMail;
use App\Models\ApprovedApplicant;
use App\Models\Training;
use App\Models\TrainingMaster;
use App\Models\TrainingMasterPlacement;
use App\Models\TrainingPlacement;
use App\Models\TrainingSchedule;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\View;
use Symfony\Component\Console\Input\Input;

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
Route::get('training-center/regional-volunteer-contribution/{id}', [DashboardController::class, 'trainginCenersVolenteerRegionalDistribution'])->name('placed-contribution');

//Role & Permission
Route::get('application_form', [VolunteerController::class, 'application_form'])->name('aplication.form');
Route::post('application_form/apply', [VolunteerController::class, 'apply'])->name('aplication.apply');
Route::get('training_session/{training_session}/screenout', [TrainingSessionController::class, 'screen'])->name('aplication.screen_out');

Route::group(['prefix' => '{training_session}', 'middleware' => ['auth', 'verified'], 'as' => 'session.'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/quota', [TrainingSessionController::class, 'showQuota'])->name('training_session.quota');
    Route::any('volunteer/', [VolunteerController::class, 'index'])->name('volunteer.index');
    Route::resource('/volunteer', VolunteerController::class, ['names' => 'applicant'])->parameters(['volunteer' => 'applicant'])->except(['index']);
    Route::post('applicant/{volunteer}/screen', [VolunteerController::class, 'Screen'])->name('applicant.screen');
    Route::get('volunteer/unverified/email/download', [PrintController::class, 'unverifiedEmail'])->name('volunteer.unverified.email.download');
    // Route::get('/training',[TrainingSessionController::class,'trainings'])->name('training.index');
    Route::resource('/user_attendances', UserAttendanceController::class);
    Route::resource('/attendance', AttendanceController::class);
    Route::get('volunteer/{volunteer}/attendances', [VolunteerController::class, 'atendance'])->name('volunteer.attendance');




    Route::post('applicant/place', [TrainingPlacementController::class, 'place'])->name('applicant.place');
    Route::get('applicants/email/unverified', [VolunteerController::class, 'emailUnverified'])->name('applicant.email.unVerified');
    Route::get('/reset-screen', [TrainingSessionController::class, 'resetScreen'])->name('aplication.resetScreen');
    Route::get('applicants/document-verified', [VolunteerController::class, 'verifiedApplicant'])->name('applicant.verified');
    Route::get('applicants/selected', [VolunteerController::class, 'selected'])->name('applicant.selected');
    Route::get('placement', [TrainingPlacementController::class, 'index'])->name('placement.index');
    Route::get('placement/reset', [TrainingPlacementController::class, 'resetPlacement'])->name('placement.reset');
    Route::post('{approvedApplicant}/manual-placement', [TrainingPlacementController::class, 'placeManually'])->name('placement.manual');
    Route::post('{training_placement}/change', [TrainingPlacementController::class, 'changePlacement'])->name('placement.change');
    Route::post('{approvedApplicant}/manual-screen', [TrainingSessionController::class, 'screenManually'])->name('screen.manual');

    Route::get('/schedules', [ScheduleController::class, 'index'])->name('schedule');
    Route::post('/schedules', [TrainingSessionController::class, 'setSchedule'])->name('schedule.set');
    Route::post('/addSchedule', [ScheduleController::class, 'addSchedule'])->name('schedule.add');
    Route::delete('/training_schedule/{training_schedule}', [TrainingScheduleController::class, 'destroy'])->name('trainingschedule.destroy');
    Route::resource('training_master_placement', TrainingMasterPlacementController::class);
    Route::get('training_center',[TrainingSessionController::class,'trainingCenterIndex'])->name('training_center.index');
    Route::get('training_center/{training_center}',[TrainingSessionController::class,'trainingCenterShow'])->name('training_center.show');
});

Route::get('check-in/', [TraininingCenterController::class, 'checkInView'])->name('TrainingCenter.CheckIn');
Route::get('result/', [TraininingCenterController::class, 'result'])->name('result');
Route::get('/check-in/action/{id}', [TraininingCenterController::class, 'checkIn'])->name('TrainingCenter.checked');
Route::any('/check-in/reports/', [TraininingCenterController::class, 'indexChecking'])->name('TrainingCenter.index.checked');
// Route::get('result/', [VolunteerController::class, 'result'])->name('result');
Route::middleware(['auth', 'verified'])->group(function () {
    // Route::get('training_session/{training_session}/quota', [QoutaController::class, 'index'])->name('quota.index');
    // Route::middleware(['guest'])->group(function () {
    Route::resource('training_master', TrainingMasterController::class);
    Route::resource('training', TrainingController::class);
    Route::get('/profile/edit', [UserController::class, 'profile_edit'])->name('profile.edit');
    Route::post('/profile/update', [UserController::class, 'profile_update'])->name('profile.update');
    Route::get('/profile/{user?}', [UserController::class, 'profile'])->name('profile.show');
    Route::get('user/{user}/credential', [UserController::class, 'downloadCredential'])->name('user.print.credential');
    Route::post('region/validate', [RegionController::class, 'validateForm'])->name('validate.region');
    Route::post('zone/validate', [ZoneController::class, 'validateForm'])->name('validate.zone');
    Route::post('woreda/validate', [WoredaController::class, 'validateForm'])->name('validate.woreda');
    Route::post('applicant/infromation', [TrainingSessionController::class, 'applicantInfo'])->name('applicant.info');

    Route::post('user/{user}/giveAllPermission', [UserController::class, 'giveAllPermission'])->name('user.giveAllPermission');
    Route::post('user/{user}/removeAllPermission', [UserController::class, 'removeAllPermission'])->name('user.removeAllPermission');
    Route::get('user/{user}/permission', [UserController::class, 'userPermissions'])->name('user.permission.index');
    Route::post('user/{user}/permission/give', [UserController::class, 'givePermission'])->name('user.permission.give');
    Route::post('user/{user}/permission/revoke', [UserController::class, 'revokePermission'])->name('user.permission.revoke');
    Route::resource('educational_level', EducationalLevelController::class);
    Route::resource('feild_of_study', FeildOfStudyController::class);
    Route::resource('disablity', DisablityController::class);
    Route::get('/profile/{user?}', [UserController::class, 'profile'])->name('user.profile.show');
    ////////////////////////////////////////////////////////////////////////////////
    Route::get('training_sessions', [RegionController::class, 'place'])->name('region.place');

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
    Route::resource('resource', ResourceController::class);
    Route::post('resource/assign', [ResourceController::class, 'assign'])->name('resource.assign');
    Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permission.index');
    Route::post('role/{role}/permission', [RoleController::class, 'givePermission'])->name('role.permission.give');
    Route::delete('role/{role}/permission/{permission}', [RoleController::class, 'revokePermission'])->name('role.permission.revoke');
    Route::post('role/{role}/giveAllPermission', [RoleController::class, 'giveAllPermission'])->name('role.giveAllPermission');
    Route::post('role/{role}/removeAllPermission', [RoleController::class, 'removeAllPermission'])->name('role.removeAllPermission');
    Route::post('users/{user}/role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/role/remove', [UserController::class, 'removeRole'])->name('users.removeRole');
    Route::post('training-center/assign-checker', [TraininingCenterController::class, 'assignChecker'])->name('TrainingCenter.assignChecker');
    Route::get('training-center/remove-checker{checker_id}', [TraininingCenterController::class, 'removeChecker'])->name('TrainingCenter.removeChecker');
    Route::resource('TrainingCenter', TraininingCenterController::class);

    Route::get('/dashboard', function () {
        if (count(TrainingSession::availableSession()) > 0) {
            $trainingSession = TrainingSession::availableSession()[0];
            return redirect(route('session.dashboard', ['training_session' => $trainingSession->id]));
        }
    })->name('dashboard');

    Route::post('roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions.give');
    Route::resource('TrainingCenterCapacity', TrainingCenterCapacityController::class);
    Route::post('TrainingCenter/Capacity', [TrainingCenterCapacityController::class, 'capacityChange'])->name('TrainingCenterCapacity.capacityChange');
});
require __DIR__ . '/auth.php';
Route::get('volunteer/verify/{token}', [VolunteerController::class, 'verifyEmail'])->name('volunteer.email.verify');
