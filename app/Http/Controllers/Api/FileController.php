<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Interfaces\FileRepositoryInterface;
use App\Models\File;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    private FileRepositoryInterface $fileRepository;

    public function __construct(FileRepositoryInterface $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }
    
    public function uploadFile($id, Request $request)
    {

        try {
            $response = $this->fileRepository->uploadFile($id, $request);
            return response()->json($response);
        } catch (\Exception $exception) {
            return response()->json(['error' => $exception->getMessage()]);
        }
    }

    public function deleteFile($id)
    {
        $response = $this->fileRepository->deleteFile($id);
        return response()->json($response);
    }
}
