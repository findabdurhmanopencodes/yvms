<?php

namespace App\Http\Controllers;

use App\Models\Qouta;
use App\Http\Requests\StoreQoutaRequest;
use App\Http\Requests\UpdateQoutaRequest;

class QoutaController extends Controller
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
     * @param  \App\Http\Requests\StoreQoutaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreQoutaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Http\Response
     */
    public function show(Qouta $qouta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Http\Response
     */
    public function edit(Qouta $qouta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateQoutaRequest  $request
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateQoutaRequest $request, Qouta $qouta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Qouta  $qouta
     * @return \Illuminate\Http\Response
     */
    public function destroy(Qouta $qouta)
    {
        //
    }
}
