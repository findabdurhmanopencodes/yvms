<?php

namespace App\Http\Controllers;

use App\Models\TrainingPlacement;
use App\Http\Requests\StoreTrainingPlacementRequest;
use App\Http\Requests\UpdateTrainingPlacementRequest;
use App\Models\Region;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\Woreda;
use Illuminate\Support\Collection;

class TrainingPlacementController extends Controller
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
     * @param  \App\Http\Requests\StoreTrainingPlacementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingPlacementRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingPlacement  $trainingPlacement
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingPlacement $trainingPlacement)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingPlacement  $trainingPlacement
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingPlacement $trainingPlacement)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingPlacementRequest  $request
     * @param  \App\Models\TrainingPlacement  $trainingPlacement
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingPlacementRequest $request, TrainingPlacement $trainingPlacement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingPlacement  $trainingPlacement
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingPlacement $trainingPlacement)
    {
        //
    }
}
