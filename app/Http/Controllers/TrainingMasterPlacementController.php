<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingMasterPlacementRequest;
use App\Http\Requests\UpdateTrainingMasterPlacementRequest;
use App\Models\CindicationRoom;
use App\Models\Training;
use App\Models\TrainingMaster;
use App\Models\TrainingMasterPlacement;
use App\Models\TrainingSession;
use App\Models\TrainingSessionTraining;
use App\Models\TraininingCenter;
use Illuminate\Validation\ValidationException;

class TrainingMasterPlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TrainingSession $trainingSession)
    {
        $trainingMasterPlacementQuery = TrainingMasterPlacement::where('training_session_id', $trainingSession->id);
        // $freeTrainners = TrainingMaster::select()->whereNotIn('id',$trainingMasterPlacementQuery->pluck('training_master_id'))->get();
        $freeTrainners = TrainingMaster::all();
        $trainingCenters = TraininingCenter::all();
        $trainingMasterPlacements = $trainingMasterPlacementQuery->get();
        $trainings = Training::whereIn('id', TrainingSessionTraining::where('training_session_id', $trainingSession->id)->pluck('id'))->get();
        return view('training_session.trainners', compact('trainings', 'trainingSession', 'trainingMasterPlacements', 'freeTrainners', 'trainingCenters'));
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
     * @param  \App\Http\Requests\StoreTrainingMasterPlacementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingMasterPlacementRequest $request, TrainingSession $trainingSession)
    {
        $data = $request->validated();
        $trainingCenter = $data['training_center'];
        $trainner = $data['trainner'];
        $cindicationRoom = $data['cindication_room'];
        $training = $data['training'];

        $trainingMasterPlacement = TrainingMasterPlacement::where('training_session_id', $trainingCenter)->where('cindication_room_id', $cindicationRoom)->where('training_id', $training)->first();
        if ($trainingMasterPlacement) {
            throw ValidationException::withMessages(['training' => 'Please two trainners can\'t give the same training']);
        }
        $trainingMasterPlacement = TrainingMasterPlacement::where('training_master_id', $trainner)->where('cindication_room_id', '!=', $cindicationRoom)->first();
        if ($trainingMasterPlacement) {
            throw ValidationException::withMessages(['trainner' => 'Trainner can\'t give two different centers']);
        }
        TrainingMasterPlacement::create([
            'training_session_id' => $trainingSession->id,
            'trainining_center_id' => $data['training_center'],
            'training_master_id' => $data['trainner'],
            'training_id' => $data['training'],
            'cindication_room_id' => $cindicationRoom,
        ]);
        return redirect()->back()->with('message', 'Training master assigned successfully    ');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingMasterPlacement  $trainingMasterPlacement
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingMasterPlacement $trainingMasterPlacement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingMasterPlacement  $trainingMasterPlacement
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingMasterPlacement $trainingMasterPlacement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingMasterPlacementRequest  $request
     * @param  \App\Models\TrainingMasterPlacement  $trainingMasterPlacement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingMasterPlacementRequest $request, TrainingMasterPlacement $trainingMasterPlacement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingMasterPlacement  $trainingMasterPlacement
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSession $trainingSession, TrainingMasterPlacement $trainingMasterPlacement)
    {
        $trainingMasterPlacement->delete();
        return redirect()->back()->with('message', 'Training master removed');
    }
}
