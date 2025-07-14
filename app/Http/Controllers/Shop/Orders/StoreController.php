<?php

namespace App\Http\Controllers\Shop\Orders;

use App\DTO\Order\CreateDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Shop\Orders\StoreRequest;
use App\Http\Resources\Order\OrderResource;
use App\Services\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __construct(
        public Orders $orders
    )
    {
        
    }

    public function __invoke(StoreRequest $request)
    {
        $order = $this->orders->create(Auth::user(), CreateDTO::createFromRequest($request));

        return response(new OrderResource($order));
    }
}
