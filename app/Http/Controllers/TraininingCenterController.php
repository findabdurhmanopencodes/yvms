<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\TraininingCenter;
use App\Http\Requests\StoreTraininingCenterRequest;
use App\Http\Requests\UpdateTraininingCenterRequest;
use App\Models\CindicationRoom;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingSession;
use App\Models\Zone;
use App\Models\Region;
use App\Models\Schedule;
use App\Models\Training;
use App\Models\TrainingCenterBasedPermission;
use App\Models\TrainingSchedule;
use App\Models\TrainingSessionTraining;
use App\Models\User;
use App\Models\UserAttendance;
use App\Models\Volunteer;
use Database\Seeders\UserAttendanceSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \Maatwebsite\Excel\Facades\Excel;

class TraininingCenterController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(TraininingCenter::class, 'TraininingCenter');
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

        return view("training_center.create", ['zones' => Zone::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTraininingCenterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTraininingCenterRequest $request)
    {


        $request->validate([
            'logo' => 'image|mimes:jpg,png,jpeg,svg|max:2048|',
            'name' => 'min:2|required|string|unique:trainining_centers,name',
            'code' => 'required|string|unique:trainining_centers,code',
        ]);
        $logoFile = FileController::fileUpload($request->logo, 'training center logos/')->id;
        $TrainingCenter = TraininingCenter::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'logo' => $logoFile, 'zone_id' => $request->get('zone_id')]);

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
        $traininingCenter = TraininingCenter::with('capacities.trainningSession')->find($traininingCenter);
        $trainingSession = new TrainingSession();
        $trainingSessionId = $trainingSession->availableSession()->first()->id;

        $capaityAddedInCenter = TrainingCenterCapacity::where('training_session_id', $trainingSessionId)->where('trainining_center_id', $traininingCenter->id)->get();
        // dd($capaityAddedInCenter);

        return view('training_center.show', ['trainingCenter' => $traininingCenter, 'capaityAddedInCenter' => $capaityAddedInCenter, 'users' => User::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function edit($TrainingCenter)

    {

        return view('training_center.create', ['trainingCenter' => TraininingCenter::findOrFail($TrainingCenter), 'zones' => Zone::all()]);
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
        $TrainingCenter = TraininingCenter::findOrFail($traininingCenter);
        $trainingSession = new TrainingSession();
        $trainingSessionId = $trainingSession->availableSession()[0]->id;
        TrainingCenterCapacity::create(['capacity' => $request->get('capacity'), 'training_session_id' => $trainingSessionId, 'trainining_center_id' => $TrainingCenter->id]);

        $data = $request->validate([
            'logo' => 'image|mimes:jpg,png,jpeg,svg|max:2048|',
            'name' => 'min:2|required|string|unique:trainining_centers,name,' . $traininingCenter,
            'code' => 'required|string|unique:trainining_centers,code,' . $traininingCenter
        ]);

        $TrainingCenter->update($data);
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
        $traininingCenter->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
    public function assignChecker(Request $request, TrainingSession $trainingSession, TraininingCenter $trainingCenter)
    {
        $data = $request->validate(['checkerUser' => 'required']);
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
        return view('training_center.check_in.check_in');
    }
    public function result(Request $request)
    {
        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            // ->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter','id',Auth::user()->trainingCheckerOf->id);
            $volunteerQuery = Volunteer::with('woreda.zone.region')->where('id', $query);


            if (count($volunteerQuery->get()) > 0) {
                $data = $volunteerQuery->whereRelation('status', 'acceptance_status', 4)->first();
                $accepted = $volunteerQuery->whereRelation('status', 'acceptance_status', 5)->first();

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
    public function checkIn($training_session, $id)
    {
        Volunteer::find($id)->status->update(['acceptance_status' => 5]);
        return redirect()->back()->with('message', 'Volunteer Sucessfuily Checked-In');
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

        $volunteers = Volunteer::whereRelation('status', 'acceptance_status', 5)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $training_center_id);
        $id = $request->get('id');
        $gender = $request->get('gender');
        if ($request->has('filter')) {
            // dd($id);
            if (!empty($id)) {
                $volunteers = $volunteers->where('id', $id);
            }
            if (!empty($gender)) {
                $volunteers = $volunteers->where('gender', '=', $gender);
            }
        }

        return view('training_center.assign_resource', ['volunteers' => $volunteers->paginate(10), 'training_center_id' => $training_center_id]);
    }
    public function giveResourceDetail(Request $request, $training_session, $training_center_id, $volunter)
    {
        $training_center = TraininingCenter::with('resources')->find($training_center_id);
        return view('training_center.assign_resource_voluteer', ['training_center' => $training_center, 'volunteer' => Volunteer::find($volunter)]);
    }
    public function storeResourceToVolunteer($training_session, $training_center_id, $volunter, $resourceId)
    {
        $training_center = TraininingCenter::with('resources')->find($training_center_id);
        return view('training_center.assign_resource_voluteer', ['training_center' => $training_center, 'volunteer' => Volunteer::find($volunter)]);
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

    public function get_attendance_data()
    {
        dd(DB::table('user_attendances')->leftJoin('users', 'user_attendances.user_id','=', 'users.id')
        ->select('first_name')->get());
        return Excel::download(new UsersExport( DB::table('user_attendances')->select('user_id')->get(),['User_ID', 'Status']), 'attendance.xlsx');
        // return Excel::download(new UserAttendance(), 'attendance.xlsx');
    }

    public function placeVolunteers(TrainingSession $trainingSession, TraininingCenter $trainingCenter)
    {
        $volunteerGroups = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainingCenter->id)->get()->groupBy('woreda.zone.region.id');
        // foreach($volunteerGroups as $volunteerGroup){
        //     foreach($volunteerGroup as $volunter){
        //         dump($volunter->woreda->zone->region->name);
        //         dump($volunter->name());
        //     }
        // }
        // dd('sd');
        $regionIds = array_keys($volunteerGroups->toArray());
        $x = [];
        $cindicationRooms = CindicationRoom::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->get();
        foreach ($cindicationRooms as $cindicationRoom) {
            $capacity = $cindicationRoom->number_of_volunteers;
            $round = 0;
            for($a = 0;$a<$capacity;$a++){
                if($round>=count($volunteerGroups)){
                    $round = 0;
                }
                $group = $volunteerGroups[$regionIds[$round]];
                $volunteer = $group[count($group)-1];
                $volunteer->update([
                    'cindication_room_id' => $cindicationRoom,
                ]);
                $volunteer->save();
                $volunteerGroups[$regionIds[$round]]->pop();
                $round++;
            }
        }
        return redirect()->back()->with('message','Volunteer placment finnished');
    }
}
