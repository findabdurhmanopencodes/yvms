<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingMasterPlacementRequest;
use App\Http\Requests\UpdateTrainingMasterPlacementRequest;
use App\Models\TrainingMaster;
use App\Models\TrainingMasterPlacement;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;

class TrainingMasterPlacementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TrainingSession $trainingSession)
    {
        $trainingMasterPlacementQuery = TrainingMasterPlacement::where('training_session_id',$trainingSession->id);
        $freeTrainners = TrainingMaster::select()->whereNotIn('id',$trainingMasterPlacementQuery->pluck('training_master_id'))->get();
        $trainingCenters = TraininingCenter::all();
        $trainingMasterPlacements = $trainingMasterPlacementQuery->get();
        return view('training_session.trainners', compact('trainingSession','trainingMasterPlacements','freeTrainners','trainingCenters'));
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
    public function store(StoreTrainingMasterPlacementRequest $request,TrainingSession $trainingSession)
    {
        $data = $request->validated();
        TrainingMasterPlacement::create([
            'training_session_id' => $trainingSession->id,
            'trainining_center_id' => $data['training_center'],
            'training_master_id' => $data['trainner'],
        ]);
        return redirect()->back()->with('message','Training master assigned successfully    ');
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
    public function destroy(TrainingSession $trainingSession,TrainingMasterPlacement $trainingMasterPlacement)
    {
        $trainingMasterPlacement->delete();
        return redirect()->back()->with('message','Training master removed');
    }
}
