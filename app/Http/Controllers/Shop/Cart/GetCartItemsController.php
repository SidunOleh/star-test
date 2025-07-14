<?php

namespace App\Http\Controllers\Shop\Cart;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItem\CartItemsCollection;
use App\Services\Cart;
use Illuminate\Http\Request;

class GetCartItemsController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke()
    {
        $cartItems = $this->cart->getCartItems();

        return response(new CartItemsCollection($cartItems));
    }
}
