<?php

namespace App\Http\Controllers;

use App\Models\EducationalLevel;
use App\Http\Requests\StoreEducationalLevelRequest;
use App\Http\Requests\UpdateEducationalLevelRequest;

class EducationalLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(!Auth::user()->can('.index')){
        //     return abort(403);
        // }
        $educational_levels = EducationalLevel::paginate(10);
        return view('educationalLevel.index', compact('educational_levels'));
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
     * @param  \App\Http\Requests\StoreEducationalLevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEducationalLevelRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationalLevel  $educationalLevel
     * @return \Illuminate\Http\Response
     */
    public function show(EducationalLevel $educationalLevel)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\EducationalLevel  $educationalLevel
     * @return \Illuminate\Http\Response
     */
    public function edit(EducationalLevel $educationalLevel)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEducationalLevelRequest  $request
     * @param  \App\Models\EducationalLevel  $educationalLevel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEducationalLevelRequest $request, EducationalLevel $educationalLevel)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationalLevel  $educationalLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationalLevel $educationalLevel)
    {
        //
    }
}
