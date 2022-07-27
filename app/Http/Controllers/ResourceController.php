<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use App\Http\Requests\StoreResourceRequest;
use App\Http\Requests\UpdateResourceRequest;
use App\Models\TraininingCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ResourceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!Auth::user()->can('Resource.index')) {

            return abort(403);
        }
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
        if (!Auth::user()->can('Resource.store')) {

            return abort(403);
        }
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
        if (!Auth::user()->can('Resource.store')) {

            return abort(403);
        }
        //
        $request->validate(['name' => 'required|regex:/^[a-z A-Z]+$/u|max:255|unique:resources,name']);
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
        if (!Auth::user()->can('Resource.show')) {

            return abort(403);
        }

        return view('resource.show', ['resource' => $resource, 'trainingCenters' => TraininingCenter::all()]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function edit(Resource $resource)
    {
        if (!Auth::user()->can('Resource.update')) {

            return abort(403);
        }
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
        if (!Auth::user()->can('Resource.update')) {

            return abort(403);
        }
        $data = $request->validate(['name' => 'required|regex:/^[a-z A-Z]+$/u|max:255|unique:resources,name,' . $resource->id]);
        $resource->update($data);
        return redirect()->route('resource.index')->with('message', 'resource updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Resource  $resource
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Resource $resource)
    {
        if (!Auth::user()->can('Resource.destroy')) {
            return abort(403);
        }
        $resource->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
