<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCindicationRoomRequest;
use App\Http\Requests\UpdateCindicationRoomRequest;
use App\Models\CindicationRoom;

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
    public function store(StoreCindicationRoomRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\CindicationRoom  $cindicationRoom
     * @return \Illuminate\Http\Response
     */
    public function show(CindicationRoom $cindicationRoom)
    {
        //
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
    public function destroy(CindicationRoom $cindicationRoom)
    {
        //
    }
}
