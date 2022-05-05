<?php

namespace App\Http\Controllers;

use App\Models\Woreda;
use App\Http\Requests\StoreWoredaRequest;
use App\Http\Requests\UpdateWoredaRequest;
use GuzzleHttp\Psr7\Request;

class WoredaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $woredas = Woreda::all();
        return view('woreda.index', compact('woredas'));
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
     * @param  \App\Http\Requests\StoreWoredaRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreWoredaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function show(Woreda $woreda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function edit(Woreda $woreda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateWoredaRequest  $request
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateWoredaRequest $request, Woreda $woreda)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Woreda  $woreda
     * @return \Illuminate\Http\Response
     */
    public function destroy(Woreda $woreda , Request $request)
    {
        $woreda->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
