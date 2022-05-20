<?php

namespace App\Http\Controllers;

use App\Models\TrainingSchedule;
use App\Http\Requests\StoreTrainingScheduleRequest;
use App\Http\Requests\UpdateTrainingScheduleRequest;
use App\Models\TrainingSession;

class TrainingScheduleController extends Controller
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
     * @param  \App\Http\Requests\StoreTrainingScheduleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingScheduleRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingSchedule  $trainingSchedule
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingSchedule $trainingSchedule)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingSchedule  $trainingSchedule
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingSchedule $trainingSchedule)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingScheduleRequest  $request
     * @param  \App\Models\TrainingSchedule  $trainingSchedule
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingScheduleRequest $request, TrainingSchedule $trainingSchedule)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingSchedule  $trainingSchedule
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingSession $trainingSession,TrainingSchedule $trainingSchedule)
    {
        $trainingSchedule->delete();
        return redirect()->back()->with('message','Training schedule deleted successfully');
    }
}
