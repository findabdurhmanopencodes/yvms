<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Facades\Datatables;
class PermissionController extends Controller
{
    public function __construct()
    {

        // $this->authorizeResource(Permission::class,'permission');

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!Auth::user()->can('Permission.index')){
            return abort(403);
        }
        // $user = Auth::user();
        // if(!$user->hasRole('super-admin') && !$user->hasPermissionTo('permission.viewAll')){
        //     abort(403);
        // }
        if ($request->ajax()) {
            return datatables()->of(Permission::select())->make(true);
        }
        $permissions = Permission::all();
        return view('permission.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(!Auth::user()->can('Permission.store')){
            return abort(403);
        }
        return view('permission.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(!Auth::user()->can('Permission.store')){
            return abort(403);
        }
        //
        // if(!Auth::user()->can('permission.create')){
        //     return abort(403);
        // }
        $request->validate(['name' => 'required|string|unique:permissions,name']);
        Permission::create(['name' => $request->get('name')]);
        return redirect()->route('permission.index')->with('message', 'Permission created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        if(!Auth::user()->can('Permission.update')){
            return abort(403);
        }
        return view('permission.create',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permission)
    {
        if(!Auth::user()->can('Permission.update')){
            return abort(403);
        }
        $data = $request->validate(['name' => 'required|string|unique:permissions,name,'.$permission->id]);
        $permission->update($data);
        return redirect()->route('permission.index')->with('message', 'Permission created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,Permission $permission)
    {
        if(!Auth::user()->can('Permission.destroy')){
            return abort(403);
        }
        $permission->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }
}
