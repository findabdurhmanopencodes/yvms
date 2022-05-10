<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rules;
use Andegna\Validator\DateValidator;
use Andegna\DateTimeFactory;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Models\Permission;
use Yajra\Datatables\Facades\Datatables;

class UserController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return datatables()->of(User::select())->make(true);
        }
        // if(!Auth::user()->can('user.index')){
        //     return abort(403);
        // }
        $users = User::paginate(20);
        return view('user.index', compact('users'));
    }

    public function create()
    {
        // if(!Auth::user()->can('user.create')){
        //     return abort(403);
        // }
        $user = null;
        $roles = Role::all();
        return view('user.create', compact('roles', 'user'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('user.create', compact('user', 'roles'));
    }

    public function show(User $user)
    {
        $permissions = $user->permissions()->get();
        $freePermissions = DB::table('permissions')->whereNotIn('id', $user->permissions()->pluck('id'))->get();
        return view('user.show', compact('user', 'permissions', 'freePermissions'));
    }

    public function update(Request $request, User $user)
    {
        $userData = $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'min:3'],
            'father_name' => ['required', 'string', 'max:255', 'min:3'],
            'grand_father_name' => ['required', 'string', 'max:255', 'min:3'],
            'dob' => ['required', 'date_format:d/m/Y'],
            'gender' => ['required', 'string', 'in:M,F'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required'],
        ]);
        if (isset($request->password)) {
            $userData['password'] = $request->validate([
                'password' => ['required', 'confirmed', Rules\Password::defaults()],
            ])['password'];
            $userData['password'] = Hash::make($userData['password']);
        }
        $date = DateTime::createFromFormat('d/m/Y', $request->get('dob'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $date = new Carbon();
        $dob_GC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $after = Carbon::now()->subYears(100);
        $before = $date->subYears(18);
        if (!Carbon::createFromDate($dob_GC)->isBetween($after, $before)) {
            $afterET = DateTimeFactory::fromDateTime($after)->format('d/m/Y');
            $beforeET = DateTimeFactory::fromDateTime($before)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'dob' => 'The Date of Birth must be a date after ' . $afterET . ' before ' . $beforeET,
            ]);
            throw $validationException;
        }
        if ($request->role == Role::findByName('volunteer')) {
            return abort(404);
        }
        $userRoleName = $user->getRole()?->name;
        if ($userRoleName)
            $user->removeRole($userRoleName);
        $user->assignRole($userData['role']);
        $userData['dob'] = $dob_GC;
        $oldEmail = $user->email;
        $user->update($userData);
        if ($user->email != $oldEmail) {
            $user->email_verified_at = null;
            $user->update();
            $user->save();
            event(new Registered($user));
        }
        return redirect()->back()->with('message', 'User Updated successfully');
    }

    public function store(Request $request)
    {
        $userData = $request->validate([
            'first_name' => ['required', 'string', 'max:255', 'min:3'],
            'father_name' => ['required', 'string', 'max:255', 'min:3'],
            'grand_father_name' => ['required', 'string', 'max:255', 'min:3'],
            'dob' => ['required', 'date_format:d/m/Y'],
            'gender' => ['required', 'string', 'in:M,F'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required'],
        ]);
        $date = DateTime::createFromFormat('d/m/Y', $request->get('dob'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $date = new Carbon();
        $dob_GC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $after = Carbon::now()->subYears(100);
        $before = $date->subYears(18);
        if (!Carbon::createFromDate($dob_GC)->isBetween($after, $before)) {
            $afterET = DateTimeFactory::fromDateTime($after)->format('d/m/Y');
            $beforeET = DateTimeFactory::fromDateTime($before)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'dob' => 'The Date of Birth must be a date after ' . $afterET . ' before ' . $beforeET,
            ]);
            throw $validationException;
        }
        if ($request->role == Role::findByName('volunteer')) {
            return abort(404);
        }
        $userData['dob'] = $dob_GC;
        $userData['password'] = Hash::make($userData['password']);
        $user = User::create($userData);
        $user->assignRole(Role::findById($request->role));
        event(new Registered($user));
        return redirect(route('user.index'))->with('message', 'User registered successfully');
    }
    //
    public function profile($user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }
        return view('profile.show', compact('user'));
    }



    public function givePermission(Request $request, User $user)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        foreach ($user->permissions()->get() as $permission) {
            $user->revokePermissionTo($permission);
        }
        $request->validate(['permissions' => 'required']);
        $permissions = $request->get('permissions');
        foreach ($permissions as $permission) {
            $user->givePermissionTo(Permission::find($permission));
        }
        return redirect(route('user.show', ['user' => $user->id]));
    }

    public function revokePermission(Request $request, User $user)
    {
        // if(!Auth::user()->can('role.permission.assign')){
        //     return abort(403);
        // }
        $permissions = $request->reset_permissions;
        foreach ($permissions as $permissionId) {
            $permission = Permission::findById($permissionId);
            if ($user->hasPermissionTo($permission)) {
                $user->revokePermissionTo($permission);
            }
        }
        return redirect(route('user.show', ['user' => $user->id]))->with('message', 'Permission revoked successfully');
    }

    public function userPermissions(Request $request, User $user)
    {
        if ($request->ajax()) {
            return datatables()->of($user->permissions())->make(true);
        }
        return $user->permissions;
    }


    public function giveAllPermission(User $user)
    {
        // if(!Auth::user()->can('user.permission.assign')){
        //     return abort(403);
        // }
        $user->syncPermissions(Permission::all());
        return redirect()->back()->with('message', 'All permission given');
    }
    public function removeAllPermission(User $user)
    {
        // if(!Auth::user()->can('user.permission.assign')){
        //     return abort(403);
        // }
        foreach ($user->permissions()->get() as $permission) {
            $user->revokePermissionTo($permission);
        }
        return redirect()->back()->with('message', 'All permission removed');
    }
}
