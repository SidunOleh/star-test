<?php

namespace App\Services;

use App\Models\CartItem;
use App\Models\Client;
use App\Repositories\CartItemRepository;
use Illuminate\Container\Attributes\CurrentUser;
use Illuminate\Database\Eloquent\Collection;

class Cart
{
    private Client $client;

    private Collection $cartItems;

    private CartItemRepository $cartItemRepository;

    public function __construct(
        #[CurrentUser] Client $client,
        CartItemRepository $cartItemRepository
    )
    {
        $this->client = $client;
        $this->cartItemRepository = $cartItemRepository;

        $this->refreshCartItems();
    }

    public function refreshCartItems(): void
    {
        $this->cartItems = $this->cartItemRepository->getAll([
            'client_id' => [$this->client->id]
        ], ['product']);
    }

    public function addProduct(int $productId): CartItem
    {
        $cartItem = $this->cartItemRepository->create([
            'client_id' => $this->client->id,
            'product_id' => $productId,
            'quantity' => 1,
        ]);

        $this->refreshCartItems();

        return $cartItem;
    }

    public function changeQuantity(CartItem $cartItem, int $quantity): void
    {
        $this->cartItemRepository->update($cartItem->id, ['quantity' => $quantity]);

        $this->refreshCartItems();
    }

    public function deleteCartItem(CartItem $cartItem): void
    {
        $this->cartItemRepository->delete($cartItem->id);

        $this->refreshCartItems();
    }

    public function emptyCart(): void
    {
        $cartItemsIds = $this->client->cartItems->pluck('id')->toArray();

        $this->cartItemRepository->deleteAll($cartItemsIds);

        $this->refreshCartItems();
    }

    public function totalAmount(): float
    {
        $totalAmount = $this->cartItems->reduce(function (float $acc, CartItem $cartItem) {
            return $acc += $cartItem->quantity * $cartItem->product->price;
        }, 0);

        return $totalAmount;
    }

    public function isEmpty(): bool
    {
        return ! $this->cartItems->count();
    }

    public function getCartItems(): Collection
    {
        return $this->cartItems;
    }
}