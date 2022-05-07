<?php

namespace App\Http\Controllers;

use Andegna\DateTimeFactory;
use App\Models\Volunteer;
use App\Http\Requests\StoreVolunteerRequest;
use App\Http\Requests\UpdateVolunteerRequest;
use App\Models\Disablity;
use App\Models\EducationalLevel;
use App\Models\FeildOfStudy;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\Woreda;
use App\Models\Zone;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class VolunteerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request,$session_id)
    {
                $applicants=Volunteer::query();


        if($request->has('filter')){
            $first_name=$request->get('first_name');
            $father_name=$request->get('father_name');
            $grand_father_name=$request->get('grand_father_name');
            $email=$request->get('email');
            $gender=$request->get('gender');
            $disablity_id=$request->get('disablity_id');
            $region_id=$request->get('region_id');
            $zone_id=$request->get('zone_id');
            $phone=$request->get('phone');
            $woreda_id=$request->get('woreda_id');
            $gpa=$request->get('gpa');
            if (!empty($first_name)) {
                $applicants = $applicants->where('first_name', 'like', '%'.$first_name.'%');
            }
            if (!empty($father_name)) {
                $applicants = $applicants->where('father_name', 'like', '%'.$father_name.'%');
            }
            if (!empty($grand_father_name)) {
                $applicants = $applicants->where('grand_father_name', 'like', '%'.$grand_father_name.'%');
            }
            if (!empty($email)) {
                $applicants = $applicants->where('email', 'like', '%'.$email.'%');
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
                $applicants =$applicants->where('phone', 'like', '%'.$phone.'%');
            }
            if (!empty($woreda_id)) {
                $applicants = $applicants->where('woreda_id', '=', $woreda_id);
            }
            if (!empty($gpa)) {
                $applicants = $applicants->where('gpa', '=', $gpa);
            }
        }
        return view('volunter.index',['volunters'=>$applicants->paginate(10),'trainingSession'=>TrainingSession::find($session_id),'regions'=>Region::all(),'woredas'=>Woreda::all(),'zones'=>Zone::all(),'disabilities'=>Disablity::all()]);
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
        if(count($availableSession)<=0){
            return view('application.no-open-form');
        }
        $disabilities = Disablity::all();
        $regions = Region::all();
        $educationLevels = EducationalLevel::$educationalLevel;
        $fields = FeildOfStudy::all();
        return view('application.form', compact('disabilities', 'regions', 'educationLevels','fields'));
    }

    public function apply(StoreVolunteerRequest $request)
    {
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
        dd('u');
    }
}
