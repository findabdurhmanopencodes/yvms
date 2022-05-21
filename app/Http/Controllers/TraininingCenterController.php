<?php

namespace App\Http\Controllers;

use App\Models\TraininingCenter;
use App\Http\Requests\StoreTraininingCenterRequest;
use App\Http\Requests\UpdateTraininingCenterRequest;
use App\Models\TrainingCenterCapacity;
use App\Models\TrainingSession;
use App\Models\Zone;
use App\Models\Region;
use App\Models\TrainingCenterBasedPermission;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

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
        // dd('d');
        return view('training_center.check_in.check_in');
    }
    public function result(Request $request)
    {

        if ($request->ajax()) {
            $output = '';
            $query = $request->get('query');
            // ->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter','id',Auth::user()->trainingCheckerOf->id);
            $volunteerQuery = Volunteer::with('woreda.zone.region')->where('id', $query)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter','id',Auth::user()->trainingCheckerOf?->id);


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
    public function checkIn($training_session,$id)
    {
        Volunteer::find($id)->status->update(['acceptance_status' => 5]);
        return redirect()->back()->with('message', 'Volunteer Sucessfuily Checked-In');
    }
    public function indexChecking($training_session,Request $request)
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
    public function giveResource($training_session,$training_center_id)
    {
        $volunteers=Volunteer::whereRelation('status','acceptance_status',5)->whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter','id',$training_center_id)->get();
        dd($volunteers);
        return view('training_center.assign_resource', ['volunteersChecked']);
    }
}
