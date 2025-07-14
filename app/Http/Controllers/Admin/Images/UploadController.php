<?php

namespace App\Http\Controllers\Admin\Images;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Images\UploadRequest;
use App\Services\Images;
use Illuminate\Http\Request;

class UploadController extends Controller
{
    public function __construct(
        public Images $images
    )
    {
        
    }

    public function __invoke(UploadRequest $request)
    {
        $path = $this->images->upload($request->image);

        return response(['path' => $path]);
    }
}
