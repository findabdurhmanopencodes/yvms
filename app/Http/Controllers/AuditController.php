<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuditController extends Controller
{
    //
    public function index(Request $request)
    {
        $audits = \OwenIt\Auditing\Models\Audit::query();
        if ($request->has('filter')) {
            $user = $request->get('user_id');
            $action = $request->get('action');

            if (!empty($user)) {
                $audits = $audits->where('user_id', $user);
            }
            if (!empty($action)) {
                $audits = $audits->where('event', $action);
            }

        }
        return view('audit.audit', ['audits' => $audits->orderBy('created_at', 'desc')->paginate(10),'users'=>User::all()]);
    }
}
