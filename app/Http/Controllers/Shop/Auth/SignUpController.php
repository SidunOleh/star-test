<?php

namespace App\Http\Controllers\Shop\Auth;

use App\DTO\Client\CreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Auth\SignUpRequest;
use App\Http\Resources\Client\ClientResource;
use App\Services\Clients;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SignUpController extends Controller
{
    public function __construct(
        public Clients $clients
    )
    {
        
    }

    public function __invoke(SignUpRequest $request)
    {
        $client = $this->clients->create(CreateDTO::createFromRequest(($request)));

        Auth::login($client);

        return response(new ClientResource($client));
    }
}
