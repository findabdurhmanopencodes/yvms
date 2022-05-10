<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFeadbackRequest;
use App\Http\Requests\UpdateFeadbackRequest;
use App\Models\Feadback;
//use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request;

class FeadbackController extends Controller
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
        $feadbacks = Feadback::paginate(10);
        return view('feadback.index', compact('feadbacks'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
             // creating eduycational level setting
             return view('feadback.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreFeadbackRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreFeadbackRequest $request)
    {
        $request->validate(['name' => 'required|string|unique:feadbacks,msg']);
        Feadback::create(['name' => $request->get('name')]);
        return redirect()->route('feadback.index')->with('message', 'Feadback sent successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Feadback  $feadback
     * @return \Illuminate\Http\Response
     */
    public function show(Feadback $feadback)
    {
        return view('feadback.show', [
            'Feadback' =>Feadback::findOrFail($feadback)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Feadback  $feadback
     * @return \Illuminate\Http\Response
     */
    public function edit(Feadback $feadback)
    {
        return view('feadback.edit',compact('feadbacks'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateFeadbackRequest  $request
     * @param  \App\Models\Feadback  $feadback
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateFeadbackRequest $request, Feadback $feadback)
    {
        $data = $request->validate(['name' => 'required|string|unique:feadbacks,msg,'.$feadback->id]);
        $feadback->update($data);
        return redirect()->route('feadback.index')->with('message', 'Message updated successfully');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Feadback  $feadback
     * @return \Illuminate\Http\Response
     */
    public function destroy(Feadback $feadback, Request $request)
    {
        $feadback->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
