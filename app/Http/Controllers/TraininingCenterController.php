<?php

namespace App\Http\Controllers;

use App\Models\TraininingCenter;
use App\Http\Requests\StoreTraininingCenterRequest;
use App\Http\Requests\UpdateTraininingCenterRequest;

class TraininingCenterController extends Controller
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
     * @param  \App\Http\Requests\StoreTraininingCenterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTraininingCenterRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function show(TraininingCenter $traininingCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function edit(TraininingCenter $traininingCenter)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTraininingCenterRequest  $request
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTraininingCenterRequest $request, TraininingCenter $traininingCenter)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(TraininingCenter $traininingCenter)
    {
        //
    }
}
