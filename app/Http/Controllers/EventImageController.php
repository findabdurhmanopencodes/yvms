<?php

namespace App\Http\Controllers;

use App\Models\EventImage;
use App\Http\Requests\StoreEventImageRequest;
use App\Http\Requests\UpdateEventImageRequest;

class EventImageController extends Controller
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
     * @param  \App\Http\Requests\StoreEventImageRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEventImageRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function show(EventImage $eventImage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function edit(EventImage $eventImage)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEventImageRequest  $request
     * @param  \App\Models\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEventImageRequest $request, EventImage $eventImage)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EventImage  $eventImage
     * @return \Illuminate\Http\Response
     */
    public function destroy(EventImage $eventImage)
    {
        //
    }
}
