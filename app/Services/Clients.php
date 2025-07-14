<?php

namespace App\Services;

use App\DTO\Client\CreateDTO;
use App\Models\Client;
use App\Repositories\ClientRepository;

class Clients
{
    public function __construct(
        private ClientRepository $clientRepository
    )
    {
        
    }

    public function create(CreateDTO $dto): Client
    {
        $client = $this->clientRepository->create($dto->toArray());

        return $client;
    }
}