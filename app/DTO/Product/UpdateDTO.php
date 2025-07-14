<?php

namespace App\DTO\Product;

use App\DTO\BaseDTO;
use App\Http\Requests\Admin\Products\UpdateRequest;

class UpdateDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $description,
        public string $image,
        public float $price,
        public array $categoriesIds
    )
    {
        
    }

    public static function createFromRequest(UpdateRequest $request): self
    {
        return new self(
            $request->name,
            $request->description,
            $request->image,
            $request->price,
            $request->categories_ids
        );
    }
}
