<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTranslationTextRequest;
use App\Http\Requests\UpdateTranslationTextRequest;
use App\Models\Language;
use App\Models\TranslationText;
use Illuminate\Validation\ValidationException;

class TranslationTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $translationTexts = TranslationText::all();
        $langs = Language::all();
        return view('translation.index',compact('translationTexts','langs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        Language::where('name','English')->firstOr(function(){
            Language::create(['name'=>'English']);
        });
        Language::where('name','Amharic')->firstOr(function(){
            Language::create(['name'=>'Amharic']);
        });
        Language::where('name','Afaan Oromoo')->firstOr(function(){
            Language::create(['name'=>'Afaan Oromoo']);
        });
        Language::where('name','Afar')->firstOr(function(){
            Language::create(['name'=>'Afar']);
        });

        $translationText = null;
        $langs = Language::all();
        $translationTypes = TranslationText::TRANSLATION_TEXT_TYPES;
        return view('translation.create',compact('translationText','langs','translationTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTranslationTextRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTranslationTextRequest $request)
    {
        $data = $request->validated();
        $exist = TranslationText::where('translation_type',$data['translation_type'])->where('lang',$data['lang'])->first() != null;
        if($exist){
            throw ValidationException::withMessages(['lang','Please translation exist']);
        }
        TranslationText::create(
            $data
        );
        return redirect()->route('translation.index')->with('message','Translation created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TranslationText  $translationText
     * @return \Illuminate\Http\Response
     */
    public function show(TranslationText $translation)
    {
        $translationText = $translation;
        return view('translation.show',compact('translationText'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TranslationText  $translationText
     * @return \Illuminate\Http\Response
     */
    public function edit(TranslationText $translationText)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTranslationTextRequest  $request
     * @param  \App\Models\TranslationText  $translationText
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTranslationTextRequest $request, TranslationText $translationText)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TranslationText  $translationText
     * @return \Illuminate\Http\Response
     */
    public function destroy(TranslationText $translation)
    {
        $translation->delete();
        return redirect()->back()->with(['message','Translation text deleted successfully']);
    }
}
