<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    //
    public function profile($user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }
        return view('profile.show',compact('user'));
    }
}
