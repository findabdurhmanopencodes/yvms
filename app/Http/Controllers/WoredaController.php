<?php

namespace App\Http\Controllers;

use App\Models\Woreda;
use App\Http\Requests\StoreWoredaRequest;
use App\Http\Requests\UpdateWoredaRequest;
use App\Models\Zone;
use Illuminate\Http\Request;

class WoredaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Woreda::select())->make(true);
        }
        // $user = Auth::user();
        // if(!$user->hasRole('super-admin') && !$user->hasPermissionTo('role.viewAll')){
        //     abort(403);
        // }
        $woredas = Woreda::all();
        $zones = Zone::all();
        return view('woreda.index', compact(['zones', 'woredas']));
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
        // $woreda = new Woreda();
        $request->validate(['name' => 'required|string|unique:woredas,name', 'code' => 'required|string|unique:woredas,code']);
        // $zone->name = $request->get('name');
        // $zone->code = $request->get('code');
        // $zone->region_id = $request->get('region');
        // $zone->save();
        Woreda::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'zone_id' => $request->get('woreda')]);
        return redirect()->route('woreda.index')->with('message', 'Woreda created successfully');
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
