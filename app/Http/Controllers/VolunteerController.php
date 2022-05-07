<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Models\Volunteer;
use App\Http\Requests\StoreVolunteerRequest;
use App\Http\Requests\UpdateVolunteerRequest;
use App\Models\Disablity;
use App\Models\EducationalLevel;
use App\Models\FeildOfStudy;
use App\Models\File;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\User;
use Carbon\Carbon;
use DateTime;
use Faker\Factory;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Role;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('volunter.index',['volunters'=>Volunteer::paginate(10)]);
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
    public function show(Volunteer $volunteer)
    {
        //
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
        $availableSession = TrainingSession::availableSession();
        if (count($availableSession) <= 0) {
            return view('application.no-open-form');
        }
        $before = Carbon::now()->subYears(18)->format('d/m/Y');
        $after = Carbon::now()->subYears(35)->format('d/m/Y');
        $disabilities = Disablity::all();
        $regions = Region::all();
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
        $faker = Factory::create();
        $password = $faker->password(8);
        $userData = [
            'first_name' => $request->get('first_name'),
            'father_name' => $request->get('father_name'),
            'grand_father_name' => $request->get('grand_father_name'),
            'email' => $request->get('email'),
            'dob' => $dob_GC,
            'gender' => $request->get('gender'),
            'password' => $password,
        ];
        $volunteerData = $request->validated();
        $woreda_id = $volunteerData['woreda'];
        $field_of_study_id = $volunteerData['field_of_study'];
        $disablity_id = $volunteerData['disability'];
        $volunteerData['woreda_id'] = $woreda_id;
        $volunteerData['field_of_study_id'] = $field_of_study_id;
        $volunteerData['disablity_id'] = $disablity_id;
        $volunteerData['dob'] = $dob_GC;
        unset($volunteerData['agree_check'], $volunteerData['disability'], $volunteerData['field_of_study'], $volunteerData['region'], $volunteerData['woreda'], $volunteerData['zone']);

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
        if (!isset($volunteerData['disability'])) {
            unset($volunteerData['disability']);
        }
        // unset((isset($volunteerData['disability'])?$volunteerData['disability']:null));
        $volunteerData['training_session_id'] = $availableSession[0]->id;
        // dd($volunteerData);
        $user = User::create($userData);
        $user->assignRole(Role::findByName('applicant'));
        $volunteerData['user_id'] = $user->id;
        $volunteer = Volunteer::create($volunteerData);
        return redirect()->route('home')->with('apply_success','You successfully applied! Check your email');
    }
}
