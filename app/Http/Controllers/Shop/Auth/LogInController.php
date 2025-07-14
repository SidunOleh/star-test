<?php

namespace App\Http\Controllers\Shop\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Auth\LogInRequest;
use App\Http\Resources\Client\ClientResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogInController extends Controller
{
    public function __invoke(LogInRequest $request)
    {
        if (! Auth::attempt($request->validated())) {
            return response(['message' => 'Wrong email or password.',], 401);
        }

        return response(new ClientResource(Auth::user()));
    }
}
