<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Models\Volunteer;
use App\Http\Requests\StoreVolunteerRequest;
use App\Http\Requests\UpdateVolunteerRequest;
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
use App\Models\Status;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingPlacement;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
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
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class VolunteerController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Volunteer::class,'volunteer');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $session_id)
    {
        // foreach (Volunteer::all() as $key => $value) {
        //     Status::create(['volunteer_id'=>$value->id, 'acceptance_status'=>1]);
        // }
        // dd('done');

        // $status = new Status();
        // foreach (Volunteer::all() as $key => $value) {
        //     $status = new Status();
        //     $status->volunteer_id = $value->id;
        //     $status->acceptance_status = 1;
        //     $status->save();
        // }
        // dd('dsf');
// $r =[];
//         foreach (Volunteer::all() as $key => $value) {
//             if ($value->woreda->zone->region->id == 1) {
//                 array_push($r, $value->woreda->zone->region->id == 1);
//             }
//         }
//         dd(count($r));
        $applicants = Volunteer::whereRelation('status','acceptance_status',0)->where('training_session_id', $session_id);


        // foreach(Volunteer::all() as $applicant){
        //             Status::create(['volunteer_id'=>$applicant->id,'acceptance_status'=>1]);
        // }
        // dd('done');
        // dd($applicants->get());
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
                $applicants = $applicants->where('region_id', '=', $region_id);
            }
            if (!empty($zone_id)) {
                $applicants = $applicants->where('zone_id', '=', $zone_id);
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
        }

        return view('volunter.index', ['volunters' => $applicants->paginate(6), 'trainingSession' => TrainingSession::find($session_id), 'regions' => Region::all(), 'woredas' => Woreda::all(), 'zones' => Zone::all(), 'disabilities' => Disablity::all()]);
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
    public function show($session_id, $volunteer)
    {
        return view('volunter.show', ['applicant' => Volunteer::find($volunteer)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function edit(Volunteer $volunteer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateVolunteerRequest  $request
     * @param  \App\Models\Volunteer  $volunteer
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateVolunteerRequest $request, Volunteer $volunteer)
    {
        //
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
        return view('application.form', compact('disabilities', 'regions', 'educationLevels', 'fields', 'after', 'before'));
    }

    public function apply(StoreVolunteerRequest $request)
    {
        $availableSession = TrainingSession::availableSession();
        if (count($availableSession) <= 0) {
            return view('application.no-open-form');
        }
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
            return ValidationException::withMessages(['photo' => 'Unable to upload photo please retry']);
        } else {
            $volunteerData['photo'] = FileController::fileUpload($request->photo)->id;
        }

        if (!$request->bsc_document->isValid()) {
            return ValidationException::withMessages(['bsc_document' => 'Unable to upload BSC document please retry']);
        } else {
            $volunteerData['bsc_document'] = FileController::fileUpload($request->bsc_document)->id;
        }
        if (!$request->ministry_document->isValid()) {
            return ValidationException::withMessages(['ministry_document' => 'Unable to upload Ministry document please retry']);
        } else {
            $volunteerData['ministry_document'] = FileController::fileUpload($request->ministry_document)->id;
        }
        if (!$request->kebele_id->isValid()) {
            return ValidationException::withMessages(['kebele_id' => 'Unable to upload Kebele Id please retry']);
        } else {
            $volunteerData['kebele_id'] = FileController::fileUpload($request->kebele_id)->id;
        }
        if (!$request->ethical_license->isValid()) {
            return ValidationException::withMessages(['ethical_license' => 'Unable to upload Ethical LIcense Id please retry']);
        } else {
            $volunteerData['ethical_license'] = FileController::fileUpload($request->ethical_license)->id;
        }
        if ($request->hasFile('msc_document')) {
            if (!$request->msc_document->isValid()) {
                return ValidationException::withMessages(['msc_document' => 'Unable to upload MSC document please retry']);
            }
            $volunteerData['msc_document'] = FileController::fileUpload($request->msc_document)->id;
        }
        if ($request->hasFile('phd_document')) {
            if (!$request->phd_document->isValid()) {
                return ValidationException::withMessages(['phd_document' => 'Unable to upload PHD document please retry']);
            }
            $volunteerData['phd_document'] = FileController::fileUpload($request->phd_document)->id;
        }
        if ($request->hasFile('non_pregnant_validation_document')) {
            if (!$request->non_pregnant_validation_document->isValid()) {
                return ValidationException::withMessages(['non_pregnant_validation_document' => 'Unable to upload Non Pregnant Validation document please retry']);
            }
            $volunteerData['non_pregnant_validation_document'] = FileController::fileUpload($request->non_pregnant_validation_document)->id;
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
    public function Screen(Request $request, $session_id,$applicant_id)
    {
        if ($request->get('type') == 'accept') {
            Volunteer::find($applicant_id)->status->update(['acceptance_status' => 1]);
        
            return redirect()->route('session.applicant.index', ['training_session' => Volunteer::find($applicant_id)->training_session_id])->with('message','Volunter document  Verified');
        } elseif ($request->get('type') == 'reject') {
            Volunteer::find($applicant_id)->status->update(['acceptance_status' => 2]);
            return redirect()->route('session.applicant.index', ['training_session' => Volunteer::find($applicant_id)->training_session_id]);
            // return redirect()->back();
        }
    }
    public function emailUnverified($training_session)
    {
        $volunters = Volunteer::whereRelation('User', 'email_verified_at', null)->where('training_session_id', $training_session)->paginate(6);
        return view('volunter.email_unverified_volunter', ['volunters' => $volunters]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function verifiedApplicant(Request $request, $training_session)
    {
        $applicants =  Volunteer::whereRelation('status', 'acceptance_status', 1)->where('training_session_id', $training_session);

        $approved = ApprovedApplicant::where('training_session_id', $training_session)->get();

        return view('volunter.verified_volunter', ['volunters' => $applicants->paginate(10), 'trainingSession' => TrainingSession::find($training_session), 'approve' => $approved, 'traininig_session'=> $training_session]);
    }
    public function selected(Request $request, $training_session)
    {
        $applicants =  Volunteer::has('approvedApplicant')->where('training_session_id', $training_session);
        return view('volunter.selected_volunter', ['volunters' => $applicants->paginate(10), 'trainingSession' => TrainingSession::find($training_session),'trainingCenterCapacities'=>TrainingCenterCapacity::where('training_session_id',$training_session)->get()]);
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
                // $verifyVolunteer->delete();
                Auth::login($user);
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
}
