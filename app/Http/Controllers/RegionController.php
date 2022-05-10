<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Models\Zone;
use App\Http\Requests\StoreRegionRequest;
use App\Http\Requests\UpdateRegionRequest;
use App\Models\Woreda;
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
        Region::create(['name' => $request->get('name'), 'code'=>$request->get('code'), 'qoutaInpercent'=> $regionInquota, 'status'=>1]);
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
        if ($request->get('status')) {
            if ($request->get('status') == 'on') {
                $region->status = 1;
            }else{
                $region->status = 0;
                foreach ($region->zones as $key => $zon) {
                    $zone = Zone::find($zon->id);
                    $zone->status = 0;
                    $zone->save();
                    foreach ($zon->woredas as $key => $wor) {
                        $woreda = Woreda::find($wor->id);
                        $woreda->status = 0;
                        $woreda->save();
                    }
                }
            }
        }else{
            $region->status = 0;
            foreach ($region->zones as $key => $zon) {
                $zone = Zone::find($zon->id);
                $zone->status = 0;
                $zone->save();
                foreach ($zon->woredas as $key => $wor) {
                    $woreda = Woreda::find($wor->id);
                    $woreda->status = 0;
                    $woreda->save();
                }
            }
        }
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

    public function validateForm(Region $region, Request $request){
        $limit = false;
        $reg = $region::all();
        $sum = $request->qouta/100;
        foreach ($reg as $key => $value) {
            $sum+=$value->qoutaInpercent;
        }

        if ($sum <= 1) {
            $limit = true;
        }

        return response()->json(['limit'=>$limit]);
    }
}
