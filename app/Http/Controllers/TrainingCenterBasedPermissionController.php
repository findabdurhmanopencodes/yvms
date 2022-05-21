<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTrainingCenterBasedPermissionRequest;
use App\Http\Requests\UpdateTrainingCenterBasedPermissionRequest;
use App\Models\TrainingCenterBasedPermission;
use App\Models\TrainingSession;
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
        $trainingCenterBasedPermissionQuery = TrainingCenterBasedPermission::where('training_session_id', $trainingSession->id)->where('user_id', $data['user_id'])->where('trainining_center_id', $data['training_center_id'])->where('permission_id', $data['permission_id']);
        $trainingCenterBasedPermissionCount = $trainingCenterBasedPermissionQuery->count();
        if ($trainingCenterBasedPermissionCount == 0) {
            TrainingCenterBasedPermission::create([
                'training_session_id' => $trainingSession->id,
                'user_id' => $data['user_id'],
                'trainining_center_id' => $data['training_center_id'],
                'permission_id' => $data['permission_id'],
            ]);
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
}
