<?php

namespace App\Http\Controllers;

use App\Models\TrainingCenterCapacity;
use App\Http\Requests\StoreTrainingCenterCapacityRequest;
use App\Http\Requests\UpdateTrainingCenterCapacityRequest;

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
    public function store(StoreTrainingCenterCapacityRequest $request)
    {
        //
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
}
