<?php

namespace App\Http\Controllers\Shop\Cart;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Cart\AddProductRequest;
use App\Http\Resources\CartItem\CartItemResource;
use App\Services\Cart;
use Illuminate\Http\Request;

class AddProductController extends Controller
{
    public function __construct(
        public Cart $cart
    )
    {
        
    }

    public function __invoke(AddProductRequest $request)
    {
        $cartItem = $this->cart->addProduct($request->product_id);
        
        return response(new CartItemResource($cartItem));
    }
}
