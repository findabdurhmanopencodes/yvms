<?php

namespace App\Http\Controllers;

use App\Models\UserRegion;
use App\Http\Requests\StoreUserRegionRequest;
use App\Http\Requests\UpdateUserRegionRequest;

class UserRegionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(UserRegion::class,'userRegion');
    }
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
     * @param  \App\Http\Requests\StoreUserRegionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRegionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserRegion  $userRegion
     * @return \Illuminate\Http\Response
     */
    public function show(UserRegion $userRegion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserRegion  $userRegion
     * @return \Illuminate\Http\Response
     */
    public function edit(UserRegion $userRegion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRegionRequest  $request
     * @param  \App\Models\UserRegion  $userRegion
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRegionRequest $request, UserRegion $userRegion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserRegion  $userRegion
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserRegion $userRegion)
    {
        //
    }
}
