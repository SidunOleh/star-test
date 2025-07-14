<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Auth\LogInRequest;
use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogInController extends Controller
{
    public function __invoke(LogInRequest $request)
    {
        if (! Auth::guard('admin')->attempt($request->validated())) {
            return response(['message' => 'Wrong email or password.',], 401);
        }

        return response(new UserResource(Auth::guard('admin')->user()));
    }
}
