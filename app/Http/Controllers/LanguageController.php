<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    //

    public function store(Request $request)
    {
        $data = $request->validate([
            'language' => ['required','string','unique:languages,name']
        ]);
        $data['name'] = $data['language'];
        unset($data['language']);
        Language::create($data);
        return redirect()->back()->with('message','Language created successfully');
    }

    public function destroy(Language $language)
    {
        $language->delete();
        return redirect()->back()->with('message','Language deleted successfully');
    }
}
