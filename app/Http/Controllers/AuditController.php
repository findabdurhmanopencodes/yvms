<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

use function PHPUnit\Framework\exactly;

class AuditController extends Controller
{
    //
    public function index(Request $request)
    {
        $path = app_path() . "/Models";
        // dd($path);

        function getModels($path)
        {
            $out = [];
            $results = scandir($path);
            foreach ($results as $result) {
                if ($result === '.' or $result === '..') continue;
                $filename = $path . '/' . $result;
                if (is_dir($filename)) {
                    $out = array_merge($out, getModels($filename));
                } else {
                    $out[] = substr($filename, 0, -4);
                }
            }
            return $out;
            // dd(explode('a',$file));
        }

        $audits = \OwenIt\Auditing\Models\Audit::query();
        if ($request->has('filter')) {
            $user = $request->get('user_id');
            $action = $request->get('action');
            $model = $request->get('model');
           $modelName="App\\".basename(dirname($model)) . "\\" . basename($model);


            if (!empty($user)) {
                $audits = $audits->where('user_id', $user);
            }
            if (!empty($action)) {
                $audits = $audits->where('event', $action);
            }
            if (!empty($model)) {
                $audits = $audits->where('auditable_type', $modelName);
            }
        }
        return view('audit.audit', ['audits' => $audits->orderBy('created_at', 'desc')->paginate(10), 'users' => User::all(),'models'=>getModels($path)]);
    }
}
