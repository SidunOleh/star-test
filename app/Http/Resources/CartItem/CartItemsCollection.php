<?php

namespace App\Http\Resources\CartItem;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class CartItemsCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        $data = [];
        foreach ($this->collection as $i => $cartItem) {
            $data[$i] = new CartItemResource($cartItem);
        }

        return $data;
    }
}
