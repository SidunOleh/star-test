<?php

namespace App\DTO\Category;

use App\DTO\BaseDTO;
use App\Http\Requests\Admin\Categories\StoreRequest;

class CreateDTO extends BaseDTO
{
    public function __construct(
        public string $name
    )
    {
        
    }

    public static function createFromRequest(StoreRequest $request): self
    {
        return new self(
            $request->name,
        );
    }
}
