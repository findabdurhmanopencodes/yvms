<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Region::select())->make(true);
        }

        $regions = Region::all();
        return view('region.index', compact('regions'));
    }

    public function place(Request $request)
    {
      
        $regions = Region::all();
        return view('region.placement', compact('regions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('region.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRegionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRegionRequest $request)
    {
        $regionInquota = $request->get('region_quota')/100;
        $request->validate(['name' => 'required|string|unique:permissions,name', 'code' => 'required|string|unique:permissions,name']);
        Region::create(['name' => $request->get('name'), 'code'=>$request->get('code'), 'qoutaInpercent'=> $regionInquota]);
        return redirect()->route('region.index')->with('message', 'Region created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function show(Region $region)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $regions = Region::find($id);
        return view('region.edit', compact('regions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRegionRequest  $request
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRegionRequest $request, $id)
    {
        $region = Region::find($id);
        $region->name = $request->get('name');
        $region->code = $request->get('code');
        $region->qoutaInpercent = $request->get('qoutaInpercent')/100;
        $region->save();
        return redirect()->route('region.index')->with('message', 'Region edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Region  $region
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Region $region)
    {
        foreach ($region->zones as $zone) {
            $zone->delete();
        }
        $region->delete();
        // if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'));
        // }
    }
}
