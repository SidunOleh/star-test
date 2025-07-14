<?php

namespace App\Repositories;

use App\Models\CartItem;

class CartItemRepository extends BaseRepository
{
    protected string $model = CartItem::class;
}