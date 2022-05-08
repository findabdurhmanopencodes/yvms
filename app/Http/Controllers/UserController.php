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
use Illuminate\Validation\ValidationException;
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
        $userData = $request->validate([
            'first_name' => ['required', 'string', 'max:255','min:3'],
            'father_name' => ['required', 'string', 'max:255','min:3'],
            'grand_father_name' => ['required', 'string', 'max:255','min:3'],
            'dob' => ['required', 'date'],
            'gender' => ['required', 'string', 'in:M,F'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required'],
        ]);
        $date = new DateTime($request->get('dob'));
        $year = $date->format('Y');
        $month = $date->format('m');
        $day = $date->format('d');
        $date = new Carbon();
        $dob_GC = DateTimeFactory::of($year, $month, $day)->toGregorian();
        $after = Carbon::now()->subYears(100);
        $before = $date->subYears(18);
        if(!Carbon::createFromDate($dob_GC)->isBetween($after, $before)){
            $afterET = DateTimeFactory::fromDateTime($after)->format('d/m/Y');
            $beforeET = DateTimeFactory::fromDateTime($before)->format('d/m/Y');
            $validationException = ValidationException::withMessages([
                'dob' => 'The Date of Birth must be a date after ' . $afterET . ' before ' . $beforeET,
            ]);
            throw $validationException;
        }
        if($request->role == Role::findByName('applicant')){
            return abort(404);
        }
        $userData['dob'] = $dob_GC;
        $user = User::create($userData);
        event(new Registered($user));
        $user->assignRole(Role::findById($request->role));
        return redirect(route('user.index'))->with('message','User registered successfully');
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
