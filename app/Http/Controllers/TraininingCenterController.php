<?php

namespace App\Http\Controllers;

use App\Models\TraininingCenter;
use App\Http\Requests\StoreTraininingCenterRequest;
use App\Http\Requests\UpdateTraininingCenterRequest;
use App\Models\Zone;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class TraininingCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(TraininingCenter::select())->make(true);
        }
        // $user = Auth::user();
        // if(!$user->hasRole('super-admin') && !$user->hasPermissionTo('role.viewAll')){
        //     abort(403);
        // }
        return view('training_center.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("training_center.create",['zones'=>Zone::all()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTraininingCenterRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTraininingCenterRequest $request)
    {

        $request->validate([
            'logo' => 'image|mimes:jpg,png,jpeg,svg|max:2048|',
            'name' => 'min:2|required|string|unique:trainining_centers,name',
            'code' => 'required|string|unique:trainining_centers,code',
        ]);
        $path = $request->file('logo')->store('public/Training Centers');
        TraininingCenter::create(['name' => $request->get('name'), 'code' => $request->get('code'), 'logo' => $path,'zone_id'=>$request->get('zone_id')]);
        return redirect()->route('TrainingCenter.index')->with('message', 'Training Center created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function show(TraininingCenter $traininingCenter)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function edit($TrainingCenter)

    {

        return view('training_center.create', ['trainingCenter' => TraininingCenter::findOrFail($TrainingCenter)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTraininingCenterRequest  $request
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTraininingCenterRequest $request,  $traininingCenter)
    {
        $TrainingCenter=TraininingCenter::findOrFail($traininingCenter);

        $data = $request->validate([
        'logo' => 'image|mimes:jpg,png,jpeg,svg|max:2048|',
        'name' => 'min:2|required|string|unique:trainining_centers,name,'.$traininingCenter,
        'code' => 'required|string|unique:trainining_centers,code,'.$traininingCenter]);
        $TrainingCenter->update($data);
        return redirect()->route('TrainingCenter.index')->with('message', 'Training Center updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TraininingCenter  $traininingCenter
     * @return \Illuminate\Http\Response
     */
    public function destroy(TraininingCenter $traininingCenter)
    {
        //
    }
}
