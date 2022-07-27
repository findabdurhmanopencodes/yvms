<?php

namespace App\Http\Controllers;

use App\Models\SessionZone;
use App\Http\Requests\StoreSessionZoneRequest;
use App\Http\Requests\UpdateSessionZoneRequest;

class SessionZoneController extends Controller
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
     * @param  \App\Http\Requests\StoreSessionZoneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSessionZoneRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SessionZone  $sessionZone
     * @return \Illuminate\Http\Response
     */
    public function show(SessionZone $sessionZone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SessionZone  $sessionZone
     * @return \Illuminate\Http\Response
     */
    public function edit(SessionZone $sessionZone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateSessionZoneRequest  $request
     * @param  \App\Models\SessionZone  $sessionZone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSessionZoneRequest $request, SessionZone $sessionZone)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SessionZone  $sessionZone
     * @return \Illuminate\Http\Response
     */
    public function destroy(SessionZone $sessionZone)
    {
        //
    }
}
