<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class Images
{
    public function upload(UploadedFile $uploaded): string
    {
        $path = $uploaded->store('images');

        $fullPath = "/storage/{$path}";

        return $fullPath;
    }
}