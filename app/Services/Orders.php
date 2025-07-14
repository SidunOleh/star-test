<?php

namespace App\Services;

use App\DTO\Order\CreateDTO;
use App\Enums\OrderStatus;
use App\Events\OrderCreated;
use App\Exceptions\CartIsEmptyException;
use App\Models\Client;
use App\Models\Order;
use App\Repositories\OrderItemRepository;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\DB;

class Orders
{
    public function __construct(
        private Cart $cart,
        private OrderRepository $orderRepository,
        private OrderItemRepository $orderItemRepository
    )
    {
        
    }

    public function create(Client $client, CreateDTO $dto): Order
    {
        if ($this->cart->isEmpty()) {
            throw new CartIsEmptyException();
        }

        DB::beginTransaction();

        $order = $this->orderRepository->create([
            'client_id' => $client->id,
            'comment' => $dto->comment,
            'status' => OrderStatus::Pending,
            'total_amount' => $this->cart->totalAmount(),
        ]);

        foreach ($this->cart->getCartItems() as $cartItem) {
            $this->orderItemRepository->create([
                'order_id' => $order->id,
                'product_id' => $cartItem->product->id,
                'name' => $cartItem->product->name,
                'price' => $cartItem->product->price,
                'quantity' => $cartItem->quantity,
            ]);
        }

        DB::commit();

        $this->cart->emptyCart();

        OrderCreated::dispatch($order);

        return $order;
    }
}