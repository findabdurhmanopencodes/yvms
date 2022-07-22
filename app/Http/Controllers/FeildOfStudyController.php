<?php

namespace App\Http\Controllers;

use App\Models\FeildOfStudy;
use App\Http\Requests\StoreFeildOfStudyRequest;
use App\Http\Requests\UpdateFeildOfStudyRequest;
// use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if (!Auth::user()->can('FeildOfStudy.index')) {

            return abort(403);
        }
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
        if (!Auth::user()->can('FeildOfStudy.store')) {

            return abort(403);
        }
        return view('fieldofstudy.create');
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFeildOfStudyRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!Auth::user()->can('FeildOfStudy.store')) {

            return abort(403);
        }

        $request->validate(['name' => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:feild_of_studies,name']);
        FeildOfStudy::create(['name' => $request->get('name')]);
        return redirect()->route('FeildOfStudy.index')->with('message', 'Feild of Study created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FeildOfStudy  $feildOfStudy
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if (!Auth::user()->can('FeildOfStudy.show')) {

            return abort(403);
        }
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
    public function edit($feildOfStudy)
    {
        if (!Auth::user()->can('FeildOfStudy.update')) {

            return abort(403);
        }

        return view('fieldofstudy.create',['feildOfStudy'=>FeildOfStudy::find($feildOfStudy)]);
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFeildOfStudyRequest  $request
     * @param  \App\Models\FeildOfStudy  $feildOfStudy
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$FeildOfStudy)
    {
        if (!Auth::user()->can('FeildOfStudy.update')) {

            return abort(403);
        }

        $FeildOfStudyInfo=FeildOfStudy::find($request->get('id'));
        $data = $request->validate(['name' => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:feild_of_studies,name,'.$FeildOfStudyInfo->id]);
        $FeildOfStudyInfo->update(['name'=>$data['name']]);
        return redirect()->route('FeildOfStudy.index')->with('message', 'feild Of Study Updated successfully');
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
        if (!Auth::user()->can('FeildOfStudy.destroy')) {

            return abort(403);
        }

        $feildOfStudy->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
