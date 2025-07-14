<?php

namespace App\Http\Controllers\Shop\Cart;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Services\Cart;
use Illuminate\Http\Request;

class DeleteItemController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke(CartItem $cartItem)
    {
        $this->cart->deleteCartItem($cartItem);

        return response(['message' => 'OK']);
    }
}
