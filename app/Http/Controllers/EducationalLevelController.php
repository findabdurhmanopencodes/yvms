<?php

namespace App\Http\Controllers;

use App\Models\EducationalLevel;
use App\Http\Requests\StoreEducationalLevelRequest;
use App\Http\Requests\UpdateEducationalLevelRequest;
use Illuminate\Http\Request;

class EducationalLevelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // if(!Auth::user()->can('educationalLevel.index')){
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
        // creating eduycational level setting
        return view('educationalLevel.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEducationalLevelRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEducationalLevelRequest $request)
    {
        $request->validate(['name' => 'required|string|unique:educational_levels,name']);
        EducationalLevel::create(['name' => $request->get('name')]);
        return redirect()->route('educational_level.index')->with('message', 'Educational Level created successfully');
    }
    
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationalLevel  $educationalLevel
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        return view('educationalLevel.show', [
            'EducationalLevel' =>EducationalLevel::findOrFail($id)
        ]);
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
        return view('educationalLevel.edit',compact('educational_levels'));
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

        $data = $request->validate(['name' => 'required|string|unique:educational_levels,name,'.$educationalLevel->id]);
        $educationalLevel->update($data);
        return redirect()->route('educational_level.index')->with('message', 'Educational level updated successfully');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationalLevel  $educationalLevel
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationalLevel $educationalLevel, Request $request)
    {
        $educationalLevel->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
