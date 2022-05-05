<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        // if(!Auth::user()->can('user.index')){
        //     return abort(403);
        // }
        $users = User::paginate(20);
        return view('user.index',compact('users'));
    }

    public function create()
    {
        // if(!Auth::user()->can('user.create')){
        //     return abort(403);
        // }
        $roles = Role::all();
        return view('user.create',compact('roles'));
    }
    //
    public function profile($user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }
        return view('profile.show',compact('user'));
    }
}
