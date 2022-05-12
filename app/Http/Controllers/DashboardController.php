<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\TraininingCenter;
use App\Models\Region;
use App\Models\Volunteer;
use App\Models\Zone;
use App\Models\Woreda;
use App\Models\Volunteers;
use Illuminate\Support\Facades\DB;




class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $users = Volunteer::whereRelation('status','acceptance_status',2)->get()->count();

       $regions = DB::table('regions')->count();
       $zones = DB::table('zones')->count();
       $woredas= DB::table('woredas')->count();
       $volunteers = DB::table('volunteers')->count();
       $traininingCenters = DB::table('trainining_centers')->count();

        return view('dashboard', compact('users','regions','zones','woredas','volunteers','traininingCenters'));
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
