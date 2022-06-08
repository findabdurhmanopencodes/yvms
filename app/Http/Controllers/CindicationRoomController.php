<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCindicationRoomRequest;
use App\Http\Requests\UpdateCindicationRoomRequest;
use App\Models\CindicationRoom;
use App\Models\Training;
use App\Models\TrainingCenterBasedPermission;
use App\Models\TrainingMaster;
use App\Models\TrainingSchedule;
use App\Models\TrainingSession;
use App\Models\TrainingSessionTraining;
use App\Models\TraininingCenter;
use App\Models\User;
use App\Models\UserAttendance;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class CindicationRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreCindicationRoomRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCindicationRoomRequest $request, TrainingSession $trainingSession, TraininingCenter $trainingCenter)
    {
        $data = $request->validated();
        $data['trainining_center_id'] = $trainingCenter->id;
        $data['training_session_id'] = $trainingSession->id;
        CindicationRoom::create($data);
        return redirect()->back()->with('message', 'Cindication room created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CindicationRoom  $cindicationRoom
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSession $trainingSession, TraininingCenter $trainingCenter, CindicationRoom $cindicationRoom)
    {
        $checkerPermission = Permission::findOrCreate('checker');
        $coFacilitatorPermission = Permission::findOrCreate('coFacilitator');

        $trainings = Training::whereIn('id', TrainingSessionTraining::where('training_session_id', $trainingSession->id)->pluck('id'))->get();

        $coFacilitatorQuery = User::whereIn('id', TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->where('permission_id', $coFacilitatorPermission->id)->where('cindication_room_id', $cindicationRoom->id)->pluck('user_id'));
        $coFacilitators = $coFacilitatorQuery->get();
        $coFacilitatorUsers = User::doesntHave('volunteer')->doesntHave('trainner')->permission($coFacilitatorPermission->id)->whereNotIn('id', $coFacilitatorQuery->pluck('id'))->get();
        $freeTrainners = TrainingMaster::all();
        return view('room.show', compact('trainingSession', 'coFacilitators', 'coFacilitatorPermission', 'coFacilitatorUsers', 'freeTrainners', 'trainingCenter', 'cindicationRoom', 'trainings'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CindicationRoom  $cindicationRoom
     * @return \Illuminate\Http\Response
     */
    public function edit(CindicationRoom $cindicationRoom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCindicationRoomRequest  $request
     * @param  \App\Models\CindicationRoom  $cindicationRoom
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCindicationRoomRequest $request, CindicationRoom $cindicationRoom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CindicationRoom  $cindicationRoom
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSession $trainingSession, TraininingCenter $trainingCenter, CindicationRoom $cindicationRoom)
    {
        $cindicationRoom->delete();
        return redirect()->back()->with('message', 'Cindication room removed successfully');
    }

    public function volunteers(TrainingSession $trainingSession, TraininingCenter $trainingCenter, CindicationRoom $cindicationRoom, Training $training)
    {
        // $applicants = Volunteer::whereRelation('approvedApplicant.trainingPlacement.trainingCenterCapacity.trainingCenter', 'id', $trainingSession->id)->where('cindication_room_id', $cindicationRoom->id)->paginate(10);
        $applicants = $cindicationRoom->volunteers()->paginate(10);
        $att_history = [];
        foreach (UserAttendance::all() as $key => $value) {
            array_push($att_history, $value->training_schedule_id . ',' . User::where('id', $value->user_id)->get()->first()->volunteer->id);
        }
        $trainingSchedules = TrainingSchedule::whereIn('training_session_training_id', TrainingSessionTraining::where('training_session_id', $trainingSession->id)->where('training_id', $training->id)->pluck('id'))->get();
        return view('training_center.training_center_attendance', compact('trainingSession', 'trainingCenter', 'training', 'applicants', 'trainingSchedules', 'att_history'));
    }
}
