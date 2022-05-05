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
        $roles = Role::all();
        return view('user.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255','min:3'],
            'father_name' => ['required', 'string', 'max:255','min:3'],
            'grand_father_name' => ['required', 'string', 'max:255','min:3'],
            'dob' => ['required', 'date', 'max:255'],
            'gender' => ['required', 'string', 'in:M,F'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
        $date = new DateTime($request->get('dob'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $date = new Carbon();
        $dob_GC = DateTimeFactory::of($year, $month, $day)->toGregorian()->format(DATE_COOKIE).PHP_EOL;
        $before = $date->subYears(18)->format('Y-m-d');
        $request->validate([
            'dob' => 'before:'.$before,
        ]);
        dd('ab');

        $user = User::create([
            'first_name' => $request->first_name,
            'father_name' => $request->father_name,
            'grand_father_name' => $request->grand_father_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }
    //
    public function profile($user = null)
    {
        if ($user == null) {
            $user = Auth::user();
        }
        return view('profile.show', compact('user'));
    }
}
