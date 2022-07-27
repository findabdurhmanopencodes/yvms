<?php

namespace App\Http\Controllers;

use App\Models\Disablity;
use App\Http\Requests\StoreDisablityRequest;
use App\Http\Requests\UpdateDisablityRequest;
use Illuminate\Http\Request;

class DisablityController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(Disablity::class,'disablity');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Disablity::select())->make(true);
        }

        $disablities = Disablity::all();
        return view('disablity.index', compact('disablities'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('disablity.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreDisablityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDisablityRequest $request)
    {
        $request->validate(['name' => 'required|string|unique:disablities,name']);
        Disablity::create(['name' => $request->get('name')]);
        return redirect()->route('disablity.index')->with('message', 'Disablity type created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('disablity.show', [
            'Disablity' => Disablity::findOrFail($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Http\Response
     */
    public function edit(Disablity $disablity)
    {
        return view('fieldofstudy.create',compact('disablities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDisablityRequest  $request
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDisablityRequest $request, Disablity $disablity)
    {
        $data = $request->validate(['name' => 'required|string|unique:disablities,name,'.$disablity->id]);
        $disablity->update($data);
        return redirect()->route('disablity.index')->with('message', 'Disablity created successfully');
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Disablity  $disablity
     * @return \Illuminate\Http\Response
     */
    public function destroy(Disablity $disablity, Request $request)
    {
        $disablity->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
