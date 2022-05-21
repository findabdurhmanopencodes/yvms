<?php

namespace App\Http\Controllers;

use App\Models\TrainingDocument;
use App\Http\Requests\StoreTrainingDocumentRequest;
use App\Http\Requests\UpdateTrainingDocumentRequest;
use App\Models\Training;
use Illuminate\Validation\ValidationException;

class TrainingDocumentController extends Controller
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
     * @param  \App\Http\Requests\StoreTrainingDocumentRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTrainingDocumentRequest $request,Training $training)
    {
        $validDatas = $request->validated();
        $data['name'] = $validDatas['name'];
        if (!$request->document->isValid()) {
            throw ValidationException::withMessages(['document' => 'Unable to upload document please retry']);
        } else {
            $data['file_id'] = FileController::fileUpload($request->document,'training documents')->id;
        }
        $data['training_id'] = $training->id;
        TrainingDocument::create($data);
        return redirect()->back()->with('message','Training document uploaded successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TrainingDocument  $trainingDocument
     * @return \Illuminate\Http\Response
     */
    public function show(TrainingDocument $trainingDocument)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TrainingDocument  $trainingDocument
     * @return \Illuminate\Http\Response
     */
    public function edit(TrainingDocument $trainingDocument)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingDocumentRequest  $request
     * @param  \App\Models\TrainingDocument  $trainingDocument
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTrainingDocumentRequest $request, TrainingDocument $trainingDocument)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingDocument  $trainingDocument
     * @return \Illuminate\Http\Response
     */
    public function destroy(Training $training,TrainingDocument $trainingDocument)
    {
        $deleteFileStatus = FileController::deleteFile($trainingDocument?->file);
        $trainingDocument->delete();
        if($deleteFileStatus == 200){
            $message = 'Training document deleted successfully';
        }else{
            $message = 'Training document deleted successfully but document file not find';
        }
        return redirect()->back()->with('message',$message);
    }
}
