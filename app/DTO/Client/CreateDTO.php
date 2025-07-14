<?php

namespace App\DTO\Client;

use App\DTO\BaseDTO;
use App\Http\Requests\Shop\Auth\SignUpRequest;

class CreateDTO extends BaseDTO
{
    public function __construct(
        public string $email,
        public string $password
    )
    {
        
    }

    public static function createFromRequest(SignUpRequest $request): self
    {
        return new self(
            $request->email,
            $request->password
        );
    }
}
