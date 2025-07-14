<?php

namespace App\DTO\Order;

use App\DTO\BaseDTO;
use App\Http\Requests\Shop\Orders\StoreRequest;

class CreateDTO extends BaseDTO
{
    public function __construct(
        public ?string $comment
    )
    {
        
    }

    public static function createFromRequest(StoreRequest $request): self
    {
        return new self(
            $request->comment
        );
    }
}
