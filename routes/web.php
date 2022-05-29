<?php

use App\Helpers\Helper;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\CindicationRoomController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DisablityController;
use App\Http\Controllers\FeildOfStudyController;
use App\Http\Controllers\EducationalLevelController;
use App\Http\Controllers\EventController;

use App\Http\Controllers\FileController;
use App\Http\Controllers\IdGenerateController;
use App\Http\Controllers\ImportExportController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PaymentTypeController;
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
use App\Http\Controllers\TransportTarifController;
use App\Http\Controllers\ZoneController;
use App\Http\Controllers\DistanceController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\PayrollSheetController;
use App\Http\Controllers\VolunteerResourceHistoryController;
use App\Http\Controllers\TrainingCenterBasedPermissionController;
use App\Http\Controllers\TrainingDocumentController;
use App\Http\Controllers\TranslationTextController;
use App\Mail\VerifyMail;
use App\Models\ApprovedApplicant;
use App\Models\PaymentType;
use App\Models\CindicationRoom;
use App\Models\Training;
use App\Models\Distance;
use App\Models\Event;
use App\Models\TrainingMaster;
use App\Models\TrainingMasterPlacement;
use App\Models\TrainingPlacement;
use App\Models\TrainingSchedule;
use App\Models\TrainingSession;
use App\Models\Payroll;
use App\Models\PayrollSheet;
use App\Models\TrainingDocument;
use App\Models\TraininingCenter;
use App\Models\TranslationText;
use App\Models\TransportTarif;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\Woreda;
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
Route::get('importRegion',[RegionController::class,'import']);
Route::get('importZone',[ZoneController::class,'import']);
Route::get('importWoreda',[WoredaController::class,'import']);
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

Route::get('adb', function () {
    // dd('sd');
    $level = 'asdb';
    $introLines = 'adsbi';
    $volunteer = Volunteer::find(33);
    // return /
    // $notification = (new \App\Notifications\VolunteerPlaced($volunteer))->toMail('findabdurhman@gmail.com');
    // $markdown = new \Illuminate\Mail\Markdown(view(), config('mail.markdown'));
    // return $markdown->render($notification->markdown, $notification->data());
});
// Route::get('send',[NotificationController::class,'sendApplicantPlacmentEmail']);
Route::post('application/document/upload', [VolunteerController::class, 'application_document_upload'])->name('document.upload');
//Role & Permission
Route::get('application_form', [VolunteerController::class, 'application_form'])->name('aplication.form');
Route::post('application_form/apply', [VolunteerController::class, 'apply'])->name('aplication.apply');
Route::get('training_session/{training_session}/screenout', [TrainingSessionController::class, 'screen'])->name('aplication.screen_out');

Route::group(['prefix' => '{training_session}', 'middleware' => ['auth', 'verified'], 'as' => 'session.'], function () {
    Route::get('training-center/regional-volunteer-contribution/{id}', [DashboardController::class, 'trainginCenersVolenteerRegionalDistribution'])->name('placed-contribution');
    Route::any('/volunteer/all', [VolunteerController::class, 'volunteerAll'])->name('volunteer.all');
    Route::get('/volunteer/{volunteer}/detail', [VolunteerController::class, 'volunteerDetail'])->name('volunteer.detail');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/quota', [TrainingSessionController::class, 'showQuota'])->name('training_session.quota');
    Route::any('volunteer/', [VolunteerController::class, 'index'])->name('volunteer.index');
    Route::resource('/volunteer', VolunteerController::class, ['names' => 'applicant'])->parameters(['volunteer' => 'applicant'])->except(['index']);
    Route::post('applicant/{volunteer}/screen', [VolunteerController::class, 'Screen'])->name('applicant.screen');
    Route::get('volunteer/unverified/email/download', [PrintController::class, 'unverifiedEmail'])->name('volunteer.unverified.email.download');
    // Route::get('/training',[TrainingSessionController::class,'trainings'])->name('training.index');
    Route::resource('/user_attendances', UserAttendanceController::class);
    Route::resource('/attendance', AttendanceController::class);
    Route::get('volunteer/{volunteer}/attendances', [VolunteerController::class, 'atend     ance'])->name('volunteer.attendance');
    Route::get('import/View/{training_center}', [ImportExportController::class, 'importView'])->name('volunteer.import.view');
    Route::get('bank/test/import/{training_center}', [ImportExportController::class, 'exportVolunteers'])->name('volunteer.export');
    Route::any('bank/test/{training_center}', [ImportExportController::class, 'importVolunteers'])->name('volunteer.import');
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
    Route::get('training_center', [TrainingSessionController::class, 'trainingCenterIndex'])->name('training_center.index');
    Route::get('training_center/{training_center}', [TrainingSessionController::class, 'trainingCenterShow'])->name('training_center.show');
    Route::get('center_base/{training_center}/{cindication_room}/{user}/{permission}/remove', [TrainingCenterBasedPermissionController::class, 'remove'])->name('training_center_based_permission.remove');
    Route::resource('training_center_based_permission', TrainingCenterBasedPermissionController::class);
    Route::post('training_center/{training_center}/assign_checker', [TraininingCenterController::class, 'assignChecker'])->name('training_center.assign_checker');
    Route::post('resource/assign', [TrainingSessionController::class, 'resourceAssignToTrainingCenter'])->name('resource.assign');
    Route::post('resource/update', [TrainingSessionController::class, 'updateResourceAssignToTrainingCenter'])->name('resource.update');
    Route::get('/resources', [TrainingSessionController::class, 'allResource'])->name('resource.all');
    Route::get('/resource/{resource}', [TrainingSessionController::class, 'showResource'])->name('resource.show');
    Route::any('/training-center/{training_center_id}/resource-assign', [TraininingCenterController::class, 'giveResource'])->name('resource.assign.volunteer');
    Route::any('/training-center/{training_center_id}/resource-assign/volunteer/{volunteer}', [TraininingCenterController::class, 'giveResourceDetail'])->name('resource.assign.volunteer.detail');
    Route::get('check-in/', [TraininingCenterController::class, 'checkInView'])->name('TrainingCenter.CheckIn');
    Route::get('result/', [TraininingCenterController::class, 'result'])->name('result');
    Route::get('/check-in/action/{id}', [TraininingCenterController::class, 'checkIn'])->name('TrainingCenter.checked');
    Route::any('/check-in/reports/', [TraininingCenterController::class, 'indexChecking'])->name('TrainingCenter.index.checked');
    Route::get('training_center', [TrainingSessionController::class, 'trainingCenterIndex'])->name('training_center.index');
    Route::get('training_center/{training_center}', [TrainingSessionController::class, 'trainingCenterShow'])->name('training_center.show');
    Route::get('training_center/{training_center}/training/{training}', [TraininingCenterController::class, 'trainingShow'])->name('training_center.training.show');
    Route::post('training_center/{training_center}/place', [TraininingCenterController::class, 'placeVolunteers'])->name('training_center.placement');

    Route::post('{training_center}/id/print', [IdGenerateController::class, 'idGenerate'])->name('training_center.generate');
    Route::get('{training_center}/checkedIn/list', [IdGenerateController::class, 'checkedInList'])->name('training_center.checkedIn_list');
    Route::resource('VolunteerResourceHistory', VolunteerResourceHistoryController::class);
    Route::get('{training_center}/{cindication_room}/{training}/volunteers', [CindicationRoomController::class, 'volunteers'])->name('cinidcation_room.training.volunteers');
    Route::resource('{training_center}/cindication_room', CindicationRoomController::class);
    Route::resource('training_master_placement', TrainingMasterPlacementController::class);
    Route::get('{training_center}/trainer/list', [IdGenerateController::class, 'TrainerList'])->name('training_center.trainer_list');
    Route::get('{training_center}/{cindication_room}/attendance_export', [TraininingCenterController::class, 'get_attendance_data'])->name('attendance.export');
    Route::post('{training_center}/{cindication_room}/attendance_import', [TraininingCenterController::class, 'fileImport'])->name('attendance.import');

    Route::get('{region_id}/region/capacity', [RegionController::class, 'regionIntake'])->name('region.intake');
    Route::post('{region_id}/capacity/store', [RegionController::class, 'regionIntakeStore'])->name('intake.store');

    Route::get('{zone_id}/zone/capacity', [ZoneController::class, 'zoneIntake'])->name('zone.intake');
    Route::post('zone/{zone_id}/capacity/store', [ZoneController::class, 'zoneIntakeStore'])->name('zone.intake_store');

    Route::get('{woreda_id}/woreda/capacity', [WoredaController::class, 'woredaIntake'])->name('woreda.intake');
    Route::post('woreda/{woreda_id}/capacity/store', [WoredaController::class, 'woredaIntakeStore'])->name('woreda.intake_store');
    Route::post('/approve_placment',[TrainingSessionController::class,'approvePlacment'])->name('placment.approve');
});



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
    Route::get('training_sessions', [RegionController::class, 'place'])->name('region.place');
    Route::resource('translation',TranslationTextController::class);
    Route::resource('language',LanguageController::class);

    //Route::get('training_',[RegionController::class,'place'])->name('region.place');
    ///////////////////////////////////////////////////////////////////////////////////
    Route::resource('training_session', TrainingSessionController::class);
    Route::resource('qouta', QoutaController::class);
    Route::resource('user', UserController::class);
    /////////////////////////////////////////////////////////////////
    Route::resource('transportTarif', TransportTarifController::class);
    Route::resource('distance', DistanceController::class);
    Route::resource('paymentType', PaymentTypeController::class);
    Route::resource('payroll', PayrollController::class);
    Route::resource('payrollSheet', PayrollSheetController::class);
    Route::get('generatePDF', [PayrollSheetController::class, 'generatePDF'])->name('payrollSheet.generatePDF');
    Route::get('payee_list', [PayrollSheetController::class, 'payee'])->name('payrollSheet.payee');
    //Route::get('/payroll/{id}/payroll_sheet', [PayrollSheetController::class, 'payrollSheet'])->name('payrollSheet.dispaly');
    ////////////////////////////////////////////////////////////////////
    Route::resource('region', RegionController::class);
    Route::resource('zone', ZoneController::class);
    Route::resource('woreda', WoredaController::class);
    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('resource', ResourceController::class);
    Route::get('role/{role}/permission', [RoleController::class, 'permissions'])->name('role.permission.index');
    Route::post('role/{role}/permission', [RoleController::class, 'givePermission'])->name('role.permission.give');
    Route::delete('role/{role}/permission/{permission}', [RoleController::class, 'revokePermission'])->name('role.permission.revoke');
    Route::post('role/{role}/giveAllPermission', [RoleController::class, 'giveAllPermission'])->name('role.giveAllPermission');
    Route::post('role/{role}/removeAllPermission', [RoleController::class, 'removeAllPermission'])->name('role.removeAllPermission');
    Route::post('users/{user}/role', [UserController::class, 'assignRole'])->name('users.assignRole');
    Route::post('users/{user}/role/remove', [UserController::class, 'removeRole'])->name('users.removeRole');

    Route::get('training-center/remove-checker{checker_id}', [TraininingCenterController::class, 'removeChecker'])->name('TrainingCenter.removeChecker');
    Route::resource('TrainingCenter', TraininingCenterController::class);
    Route::post('{training_center}/search/applicant', [IdGenerateController::class, 'searchApplciant'])->name('search.applicant');
    Route::post('{training_center}/id/count', [IdGenerateController::class, 'idCount'])->name('id.count');
    Route::post('{training}/training/schedule', [TraininingCenterController::class, 'trainingSchedule'])->name('training.attendance');
    Route::post('{training}/training/schedule/remove', [TraininingCenterController::class, 'trainingScheduleRemove'])->name('training.remove');
    Route::resource('training/{training}/training_document', TrainingDocumentController::class);
    Route::get('/dashboard', function () {

        if (count(TrainingSession::availableSession()) > 0) {
            $trainingSession = TrainingSession::availableSession()[0];
            return redirect(route('session.dashboard', ['training_session' => $trainingSession->id]));
        }
        return 'No active training session found!';
    })->name('dashboard');

    Route::post('roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions.give');
    Route::resource('TrainingCenterCapacity', TrainingCenterCapacityController::class);
    Route::post('TrainingCenter/Capacity', [TrainingCenterCapacityController::class, 'capacityChange'])->name('TrainingCenterCapacity.capacityChange');
});
require __DIR__ . '/auth.php';
Route::get('volunteer/verify/{token}', [VolunteerController::class, 'verifyEmail'])->name('volunteer.email.verify');
Route::get('{training_session}/verify-all', [VolunteerController::class, 'verifyAllVolunteers'])->name('verify.all');
Route::get('{training_session}/reset-verification', [VolunteerController::class, 'resetAll'])->name('resetVerify');
// Route::get('id/test', function () {
// ;
//     foreach (TrainingPlacement::all() as $key=>$placement) {
//         $idNumber = 'MOP-' . $placement->trainingCenterCapacity->trainingCenter?->code . '-' . str_pad($key+1, 6, "0", STR_PAD_LEFT) . '/' . TrainingSession::find(1)->id;
//         Volunteer::find($placement->approvedApplicant?->volunteer?->id)->update(['id_number'=>$idNumber]);
//     }
//     dd('stop');
// });
Route::resource('Events', EventController::class);
Route::get('/All-Events' ,[EventController::class,'allEvents'])->name('event.all');
Route::get('/Event/{event}' ,[EventController::class,'detailEvent'])->name('event.detail');
