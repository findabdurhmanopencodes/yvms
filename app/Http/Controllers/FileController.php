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

    // public function delete()
    // {
    //     return
    // }
    public static function fileUpload($file,$path = 'misc')
    {
        $fileModel = new File;
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($path, $fileName, 'public');
        $fileModel->name = time() . '_' . $file->getClientOriginalName();
        $fileModel->file_path = '/storage/' . $filePath;
        $fileModel->save();
        return $fileModel;
    }
}
