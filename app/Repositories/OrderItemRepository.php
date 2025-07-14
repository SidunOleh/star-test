<?php

namespace App\Repositories;

use App\Models\OrderItem;

class OrderItemRepository extends BaseRepository
{
    protected string $model = OrderItem::class;
}