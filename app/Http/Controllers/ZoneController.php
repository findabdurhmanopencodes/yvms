<?php

namespace App\Http\Controllers;

use App\Models\Zone;
use App\Http\Requests\StoreZoneRequest;
use App\Http\Requests\UpdateZoneRequest;
use App\Models\Region;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Region $region, Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Zone::select())->addColumn('region', function (Zone $zone){
                return $zone->region->name;
            })->make(true);
        }
        // $user = Auth::user();
        // if(!$user->hasRole('super-admin') && !$user->hasPermissionTo('role.viewAll')){
        //     abort(403);
        // }
        $zones = Zone::all();
        $regions = Region::all();
        return view('zone.index', compact(['zones', 'regions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Region $region)
    {
        $regions = $region::all();
        return view('zone.create', compact('regions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreZoneRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreZoneRequest $request)
    {
        $zoneInquota = $request->get('zone_quota')/100;
        $zone = new Zone();
        $request->validate(['name' => 'required|string|unique:zones,name', 'code' => 'required|string|unique:zones,code']);
        // $zone->name = $request->get('name');
        // $zone->code = $request->get('code');
        // $zone->region_id = $request->get('region');
        // $zone->save();
        Zone::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'region_id' => $request->get('region'), 'qoutaInpercent'=>$zoneInquota]);
        return redirect()->route('zone.index')->with('message', 'Zone created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $zone = Zone::find($id);
        // dd($zone->region->name);
        $regions = Region::where('id', '!=', $zone->region->id)->get();
        return view('zone.edit', compact(['zone', 'regions']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateZoneRequest  $request
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateZoneRequest $request, $id)
    {
        $zone = Zone::find($id);
        $zone->name = $request->get('name');
        $zone->code = $request->get('code');
        $zone->region_id = $request->get('region');
        $zone->save();
        return redirect()->route('zone.index')->with('message', 'Zone edited successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy(Zone $zone, Request $request)
    {
        foreach ($zone->woredas as $woreda) {
            $woreda->delete();
        }
        $zone->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
    public function fetch(Region $region)
    {
        return datatables()->of(Zone::select()->where('region_id','=',$region->id))->make(true);
    }
}
