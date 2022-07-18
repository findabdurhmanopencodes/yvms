<?php

namespace App\Http\Controllers;

use App\Models\FeildOfStudy;
use App\Http\Requests\StoreFeildOfStudyRequest;
use App\Http\Requests\UpdateFeildOfStudyRequest;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;

class FeildOfStudyController extends Controller
{
    public function __construct()
    {

        // $this->authorizeResource(FeildOfStudy::class,'feildOfStudy');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(FeildOfStudy::select())->make(true);
        }

        $feildOfStudy = FeildOfStudy::all();
        return view('fieldofstudy.index', compact('feildOfStudy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('fieldofstudy.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFeildOfStudyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeildOfStudyRequest $request)
    {

        $request->validate(['name' => 'required|string|unique:feild_of_studies,name']);
        FeildOfStudy::create(['name' => $request->get('name')]);
        return redirect()->route('feild_of_study.index')->with('message', 'Feild of Study created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FeildOfStudy  $feildOfStudy
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        return view('fieldofstudy.show', [
            'FeildOfStudy' => FeildOfStudy::findOrFail($id)
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FeildOfStudy  $feildOfStudy
     * @return \Illuminate\Http\Response
     */
    public function edit(FeildOfStudy $feildOfStudy)
    {
        return view('fieldofstudy.edit',compact('feild_of_studies'));
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFeildOfStudyRequest  $request
     * @param  \App\Models\FeildOfStudy  $feildOfStudy
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeildOfStudyRequest $request, FeildOfStudy $feildOfStudy)
    {

        $data = $request->validate(['name' => 'required|string|unique:feildOfStudy,name,'.$feildOfStudy->id]);
        $feildOfStudy->update($data);
        return redirect()->route('feild_of_study.index')->with('message', 'feild Of Study created successfully');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FeildOfStudy  $feildOfStudy
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,FeildOfStudy $feildOfStudy)
    {
        $feildOfStudy->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
