<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingMasterPlacementRequest;
use App\Http\Requests\UpdateTrainingMasterPlacementRequest;
use App\Models\TrainingMasterPlacement;

class TrainingMasterPlacementController extends Controller
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
     * @param  \App\Http\Requests\StoreTrainingMasterPlacementRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingMasterPlacementRequest $request)
    {
        //
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
    public function destroy(TrainingMasterPlacement $trainingMasterPlacement)
    {
        //
    }
}
