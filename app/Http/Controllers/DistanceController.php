<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistanceRequest;
use App\Http\Requests\UpdateDistanceRequest;
use App\Models\Distance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Files\Disk;

class DistanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Distance::select())->make(true);
        }

       $distances = Distance::all();
        return view('distance.index', compact('distances'));

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('distance.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDistanceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDistanceRequest $request)
    {
        Distance::create([

            'zone_id' => $request->get('zone'),
            'training_session_id'=>$request->get('center')]);

      return redirect()->route('distance.index')->with('message', 'Distance created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Distance  $distance
     * @return \Illuminate\Http\Response
     */
    public function show(Distance $distance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Distance  $distance
     * @return \Illuminate\Http\Response
     */
    public function edit(Distance $distance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDistanceRequest  $request
     * @param  \App\Models\Distance  $distance
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDistanceRequest $request, Distance $distance)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Distance  $distance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Distance $distance)
    {
        //
    }
}
