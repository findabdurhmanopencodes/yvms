<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingCenterBasedPermissionRequest;
use App\Http\Requests\UpdateTrainingCenterBasedPermissionRequest;
use App\Models\CindicationRoom;
use App\Models\TrainingCenterBasedPermission;
use App\Models\TrainingSession;
use App\Models\TraininingCenter;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class TrainingCenterBasedPermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreTrainingCenterBasedPermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingCenterBasedPermissionRequest $request, TrainingSession $trainingSession)
    {
        $data = $request->validated();
        $permission = Permission::findById($data['permission_id']);
        $trainingCenterBasedPermissionQuery = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('user_id', $data['user_id'])->where('trainining_center_id', $data['training_center_id'])->where('permission_id', $data['permission_id'])->where('permission_id', $data['permission_id']);
        $trainingCenterBasedPermissionCount = $trainingCenterBasedPermissionQuery->count();
        if ($trainingCenterBasedPermissionCount == 0) {
            $validData = [
                'training_session_id' => $trainingSession->id,
                'user_id' => $data['user_id'],
                'trainining_center_id' => $data['training_center_id'],
                'permission_id' => $data['permission_id'],
            ];
            if(isset($data['cindication_room_id'])){

            if($data['cindication_room_id']!=null){
                $validData['cindication_room_id'] = $data['cindication_room_id'];
            }
            }
            TrainingCenterBasedPermission::create($validData);
        } else {
            $trainingCenterBasedPermissionQuery->latest()->first()->delete();
            return redirect()->back()->with(['message' => 'User role removed successfully']);
        }
        return redirect()->back()->with(['message' => 'User role added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingCenterBasedPermission  $trainingCenterBasedPermission
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingCenterBasedPermission $trainingCenterBasedPermission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingCenterBasedPermission  $trainingCenterBasedPermission
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingCenterBasedPermission $trainingCenterBasedPermission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingCenterBasedPermissionRequest  $request
     * @param  \App\Models\TrainingCenterBasedPermission  $trainingCenterBasedPermission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingCenterBasedPermissionRequest $request, TrainingCenterBasedPermission $trainingCenterBasedPermission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingCenterBasedPermission  $trainingCenterBasedPermission
     * @return \Illuminate\Http\Response
     */
    public function destroy(TrainingCenterBasedPermission $trainingCenterBasedPermission)
    {
        //
    }

    public function remove(TrainingSession $trainingSession, TraininingCenter $training_center, CindicationRoom $cindicationRoom, User $user, Permission $permission)
    {
        $tcbp = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('user_id', $user->id)->where('trainining_center_id', $training_center->id)->where('cindication_room_id', $cindicationRoom->id)->where('permission_id', $permission->id);
        if($tcbp->first()){
            $tcbp->first()->delete();
        }
        return redirect()->back()->with('message','Removed successfully');
    }
}
