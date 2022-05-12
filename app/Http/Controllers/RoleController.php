<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Facades\Datatables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(Role::select())->make(true);
        }
        $user = Auth::user();
        // if(!$user->hasRole('super-admin') && !$user->hasPermissionTo('role.viewAll')){
        //     abort(403);
        // }
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // if(!Auth::user()->can('role.create')){
        //     return abort(403);
        // }
        $request->validate(['name' => 'required|string|unique:roles,name']);
        Role::create(['name' => $request->get('name')]);
        return redirect()->route('role.index')->with('message', 'Role created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
        $permissions = $role->permissions()->get();
        $freePermissions = DB::table('permissions')->whereNotIn('id', $role->permissions()->pluck('id'))->get();
        // dd($freePermissions);
        // dd($permissions);
        return view('role.show', compact('role', 'permissions', 'freePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('role.create', compact('role'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $data = $request->validate(['name' => 'required|string|unique:roles,name,' . $role->id]);
        $role->update($data);
        return redirect()->route('role.index')->with('message', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Role $role)
    {
        $role->delete();
        if ($request->ajax()) {
            return response()->json(array('msg' => 'deleted successfully'), 200);
        }
    }

    public function permissions(Request $request, Role $role)
    {
        $permissions = $role->permissions()->get();
        if ($request->ajax()) {
            return datatables()->of($permissions)->make(true);
        }
        // return redirect(route('roles.permissions.index',['role'=>$role->role]));
    }

    public function givePermission(Request $request, Role $role)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        foreach ($role->permissions()->get() as $permission) {
            $role->revokePermissionTo($permission);
        }
        $request->validate(['permissions' => 'required']);
        $permissions = $request->get('permissions');
        foreach ($permissions as $permission) {
            $role->givePermissionTo(Permission::find($permission));
        }
        return redirect(route('role.show', ['role' => $role->id]));
    }

    public function revokePermission(Request $request, Role $role, Permission $permission)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        if ($role->hasPermissionTo($permission->name)) {
            $role->revokePermissionTo($permission->name);
        }
        if ($request->ajax()) {
            return response()->json(array('msg' => 'revoked successfully'), 200);
        }
        return redirect(route('roles.show', ['role' => $role->id]));
    }

    public function giveAllPermission(Role $role)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        $role->syncPermissions(Permission::all());
        return redirect()->back()->with('msg', 'all permission given');
    }
    public function removeAllPermission(Role $role)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        foreach ($role->permissions()->get() as $permission) {
            $role->revokePermissionTo($permission);
        }
        return redirect()->back()->with('msg', 'all permission removed');
    }
}
