<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\UpdateFileRequest;
use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File as FacadesFile;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function __construct()
    {

        $this->authorizeResource(File::class, 'file');
    }

    public static function fileUpload($file, $path = 'misc')
    {
        $fileModel = new File;
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->storeAs($path, $fileName, 'public');
        $fileModel->name = time() . '_' . $file->getClientOriginalName();
        $fileModel->file_path = '/storage/' . $filePath;
        $fileModel->save();
        return $fileModel;
    }

    public static function deleteFile(File $file)
    {
        $filePath = public_path($file->file_path);
        if (FacadesFile::exists($filePath)) {
            unlink($filePath);
            return 200;
        }
        return 404;
    }
}
