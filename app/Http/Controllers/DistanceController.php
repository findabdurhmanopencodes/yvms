<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDistanceRequest;
use App\Http\Requests\UpdateDistanceRequest;
use App\Models\Distance;
use App\Models\TraininingCenter;
use App\Models\TransportTarif;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

      // $price = TransportTarif::all()->sortByDesc('id')->take(1)->toArray();
       $price = DB::table('transport_tarifs')->orderBy('id', 'DESC')->first();
     //  dd($price);
       $distances = Distance::paginate(10);

       $training_centers = TraininingCenter::all();
       $zones = Zone::all();

        return view('distance.index', compact('distances','training_centers','zones', "price"));
        //return view::make('distance.index')->with('distances','training_centers','zones',  $price);

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

        if (Distance::where('zone_id',$request->get('zone'),'trainining_center_id',$request->get('training_center') )->count() > 0) { {
            return redirect()->route('distance.index')->with('message', 'The record al ready exist!');
        }

        Distance::create([
            'zone_id' => $request->get('zone'),
            'km' => $request->get('km'),
            'user_id'=>Auth::user()->id,
            'trainining_center_id'=>$request->get('training_center')
        ]);

      return redirect()->route('distance.index')->with('message', 'Distance created successfully');

    }
}

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Distance  $distance
     * @return \Illuminate\Http\Response
     */
    public function show(Distance $distance)
    {
        return view('distance.show', [
            'distance' => Distance::findOrFail($distance)
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Distance  $distance
     * @return \Illuminate\Http\Response
     */
    public function edit(Distance $distance)
    {
        return view('distance.edit',compact('distances'));
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

      //  $data = $request->validate(['name' => 'required|string|unique:educational_levels,name,'.$educationalLevel->id]);
         $distance->update();
      //  $distance->update($data);
        return redirect()->route('distance.index')->with('message', ' Updated successfully');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Distance  $distance
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Distance $distance)
    {
        $distance->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
