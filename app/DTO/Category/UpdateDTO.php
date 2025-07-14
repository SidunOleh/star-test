<?php

namespace App\DTO\Category;

use App\DTO\BaseDTO;
use App\Http\Requests\Admin\Categories\UpdateRequest;

class UpdateDTO extends BaseDTO
{
    public function __construct(
        public string $name
    )
    {
        
    }

    public static function createFromRequest(UpdateRequest $request): self
    {
        return new self(
            $request->name
        );
    }
}
