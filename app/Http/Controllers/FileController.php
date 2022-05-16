<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use Illuminate\Http\Request;

class FileController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(File::class,'file');

    }

    public static function fileUpload($file)
    {
        $fileModel = new File;
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs('uploads/bsc_document', $fileName, 'public');
        $fileModel->name = time() . '_' . $file->getClientOriginalName();
        $fileModel->file_path = '/storage/' . $filePath;
        $fileModel->save();
        return $fileModel;
    }
}
