<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCindicationRoomRequest;
use App\Http\Requests\UpdateCindicationRoomRequest;
use App\Models\CindicationRoom;
use App\Models\Training;
use App\Models\TrainingCenterBasedPermission;
use App\Models\TrainingMaster;
use App\Models\TrainingSession;
use App\Models\TrainingSessionTraining;
use App\Models\TraininingCenter;
use App\Models\User;
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
        $coordinatorPermission = Permission::findOrCreate('centerCooridnator');

        $trainings = Training::whereIn('id', TrainingSessionTraining::where('training_session_id', $trainingSession->id)->pluck('id'))->get();


        /*
$centerCoordinatorQuery = User::whereIn('id', TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->where('permission_id', $coordinatorPermission->id)->pluck('user_id'));
        $centerCoordinatorUsers =  User::doesntHave('volunteer')->doesntHave('trainner')->permission($coordinatorPermission->id)->whereNotIn('id', $centerCoordinatorQuery->pluck('id'))->get();
        */
        $centerCoordinatorQuery = User::whereIn('id', TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('trainining_center_id', $trainingCenter->id)->where('permission_id', $coordinatorPermission->id)->pluck('user_id'));
        $centerCoordinators = $centerCoordinatorQuery->get();
        $freeTrainners = TrainingMaster::all();

        return view('room.show', compact('trainingSession','freeTrainners', 'trainingCenter', 'cindicationRoom', 'trainings' ));
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
}
