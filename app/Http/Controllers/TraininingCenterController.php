<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Exports\UsersExport;
use App\Models\TraininingCenter;
use App\Http\Requests\StoreTraininingCenterRequest;
use App\Http\Requests\UpdateTraininingCenterRequest;
use App\Imports\UsersImport;
use App\Models\ApprovedApplicant;
use App\Models\BarQRVolunteer;
use App\Models\CindicationRoom;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingSession;
use App\Models\Zone;
use App\Models\Region;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\Training;
use App\Models\TrainingCenterBasedPermission;
use App\Models\TrainingSchedule;
use App\Models\TrainingSessionTraining;
use App\Models\User;
use App\Models\UserAttendance;
use App\Models\Volunteer;
use App\Models\Woreda;
use App\Models\WoredaIntake;
use Database\Seeders\PermissionSeeder;
use Database\Seeders\UserAttendanceSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \Maatwebsite\Excel\Facades\Excel;
use PHPUnit\TextUI\XmlConfiguration\Constant;

class TraininingCenterController extends Controller
{
    public function __construct()
    {
        // $this->authorizeResource(TraininingCenter::class, 'TraininingCenter');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(TraininingCenter::select())->make(true);
        }
        // $user = Auth::user();
        // if(!$user->hasRole('super-admin') && !$user->hasPermissionTo('role.viewAll')){
        //     abort(403);
        // }
        if (!Auth::user()->can('TraininingCenter.index')) {

            return abort(403);
        }
        return view('training_center.index');
    }
    public function placement(Request $request, $zone = null)
    {

        $trainining_centers = TraininingCenter::all();
        $regions = Region::all();
        //  $region = $zone->region;
        return view('training_center.placement', compact('trainining_centers', 'regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (!Auth::user()->can('TraininingCenter.store')) {

            return abort(403);
        }

        return view("training_center.create", ['zones' => Zone::all()]);

        //  return view('payrollSheet.create');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTraininingCenterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTraininingCenterRequest $request)
    {
        // dd($request->get('scale'));
        if (!Auth::user()->can('TraininingCenter.store')) {

            return abort(403);
        }


        $request->validate([
            'logo' => 'image|mimes:jpg,png,jpeg,svg|max:2048|',
            'name' => 'min:2|required|regex:/^[a-z A-Z]+$/u|max:255|unique:trainining_centers,name',
            'code' => 'required|string|unique:trainining_centers,code',
            'scale' => 'min:0|required:trainining_centers,scale',
            'status' => 'required',
            'logo' => 'required',
        ]);
        $logoFile = FileController::fileUpload($request->logo, 'training center logos/')->id;
        TraininingCenter::create([
            'name' => $request->get('name'),
            'code' => $request->get('code'),
            'logo' => $logoFile,
            'zone_id' => $request->get('zone_id'),
            'scale' => $request->get('scale'),
            'status' => $request->get('status')
        ]);


        return redirect()->route('TrainingCenter.index')->with('message', 'Training Center created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function show($traininingCenter)
    {
        if (!Auth::user()->can('TraininingCenter.show')) {

            return abort(403);
        }

        $traininingCenter     = TraininingCenter::with('capacities.trainningSession')->find($traininingCenter);
        $trainingSession      = new TrainingSession();
        $trainingSessionId    = $trainingSession->availableSession()?->first()?->id;
        $capaityAddedInCenter = TrainingCenterCapacity::where(
            'training_session_id',
            $trainingSessionId
        )->where(
            'trainining_center_id',
            $traininingCenter->id
        )->get();
        return view('training_center.show', [
            'trainingCenter' => $traininingCenter,
            'capaityAddedInCenter' => $capaityAddedInCenter,
            'users' => User::all()
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function edit($TrainingCenter)

    {
        if (!Auth::user()->can('TraininingCenter.update')) {

            return abort(403);
        }
        return view('training_center.create', [
            'trainingCenter' => TraininingCenter::findOrFail($TrainingCenter),
            'zones' => Zone::all()
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTraininingCenterRequest  $request
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTraininingCenterRequest $request,  $traininingCenter)
    {
        if (!Auth::user()->can('TraininingCenter.update')) {

            return abort(403);
        }


        $TrainingCenter = TraininingCenter::findOrFail($traininingCenter);
        // $logoFile = FileController::deleteFile($TrainingCenter->photo);
        $data = $request->validate([
            'logo' => 'image|mimes:jpg,png,jpeg,svg|max:2048|',
            'name' => 'min:2|required|string|unique:trainining_centers,name,' . $traininingCenter,
            'code' => 'required|string|unique:trainining_centers,code,' . $traininingCenter,
            'scale' => 'min:0|required:trainining_centers,scale,' . $traininingCenter,
            // 'status' => 'required'
        ]);
        if ($request->file('logo')) {
            if ($TrainingCenter->photo) {
                FileController::deleteFile($TrainingCenter->photo);
                $logoFile = FileController::fileUpload($request->file('logo'), 'training center logos/')->id;
                $TrainingCenter->logo = $logoFile;
            } else {

                $logoFile = FileController::fileUpload($request->file('logo'), 'training center logos/')->id;
                $TrainingCenter->logo = $logoFile;
            }
        }
        $TrainingCenter->update(['name' => $data['name'], 'code' => $data['code'], 'scale' => $data['scale']]);
        if ($request->get('status') == 'on') {
            $TrainingCenter->status = 1;
        } else {
            $TrainingCenter->status = 0;
        }
        return redirect()->route('TrainingCenter.index')->with('message', 'Training Center updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, TraininingCenter $traininingCenter)
    {
        if (!Auth::user()->can('TraininingCenter.destroy')) {

            return abort(403);
        }
        $traininingCenter->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
    public function assignChecker(Request $request, TrainingSession $trainingSession, TraininingCenter $trainingCenter)
    {
        $data = $request->validate(['checkerUser' => 'required|numeric']);
        $checkerPermission = Permission::findOrCreate('checker');
        $trainingCenterBasedPermissionQuery = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('user_id', $data['checkerUser'])->where('trainining_center_id', $trainingCenter->id)->where('permission_id', $checkerPermission->id);
        $trainingCenterBasedPermissionCount = $trainingCenterBasedPermissionQuery->count();
        if ($trainingCenterBasedPermissionCount == 0) {
            TrainingCenterBasedPermission::create([
                'training_session_id' => $trainingSession->id,
                'user_id' => $data['checkerUser'],
                'trainining_center_id' => $trainingCenter->id,
                'permission_id' => $checkerPermission->id
            ]);
        } else {
            $trainingCenterBasedPermissionQuery->latest()->first()->delete();
            return redirect()->back()->with(['message' => 'Checker removed successfully']);
        }
        return redirect()->back()->with(['message' => 'Checker added successfully']);
    }
    public function RemoveChecker($checker_id)
    {
        // dd($checker_id);
        $user = User::find($checker_id);


        $user->trainingCheckerOf()->dissociate();
        $user->save();
        return redirect()->back();
    }
    public function checkInView()
    {
        if (!Auth::user()->can('checker')) {

            return abort(403);
        }
        // dd(Auth::user()->can('dashboard.index'));
        return view('training_center.check_in.check_in');
    }
    public function result(Request $request)
    {

        $permission = Permission::findOrCreate('checker');
        // dd(Auth::user()->id);
        if (!Auth::user()->can('checker')) {
            return abort(403);
        }
        if (Auth::user()->hasRole(Constants::SUPER_ADMIN)) {
            if ($request->ajax()) {
                $output = '';
                $query = $request->get('query');
                // Auth::user()->getRoleNames()[0]==Constants::SYSTEM_USER_ROLE;//Need This For Permission
                $volunteerQuery = Volunteer::with('woreda.zone.region')->where('id_number', 'MoP-' . $query);
                if (count($volunteerQuery->get()) > 0) {
                    $data = $volunteerQuery->whereRelation('status', 'acceptance_status', 4)->first();
                    // $accepted = $volunteerQuery->whereRelation('status', 'acceptance_status', 5)->first();
                    if (!$data) {
                        return json_encode(['status' => 505]);
                    }
                    return json_encode(['status' => 200, 'data' => $data]);
                    // }
                } else {
                    return json_encode(['status' => 404]);
                }
                // echo json_encode($data);
            }
        } else {
            $TrainingBasedPermission = TrainingCenterBasedPermission::where('training_session_id', $request->route('training_session'))->where('user_id', Auth::user()->id)->where('permission_id', $permission->id)->first();
            $trainingCenterId = $TrainingBasedPermission?->traininingCenter?->id;
            if ($request->ajax()) {
                $output = '';
                $query = $request->get('query');
                // Auth::user()->getRoleNames()[0]==Constants::SYSTEM_USER_ROLE;//Need This For Permission
                $volunteerQuery = Volunteer::with('woreda.zone.region')->where('id_number', 'MoP-' . $query)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainingCenterId);
                if (count($volunteerQuery->get()) > 0) {
                    $data = $volunteerQuery->whereRelation('status', 'acceptance_status', 4)->first();
                    // $accepted = $volunteerQuery->whereRelation('status', 'acceptance_status', 5)->first();

                    if (!$data) {
                        return json_encode(['status' => 505]);
                    }
                    return json_encode(['status' => 200, 'data' => $data]);
                    // }
                } else {
                    return json_encode(['status' => 404]);
                }
                // echo json_encode($data);
            }
        }
    }

    public function checkIn($training_session, $id)
    {
        Volunteer::find($id)->status->update(['acceptance_status' => 5]);
        return redirect()->route('session.TrainingCenter.CheckIn', ['training_session' => $training_session]);
    }
    public function checkInAll(TrainingSession $trainingSession)
    {
        $volunteers = Volunteer::whereRelation('status', 'acceptance_status', 4)->get();
        foreach ($volunteers as $volunteer) {
            Volunteer::find($volunteer->id)->status->update(['acceptance_status' => 5]);
        }
        return redirect()->back()->with('message', 'All applicant checked in successfully');
    }
    public function indexChecking($training_session, Request $request)
    {
        $volunteersChecked = Volunteer::with('woreda.zone.region')->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', Auth::user()->trainingCheckerOf?->id);
        if ($request->has('filter')) {
            $status = $request->get('status');
            if (!empty($status)) {
                $volunteersChecked->whereRelation('status', 'acceptance_status', $status);
            }
        }
        return view('training_center.check_in.index', ['volunteersChecked' => $volunteersChecked->paginate(10)]);
    }
    public function giveResource(Request $request, $training_session, $training_center_id)
    {

        // $permission = Permission::findOrCreate('checker');
        // $TrainingBasedPermission = TrainingCenterBasedPermission::where('training_session_id', $request->route('training_session'))->where('user_id', Auth::user()->id)->where('permission_id', $permission->id)->first();
        // $trainingCenterId = $TrainingBasedPermission?->traininingCenter->id;
        $volunteers = Volunteer::whereRelation('status', 'acceptance_status', 5)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id);
        $id = $request->get('id_number');
        $gender = $request->get('gender');
        if ($request->has('filter')) {
            // dd($id);
            if (!empty($id)) {
                $volunteers = $volunteers->where('id_number', 'like', '%' . $id . '%');
            }
            if (!empty($gender)) {
                $volunteers = $volunteers->where('gender', '=', $gender);
            }
        }

        return view('training_center.assign_resource', ['volunteers' => $volunteers->paginate(10), 'training_center_id' => $training_center_id]);
    }
    public function giveResourceDetail(Request $request, $training_session, $training_center_id, $volunter)
    {
        $coordinatorPermission = Permission::findOrCreate(PermissionSeeder::CENTER_COORIDNATOR);
        $TrainingBasedPermission = TrainingCenterBasedPermission::where('training_session_id', $request->route('training_session'))->where('user_id', Auth::user()->id)->where('permission_id', $coordinatorPermission->id)->first();
        $trainingCenterOfAuthUserId = $TrainingBasedPermission?->traininingCenter->id;
        $vol = DB::table('volunteers')
            ->where('volunteers.training_session_id', '=', $training_session)
            ->where('volunteers.id', '=', $volunter)
            ->join('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
            ->join('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
            ->join('training_center_capacities', 'training_center_capacities.id', '=', 'training_placements.training_center_capacity_id')
            ->join('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
            ->where('trainining_centers.id', '=', $training_center_id)

            ->count();

        if (Auth::user()->can('TraininingCenter.giveResourceDetail')) {
            
            if ($trainingCenterOfAuthUserId == $training_center_id||Auth::user()->hasRole(Constants::SUPER_ADMIN)) {
                if ($vol > 0) {
                    $training_center = TraininingCenter::with('resources')->find($training_center_id);
                    return view('training_center.assign_resource_voluteer', ['training_center' => $training_center, 'volunteer' => Volunteer::find($volunter)]);
                } else {
                    return abort(403);
                    }
            } else {
                return abort(403);
            }
        }
    }
    public function storeResourceToVolunteer($training_session, $training_center_id, $volunter, $resourceId)
    {
        {
            $coordinatorPermission = Permission::findOrCreate(PermissionSeeder::CENTER_COORIDNATOR);
            $TrainingBasedPermission = TrainingCenterBasedPermission::where('training_session_id', $request->route('training_session'))->where('user_id', Auth::user()->id)->where('permission_id', $coordinatorPermission->id)->first();
            $trainingCenterOfAuthUserId = $TrainingBasedPermission?->traininingCenter->id;
            $vol = DB::table('volunteers')
                ->where('volunteers.training_session_id', '=', $training_session)
                ->where('volunteers.id', '=', $volunter)
                ->join('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
                ->join('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
                ->join('training_center_capacities', 'training_center_capacities.id', '=', 'training_placements.training_center_capacity_id')
                ->join('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
                ->where('trainining_centers.id', '=', $training_center_id)

                ->count();

            if (Auth::user()->can('TraininingCenter.giveResourceDetail')) {
                if ($trainingCenterOfAuthUserId == $training_center_id) {
                    if ($vol > 0) {
                        $training_center = TraininingCenter::with('resources')->find($training_center_id);
                        return view('training_center.assign_resource_voluteer', ['training_center' => $training_center, 'volunteer' => Volunteer::find($volunter)]);
                    } else {
                        return abort(403);
                        }
                } else {
                    return abort(403);
                }
            }
        }
    }

    public function trainingShow(TrainingSession $trainingSession, TraininingCenter $trainingCenter, Training $training)
    {
        $applicants = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainingSession->id)->paginate(10);
        $att_history = [];

        foreach (UserAttendance::all() as $key => $value) {
            array_push($att_history, $value->training_schedule_id . ',' . User::where('id', $value->user_id)->get()->first()->volunteer->id);
        }

        $trainingSchedules = TrainingSchedule::whereIn('training_session_training_id', TrainingSessionTraining::where('training_session_id', $trainingSession->id)->where('training_id', $training->id)->pluck('id'))->get();

        return view('training_center.training_center_attendance', compact('trainingSession', 'trainingCenter', 'training', 'applicants', 'trainingSchedules', 'att_history'));
    }

    public function trainingSchedule(Request $request)
    {
        $id_arr =  explode(",", $request->check);

        $user_id = Volunteer::where('id', $id_arr[1])->get()->first()->user->id;

        UserAttendance::create(['user_id' => $user_id, 'training_schedule_id' => $id_arr[0]]);

        return response()->json(['check' => 'success']);
    }

    public function trainingScheduleRemove(Request $request)
    {
        $id_arr =  explode(",", $request->check);

        foreach (UserAttendance::all() as $key => $value) {
            if ($value->training_schedule_id == $id_arr[0] && User::where('id', $value->user_id)->get()->first()->volunteer->id == $id_arr[1]) {
                $value->delete();
            }
        }

        return response()->json(['check' => 'sucess']);
    }

    public function get_attendance_data(Request $request, TrainingSession $trainingSession, TraininingCenter $trainingCenter, CindicationRoom $cindicationRoom)
    {
        $schedule_id = $request->get('schedule_id');
        $users = DB::table('volunteers')->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')->where('training_center_capacities.trainining_center_id', $trainingCenter->id)->where('cindication_room_id', $cindicationRoom->id)->select(['id_number', 'first_name', 'father_name', 'grand_father_name'])->get();

        return Excel::download(new UsersExport($users, ['ID Number', 'First Name', 'Father Name', 'Grand Father Name', 'Status', $schedule_id]), 'attendance.xlsx');
        // return Excel::download(new UserAttendance(), 'attendance.xlsx');
    }

    public function fileImport(Request $request, TrainingSession $trainingSession, TraininingCenter $trainingCenter, CindicationRoom $cindicationRoom)
    {
        Excel::import(new UsersImport($trainingSession, $trainingCenter, $cindicationRoom), $request->file('attendance')->store('temp'));
        $past_url = url()->previous();
        return redirect($past_url)->with('success', 'Successfully Imported!!!');
    }

    public function placeVolunteers(TrainingSession $trainingSession, TraininingCenter $trainingCenter)
    {
        $volunteerGroups = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainingCenter->id)->get()->groupBy('woreda.zone.region.id');
        if (count($trainingCenter->rooms) <= 0) {
            return redirect()->back()->with('error', 'You have no syndication room!');
        }
        if (count($volunteerGroups) <= 0) {
            return redirect()->back()->with('error', 'You have no volunteer to place');
        }
        $cindicationRooms = CindicationRoom::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->get();
        $x = 0;
        $volunteerGroups = array_values($volunteerGroups->toArray());
        $numberOfRegions = count($volunteerGroups);
        foreach ($cindicationRooms as $cindicationRoom) {
            $roomCapacity = $cindicationRoom->number_of_volunteers;
            $placed = 0;
            $x = 0;
            while ($roomCapacity > $placed) {
                $row = $x % $numberOfRegions;
                if (count($volunteerGroups[$row]) > 0) {
                    $volunteer = Volunteer::find($volunteerGroups[$row][0]['id']);
                    $volunteer->update([
                        'cindication_room_id' => $cindicationRoom->id,
                    ]);
                    $volunteer->save();
                    unset($volunteerGroups[$row][0]);
                    $volunteerGroups[$row] = array_values($volunteerGroups[$row]);
                    $placed++;
                }
                $x++;
                // if ($x > 2000) {
                // dd('Contact Abdurhman for this error');
                // break;
                // }
            }
        }
        return redirect()->back()->with('message', 'Volunteer placment finnished');
    }

    public function show_all_volunteers(TrainingSession $trainingSession, TraininingCenter $trainingCenter, UserAttendance $userAttendance)
    {
        $check_deployed = [];

        $applicants = DB::table('volunteers')
            ->join('statuses', 'statuses.volunteer_id', '=', 'volunteers.id')
            // ->join('users', 'users.id','=', 'volunteers.user_id')
            ->leftJoin('approved_applicants', 'volunteers.id', '=', 'approved_applicants.volunteer_id')
            ->leftJoin('training_placements', 'approved_applicants.id', '=', 'training_placements.approved_applicant_id')
            ->leftJoin('training_center_capacities', 'training_placements.training_center_capacity_id', '=', 'training_center_capacities.id')
            ->leftJoin('trainining_centers', 'trainining_centers.id', '=', 'training_center_capacities.trainining_center_id')
            ->where('trainining_centers.id', $trainingCenter->id)
            ->select('*')
            ->paginate(10);

        $trainingSchedules = TrainingSchedule::all();

        foreach ($applicants as $key => $applicant) {
            if ($applicant->acceptance_status == 7) {
                array_push($check_deployed, $applicant);
            }
        }

        $arr = [];
        foreach ($trainingSchedules as $key => $schedule) {
            array_push($arr, $schedule->schedule->date);
        }

        $arr_unique = array_unique($arr);

        return view('training_center.show_all', compact('applicants', 'trainingCenter', 'trainingSession', 'userAttendance', 'arr_unique', 'check_deployed'));
    }

    public function graduateVolunteers(Request $request, TrainingSession $trainingSession)
    {
        // gc_vol, att_amount

        // dd($trainingSession);
        $att_amount = $request->get('att_amount');
        $all_vol = $request->get('gc_vol');
        $max_att = $request->get('max_attendance');
        $att_count = [];

        $applicants = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $request->get('training_center'))->whereRelation('status', 'acceptance_status', Constants::VOLUNTEER_STATUS_CHECKEDIN)->get();

        if (!$request->get('att_amount') && !$request->get('gc_vol')) {
            return redirect()->back()->with('error', 'You have not selected anything!');
        } else if ($all_vol) {
            foreach ($applicants as $key => $applicant) {
                Status::where('volunteer_id', $applicant->id)->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_GRADUATED]);
            }
        } else {
            foreach ($applicants as $key => $applicant) {
                if ($applicant->user->attendances->count() >= $att_amount) {
                    array_push($att_count, $applicant);
                    // Status::where('volunteer_id', $applicant->id)->update(['acceptance_status' => 6]);
                }
            }

            if (!$att_count) {
                return redirect()->back()->with('error', 'No volunteer meet your requirement!');
            } else {
                foreach ($att_count as $key => $applicant) {
                    Status::where('volunteer_id', $applicant->id)->update(['acceptance_status' => Constants::VOLUNTEER_STATUS_GRADUATED]);
                }
            }
        }
        return redirect()->back()->with('message', 'Volunteer Successfully Graduated!!!');
    }

    public function graduationList(TrainingSession $trainingSession, Request $request)
    {
        $training_centers = TraininingCenter::all();
        $regions = Region::all();

        $q = Volunteer::whereRelation('status', 'acceptance_status', Constants::VOLUNTEER_STATUS_GRADUATED)->where('training_session_id', $trainingSession->id);

        if ($request->get('training_center') != null) {
            $q->whereHas('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', function ($query) use ($request) {
                $query->where('id', $request->get('training_center'));
            });
        }
        if ($request->get('region') != null) {
            $q->whereHas('woreda.zone.region', function ($query) use ($request) {
                $query->where('id', $request->get('region'));
            });
        }

        $graduatedVolunteers = $q->paginate(10);

        return view('volunter.graduated_volunteers', compact('training_centers', 'regions', 'graduatedVolunteers'));
    }

    public function barQRCode(Request $request)
    {
        $volunteer_id = Volunteer::where('id_number', $request->id_number)->get()->first()->id;
        $barcheck = BarQRVolunteer::where('volunteer_id', $volunteer_id)->get()->first();
        if (!$barcheck) {
            BarQRVolunteer::create(['volunteer_id'=>$volunteer_id, 'bar_code'=>$request->barSrc, 'qr_code'=>$request->qrSrc]);
        }
        return response()->json(array('success' => 'success'), 200);
    }
}
