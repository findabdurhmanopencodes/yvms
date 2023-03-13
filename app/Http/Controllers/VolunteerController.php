<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Constants;
use App\Exports\ApplicantExport;
use App\Models\Volunteer;
use App\Http\Requests\StoreVolunteerRequest;
use App\Http\Requests\UpdateVolunteerRequest;
use App\Imports\ApplicantImport;
use App\Jobs\SendEmailJob;
use App\Mail\VerifyMail;
use App\Mail\VolunteerAppliedMail;
use App\Models\ApprovedApplicant;
use App\Models\Disablity;
use App\Models\EducationalLevel;
use App\Models\FeildOfStudy;
use App\Models\File;
use App\Models\Qouta;
use App\Models\Region;
use App\Models\RegionIntake;
use App\Models\Status;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingDocument;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\TranslationText;
use App\Models\User;
use App\Models\UserRegion;
use App\Models\VerifyVolunteer;
use App\Models\Woreda;
use App\Models\Zone;
use Carbon\Carbon;
use DateTime;
use Faker\Factory;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class VolunteerController extends Controller
{

    public function __construct()
    {
        // $this->authorizeResource(Volunteer::class, 'applicant');
    }
    protected function resourceAbilityMap()
    {
        return [
            'index' => 'viewAny',
            'show' => 'view',
            'create' => 'create',
            'store' => 'create',
            'edit' => 'update',
            'update' => 'update',
            'destroy' => 'delete',
            // 'Screen' => 'screen',
        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $session_id)
    {
        // dd(Auth::user()->hasRole('regional-coordinator'));

        // foreach(Volunteer::all() as $applicant){
        //     Status::create(['acceptance_status'=>1,'volunteer_id'=>$applicant->id]);
        // }
        // // dd('a');
        $user = Auth::user();
        if(!$user->can('Volunteer.index')){
            return abort(403);

        }
        $applicants = Volunteer::whereRelation('status', 'acceptance_status', 0)->where('training_session_id', $session_id);
        if ($user->hasRole('regional-coordinator')) {
            $region = UserRegion::where('user_id', $user->id)->where('levelable_type', Region::class)->first();
          //  dd($region->levelable);
            $applicants = $applicants->whereRelation('woreda.zone.region', 'id', $region->levelable_id);
        }
        if ($user->hasRole('zone-coordinator')) {
            $zone = UserRegion::where('user_id', $user->id)->where('levelable_type', Zone::class)->first();
            $applicants = $applicants->whereRelation('woreda.zone', 'id', $zone->levelable_id);
        }


        if ($request->has('filter')) {
            $first_name = $request->get('first_name');
            $father_name = $request->get('father_name');
            $grand_father_name = $request->get('grand_father_name');
            $email = $request->get('email');
            $gender = $request->get('gender');
            $disablity_id = $request->get('disablity_id');
            $region_id = $request->get('region_id');
            $zone_id = $request->get('zone_id');
            $phone = $request->get('phone');
            $woreda_id = $request->get('woreda_id');
            $gpa = $request->get('gpa');
            $id_number =  $request->get('id_number');
            if (!empty($id_number)) {
                $applicants = $applicants->where('id_number', $id_number);
            }
            if (!empty($first_name)) {
                $applicants = $applicants->where('first_name', 'like', '%' . $first_name . '%');
            }
            if (!empty($father_name)) {
                $applicants = $applicants->where('father_name', 'like', '%' . $father_name . '%');
            }
            if (!empty($grand_father_name)) {
                $applicants = $applicants->where('grand_father_name', 'like', '%' . $grand_father_name . '%');
            }
            if (!empty($email)) {
                $applicants = $applicants->where('email', 'like', '%' . $email . '%');
            }
            if (!empty($gender)) {
                $applicants = $applicants->where('gender', '=', $gender);
            }
            if (!empty($disablity_id)) {
                $applicants = $applicants->where('disablity_id', '=', $disablity_id);
            }
            if (!empty($region_id)) {
                $applicants = $applicants->whereRelation('woreda.zone.region', 'id', $region_id);
            }
            if (!empty($zone_id)) {
                $applicants = $applicants->whereRelation('woreda.zone', 'id', $zone_id);
            }
            if (!empty($phone)) {
                $applicants = $applicants->where('phone', 'like', '%' . $phone . '%');
            }
            if (!empty($woreda_id)) {
                $applicants = $applicants->where('woreda_id', '=', $woreda_id);
            }
            if (!empty($gpa)) {
                $applicants = $applicants->where('gpa', '=', $gpa);
            }
            if (!empty($graduation_date)) {
                $applicants = $applicants->where('graduation_date', '=', $graduation_date);
            }
        }

        return view('volunter.index', ['volunters' => $applicants->paginate(10), 'trainingSession' => TrainingSession::find($session_id), 'regions' => Region::all(), 'woredas' => Woreda::all(), 'zones' => Zone::all(), 'disabilities' => Disablity::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreVolunteerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreVolunteerRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function show($session_id, Volunteer $applicant)
    {
        return view('volunter.show', ['applicant' => $applicant]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingSession $trainingSession, $id)
    {
        $field_of_studies = FeildOfStudy::all();
        $educational_levels = EducationalLevel::$educationalLevel;
        $volunteer = Volunteer::find($id);
        return view('volunter.edit', compact('field_of_studies', 'educational_levels', 'volunteer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVolunteerRequest  $request
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function update(TrainingSession $trainingSession, $id, Request $request)
    {
        $volunteer =  Volunteer::find($id);
        $first_name = $request->get('first_name');
        $middle_name = $request->get('middle_name');
        $last_name =  $request->get('last_name');
        $phone = $request->get('phone');
        $email = $request->get('email');
        $gender = $request->get('gender');
        $education_level = $request->get('education_level');
        $gpa = $request->get('gpa');
        $field_of_study = $request->get('Field_of_study');

        $volunteer->update(['first_name'=>$first_name, 'father_name'=>$middle_name, 'grand_father_name'=>$last_name, 'phone'=>$phone, 'email'=>$email, 'gender'=>$gender, 'educational_level'=>$education_level, 'gpa'=>$gpa, 'field_of_study_id'=>$field_of_study]);
        return redirect()->route('session.volunteer.all', ['training_session'=>$trainingSession->id])->with('message', 'volunteer successfully updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Volunteer $volunteer)
    {
        //
    }

    public function application_form()
    {
        $availableSession = TrainingSession::availableForRegistration();
        if (count($availableSession) <= 0) {
            return view('application.no-open-form');
        }
        $before = Carbon::now()->subYears(18)->format('d/m/Y');
        $after = Carbon::now()->subYears(35)->format('d/m/Y');
        $disabilities = Disablity::all();
        $regions = Region::where('status', '=', 1)->get();
        $educationLevels = EducationalLevel::$educationalLevel;
        $fields = FeildOfStudy::all();
        $objectiveTexts = TranslationText::where('translation_type', 0)->get();
        $appTexts = TranslationText::where('translation_type', 1)->get();
        return view('application.form', compact('disabilities', 'objectiveTexts','appTexts', 'regions', 'educationLevels', 'fields', 'after', 'before'));
    }

    public function apply(StoreVolunteerRequest $request)
    {
        $availableSession = TrainingSession::availableSession();
        if (count($availableSession) <= 0) {
            return view('application.no-open-form');
        }
        $baseFilePath = 'training session/' . $availableSession[0]->id . '/';

        $date =  DateTime::createFromFormat('d/m/Y', $request->get('dob'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $date = Carbon::now();
        $after = Carbon::now()->subYears(35);
        $dob_GC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $before = Carbon::now()->subYears(18);
        if (!Carbon::createFromDate($dob_GC)->isBetween($after, $before)) {
            $afterET = DateTimeFactory::fromDateTime($after)->format('d/m/Y');
            $beforeET = DateTimeFactory::fromDateTime($before)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'dob' => 'The Date of Birth must be a date after ' . $afterET . ' before ' . $beforeET,
            ]);
            throw $validationException;
        }
        $volunteerData = $request->validated();
        $woreda_id = $volunteerData['woreda'];
        $field_of_study_id = $volunteerData['field_of_study'];
        // $disablity_id = $volunteerData['disability'];
        $volunteerData['woreda_id'] = $woreda_id;
        $volunteerData['field_of_study_id'] = $field_of_study_id;
        // $volunteerData['disablity_id'] = $disablity_id;
        $volunteerData['dob'] = $dob_GC;
        $volunteerData['password'] = Hash::make($volunteerData['password']);
        unset($volunteerData['agree_check'], $volunteerData['field_of_study'], $volunteerData['region'], $volunteerData['woreda'], $volunteerData['zone']);

        if (!$request->photo->isValid()) {
            throw ValidationException::withMessages(['photo' => 'Unable to upload photo please retry']);
        } else {
            $volunteerData['photo'] = FileController::fileUpload($request->photo, $baseFilePath . 'profile pictures/')->id;
        }

        if (!$request->bsc_document->isValid()) {
            throw ValidationException::withMessages(['bsc_document' => 'Unable to upload BSC document please retry']);
        } else {
            $volunteerData['bsc_document'] = FileController::fileUpload($request->bsc_document, $baseFilePath . 'bsc documents/')->id;
        }
        if (!$request->ministry_document->isValid()) {
            throw ValidationException::withMessages(['ministry_document' => 'Unable to upload Ministry document please retry']);
        } else {
            $volunteerData['ministry_document'] = FileController::fileUpload($request->ministry_document, $baseFilePath . 'ministry documents/')->id;
        }
        if (!$request->kebele_id->isValid()) {
            throw ValidationException::withMessages(['kebele_id' => 'Unable to upload Kebele Id please retry']);
        } else {
            $volunteerData['kebele_id'] = FileController::fileUpload($request->kebele_id, $baseFilePath . 'kebele identifications/')->id;
        }
        if (!$request->ethical_license->isValid()) {
            throw ValidationException::withMessages(['ethical_license' => 'Unable to upload Ethical LIcense Id please retry']);
        } else {
            $volunteerData['ethical_license'] = FileController::fileUpload($request->ethical_license, $baseFilePath . 'ethical licenses/')->id;
        }
        if ($request->hasFile('msc_document')) {
            if (!$request->msc_document->isValid()) {
                throw ValidationException::withMessages(['msc_document' => 'Unable to upload MSC document please retry']);
            }
            $volunteerData['msc_document'] = FileController::fileUpload($request->msc_document, $baseFilePath . 'msc documents/')->id;
        }
        if ($request->hasFile('phd_document')) {
            if (!$request->phd_document->isValid()) {
                throw ValidationException::withMessages(['phd_document' => 'Unable to upload PHD document please retry']);
            }
            $volunteerData['phd_document'] = FileController::fileUpload($request->phd_document, $baseFilePath . 'phd documents/')->id;
        }
        if ($request->hasFile('non_pregnant_validation_document')) {
            if (!$request->non_pregnant_validation_document->isValid()) {
                throw ValidationException::withMessages(['non_pregnant_validation_document' => 'Unable to upload Non Pregnant Validation document please retry']);
            }
            $volunteerData['non_pregnant_validation_document'] = FileController::fileUpload($request->non_pregnant_validation_document, $baseFilePath . 'pregenancy test documents/')->id;
        }
        // if (!isset($volunteerData['disability'])) {
        //     unset($volunteerData['disability']);
        // }
        // unset((isset($volunteerData['disability'])?$volunteerData['disability']:null));
        $volunteerData['training_session_id'] = $availableSession[0]->id;
        $volunteer = Volunteer::create($volunteerData);
        $verifyVolunteer = VerifyVolunteer::create([
            'volunteer_id' => $volunteer->id,
            'token' => sha1(time())
        ]);
        Status::Create(['volunteer_id' => $volunteer->id, 'acceptance_status' => 0]);
        dispatch(new SendEmailJob($volunteer->email, new VerifyMail($volunteer)));
        return redirect()->route('home')->with('apply_success', 'You successfully applied! Check your email');
    }
    public function Screen(Request $request, $session_id, Volunteer $volunteer)
    {
        // dd($request);
        if ($request->get('type') == 'accept') {
            $volunteer->status->update(['acceptance_status' => 1]);
            return redirect()->route('session.volunteer.index', ['training_session' => $volunteer->training_session_id])->with('message', 'Volunter document  Verified');
        } elseif ($request->get('type') == 'reject') {
            $volunteer->status->update(['acceptance_status' => 2,'rejection_reason'=>$request->get('rejection_reason')]);
            return redirect()->route('session.volunteer.index', ['training_session' => $volunteer->training_session_id])->with('message', 'Volunter document  unverified');
        }
    }
    public function verifyAllVolunteers($training_session)
    {
        Volunteer::query()->whereRelation('status', 'acceptance_status', '=', 0)->get()->map(function ($q) {
            $q->status->acceptance_status = 1;
            $q->status->save();
        });
        return redirect(route('session.applicant.verified', ['training_session' => $training_session]))->with('message', 'Verification Successful');
    }

    public function resetAll()
    {
        Volunteer::all()->map(function ($q) {
            $q->status->acceptance_status = 0;
            $q->status->save();
        });

        return redirect(route('session.volunteer.index', ['training_session' => request()->route('training_session')]))->with('message', 'Reset Successful');
    }

    public function emailUnverified($training_session)
    {
        $volunters = Volunteer::doesntHave('User')->where('training_session_id', $training_session)->paginate(1000);
        return view('volunter.email_unverified_volunter', ['volunters' => $volunters]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifiedApplicant(Request $request, $training_session)
    {
        if (!Auth::user()->can('Volunteer.verified.applicant')) {
            return abort(403);
        }
        $applicants =  Volunteer::whereRelation('status', 'acceptance_status','>=', Constants::VOLUNTEER_STATUS_DOCUMENT_VERIFIED)->where('training_session_id', $training_session);
        $user = Auth::user();
        if ($user->hasRole('regional-coordinator')) {
            $region = UserRegion::where('user_id', $user->id)->where('levelable_type', Region::class)->first();
          //  dd($region->levelable);
            $applicants = $applicants->whereRelation('woreda.zone.region', 'id', $region->levelable_id);
        }
        if ($user->hasRole('zone-coordinator')) {
            $zone = UserRegion::where('user_id', $user->id)->where('levelable_type', Zone::class)->first();
            $applicants = $applicants->whereRelation('woreda.zone', 'id', $zone->levelable_id);
        }

        $approved = ApprovedApplicant::where('training_session_id', $training_session)->get();
        // dd($applicants->get());

        return view('volunter.verified_volunter', ['volunters' => $applicants->paginate(10), 'trainingSession' => TrainingSession::find($training_session), 'approve' => $approved, 'traininig_session' => $training_session]);
    }
    public function selected(Request $request, $training_session)
    {
        if (!Auth::user()->can('Volunteer.selected')) {
            return abort(403);
        }
        $applicants =  Volunteer::whereRelation('approvedApplicant', 'training_session_id', $training_session);
        // dd($applicants->get());
        return view('volunter.selected_volunter', ['volunters' => $applicants->paginate(10), 'trainingSession' => TrainingSession::find($training_session), 'trainingCenterCapacities' => TrainingCenterCapacity::where('training_session_id', $training_session)->get()]);
    }
    protected function verifyEmail($token)
    {
        $verifyVolunteer = VerifyVolunteer::where('token', $token)->first();
        if (isset($verifyVolunteer)) {
            $volunteer = $verifyVolunteer->volunteer;
            if (!$volunteer->verified) {
                $status = "Your e-mail is verified. You can now login.";
                $userData = [
                    'first_name' => $volunteer->first_name,
                    'father_name' => $volunteer->father_name,
                    'grand_father_name' => $volunteer->grand_father_name,
                    'email' => $volunteer->email,
                    'dob' => $volunteer->dob,
                    'gender' => $volunteer->gender,
                    'password' => $volunteer->password,
                ];
                $user = User::create($userData);
                $user->email_verified_at = now();
                $user->update();
                $user->save();
                $user->assignRole(Role::findByName('volunteer'));
                $volunteerData['user_id'] = $user->id;
                $volunteer->user_id = $user->id;
                $volunteer->update();
                $volunteer->save();
                $verifyVolunteer->delete();
                // Auth::login($user);
                dispatch(new SendEmailJob($volunteer->email, new VolunteerAppliedMail($volunteer)));
                return redirect(route('home'))->with('message', 'Your Service Request Form will be reviewed shortly and a response made to the email address');
            } else {
                $status = "Your e-mail is already verified. You can now login.";
            }
        } else {
            return redirect('/login')->with('warning', "Sorry your email cannot be identified.");
        }
        return redirect('/login')->with('message', $status);
    }


    public function atendance(TrainingSession $trainingSession, Volunteer $volunteer)
    {
        return view('volunter.', compact('volunteer'));
    }
    public function volunteerAll(Request $request, $training_session)
    {
        // $applicants = Volunteer::where('training_session_id', $training_session);
        $applicants = Volunteer::where('training_session_id', $training_session);
        $user = Auth::user();
        if ($user->hasRole('regional-coordinator')) {
            $region = UserRegion::where('user_id', $user->id)->where('levelable_type', Region::class)->first();
          //  dd($region->levelable);
            $applicants = $applicants->whereRelation('woreda.zone.region', 'id', $region->levelable_id);
        }
        if ($user->hasRole('zone-coordinator')) {
            $zone = UserRegion::where('user_id', $user->id)->where('levelable_type', Zone::class)->first();
            $applicants = $applicants->whereRelation('woreda.zone', 'id', $zone->levelable_id);
        }


        if ($request->has('filter')) {
            $first_name = $request->get('first_name');
            $father_name = $request->get('father_name');
            $grand_father_name = $request->get('grand_father_name');
            $email = $request->get('email');
            $gender = $request->get('gender');
            $disablity_id = $request->get('disablity_id');
            $region_id = $request->get('region_id');
            $zone_id = $request->get('zone_id');
            $phone = $request->get('phone');
            $woreda_id = $request->get('woreda_id');
            $gpa = $request->get('gpa');
            $status = $request->get('acceptance_status');
            $id_number =  $request->get('id_number');

            if (!empty($id_number)) {
                $applicants = $applicants->where('id_number', $id_number);
            }
            if (!empty($first_name)) {
                $applicants = $applicants->where('first_name', 'like', '%' . $first_name . '%');
            }
            if (!empty($father_name)) {
                $applicants = $applicants->where('father_name', 'like', '%' . $father_name . '%');
            }
            if (!empty($grand_father_name)) {
                $applicants = $applicants->where('grand_father_name', 'like', '%' . $grand_father_name . '%');
            }
            if (!empty($email)) {
                $applicants = $applicants->where('email', 'like', '%' . $email . '%');
            }
            if (!empty($gender)) {
                $applicants = $applicants->where('gender', '=', $gender);
            }
            if (!empty($disablity_id)) {
                $applicants = $applicants->where('disablity_id', '=', $disablity_id);
            }
            if (!empty($region_id)) {
                $applicants = $applicants->whereRelation('woreda.zone.region', 'id', $region_id);
            }
            if (!empty($zone_id)) {
                $applicants = $applicants->whereRelation('woreda.zone', 'id', $zone_id);
            }
            if (!empty($phone)) {
                $applicants = $applicants->where('phone', 'like', '%' . $phone . '%');
            }
            if (!empty($woreda_id)) {
                $applicants = $applicants->where('woreda_id', '=', $woreda_id);
            }
            if (!empty($gpa)) {
                $applicants = $applicants->where('gpa', '=', $gpa);
            }
            if (!empty($status)) {
                $applicants = $applicants->whereRelation('status', 'acceptance_status', $status);
            }
        }
        return view('volunter.all_volunteer', ['volunters' => $applicants->paginate(10), 'trainingSession' => TrainingSession::find($training_session), 'regions' => Region::all(), 'woredas' => Woreda::all(), 'zones' => Zone::all(), 'disabilities' => Disablity::all()]);
    }
    public function volunteerDetail($training_session, Volunteer $volunteer)
    {
        return view('volunter.detail', ['volunteer' => $volunteer]);
    }
    public function exportVolunteers(TrainingSession $trainingSession){
        $all_volunteers = DB::table('volunteers as v')
        ->join('woredas as w', 'v.woreda_id', '=', 'w.id')
        ->join('zones as z', 'w.zone_id', '=', 'z.id')
        ->join('regions as r', 'z.region_id', '=', 'r.id')
        ->leftJoin('approved_applicants', 'v.id', '=', 'approved_applicants.volunteer_id')
        ->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
        ->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')
        ->leftJoin('trainining_centers as tc', 'tc.id', '=', 'training_center_capacities.trainining_center_id')->where('v.training_session_id', $trainingSession->id)->select(['v.id_number', 'v.first_name', 'v.father_name', 'v.grand_father_name', 'v.phone', 'v.gender', 'r.name as region_name', 'z.name as zone_name','w.name as woreda_name', 'tc.name as center_name'])->get();

        // dd($all_volunteers[0]);

        // $woredas = Woreda::all()->pluck('name');

        return Excel::download(new ApplicantExport($all_volunteers, ['ID Number','First Name', 'Father Name', 'Grand Father Name', 'Phone Number', 'Gender', 'Region','Zone','Woreda', 'Training Center']), 'MopYVMS.xlsx');

    }
    public function importVolunteers(Request $request, TrainingSession $trainingSession){
        Excel::import(new ApplicantImport($trainingSession), $request->file('attendance')->store('temp'));
        $past_url = url()->previous();
        return redirect($past_url)->with('success', 'Successfully Imported!!!');
    }

}
