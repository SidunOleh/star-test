<?php

namespace App\Http\Controllers\Shop\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Cart\ChangeQuantityRequest;
use App\Models\CartItem;
use App\Services\Cart;
use Illuminate\Http\Request;

class ChangeQuantityController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke(CartItem $cartItem, ChangeQuantityRequest $request)
    {
        $this->cart->changeQuantity($cartItem, $request->quantity);

        return response(['message' => 'OK']);
    }
}
