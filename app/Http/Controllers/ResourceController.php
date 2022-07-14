<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\TraininingCenter;
use Illuminate\Http\Request;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Resource::select())->make(true);
        }
        $roles = Resource::all();
        return view('resource.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('resource.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreResourceRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate(['name' => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:resources,name']);
        Resource::create(['name' => $request->get('name')]);
        return redirect()->route('resource.index')->with('message', 'Resource created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function show(Resource $resource)
    {

        return view('resource.show',['resource'=>$resource,'trainingCenters'=>TraininingCenter::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        //
        return view('resource.create', compact('resource'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateResourceRequest  $request
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Resource $resource)
    {
        $data = $request->validate(['name' => 'required|regex:/^[a-zA-Z]+$/u|max:255|unique:resources,name,' . $resource->id]);
        $resource->update($data);
        return redirect()->route('resource.index')->with('message', 'resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request ,Resource $resource)
    {

        $resource->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }

}
