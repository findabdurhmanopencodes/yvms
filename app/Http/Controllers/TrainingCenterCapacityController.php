<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenterCapacity;
use App\Http\Requests\StoreTrainingCenterCapacityRequest;
use App\Http\Requests\UpdateTrainingCenterCapacityRequest;
use App\Models\TrainingSession;
use Illuminate\Http\Request;

class TrainingCenterCapacityController extends Controller
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
     * @param  \App\Http\Requests\StoreTrainingCenterCapacityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $trainingSession = new TrainingSession();

        $trainingSessionId = $trainingSession->availableSession()->first()->id;
        TrainingCenterCapacity::create(['capacity' => $request->get('capacity'), 'training_session_id' => $trainingSessionId, 'trainining_center_id' => $request->get('trainingCenterId')]);
        return redirect()->back();



    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingCenterCapacity $trainingCenterCapacity)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingCenterCapacity $trainingCenterCapacity)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingCenterCapacityRequest  $request
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingCenterCapacityRequest $request, TrainingCenterCapacity $trainingCenterCapacity)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingCenterCapacity  $trainingCenterCapacity
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingCenterCapacity $trainingCenterCapacity)
    {
        //
    }

    public function capacityChange(Request $request)
    {
        $trainingCenterId=$request->get('trainining_center_id');
        $trainingSessionId=$request->get('training_session_id');
        $trainingCenterCapacity=TrainingCenterCapacity::where('trainining_center_id',$trainingCenterId)->where('training_session_id',$trainingSessionId)->get()->first();
        $trainingCenterCapacity->update(['capacity'=>$request->get('capacity')]);
        $trainingCenterCapacity->save();
        return redirect()->back();
    }
}
