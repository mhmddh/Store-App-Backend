<?php

namespace App\Interfaces;
use Illuminate\Http\Request;

interface FileRepositoryInterface
{
    public function uploadFile($fileId,Request $request);
    public function deleteFile($fileId);
}
