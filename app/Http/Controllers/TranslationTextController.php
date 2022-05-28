<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTranslationTextRequest;
use App\Http\Requests\UpdateTranslationTextRequest;
use App\Models\TranslationText;

class TranslationTextController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTranslationTextRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTranslationTextRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TranslationText  $translationText
     * @return \Illuminate\Http\Response
     */
    public function show(TranslationText $translationText)
    {
        //
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
    public function destroy(TranslationText $translationText)
    {
        //
    }
}
